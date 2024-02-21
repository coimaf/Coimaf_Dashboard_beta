
<?php


Function prepara_stringa(string $ingresso)
{
    $prepara_stringa = str_replace("'", "''", $ingresso);
    return $prepara_stringa;
}







$DEBUG=1;



/***************************** CONFIGURAZIONE ******************************/

$numero_utente_arca = 104;    //numero utente arca di default
$nome_utente ='Default user';
$tipo_doumento = 'RAP';
$numero_righe_enable = 0;
$totaleImponibile = 0;
$totaleImponibileLordo = 0;
$flag_errore = 0;
$error_code = 0;
$error_desc = 'noerror';
$query_error = 'noquery';
$query_error2 = 'noquery';

$Cd_aliquota = '227';
$Aliquota = '22.0';
$Cd_CGConto = '51010101001';
$trasporto = '01';
$asp_beni = 'AV';
$porto = '';
$spedizione = '';
$spedizione = '';
$prodotto_default = 'MAN.ASSISTENZA';
$i=0;


/***************************** CONNESSIONE MYSQL ******************************/
$nomehost = "192.168.2.92:3306";
$nomeuser = "suitecrmuser";
$password = "Coimaenter2020$";
$database = "suitecrm";

echo "<p>Connessione server MySQL in corso...";
$conn_MYSQL = mysqli_connect($nomehost,$nomeuser,$password,$database);

if (mysqli_connect_errno())
{
    echo "<br>    Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{
    echo "<br> MySQL connected.";
}
$time_start=time();

/***************************** VERIFICA PRESENZA DATI DA IMPORTARE ******************************/

$queryMYSQL1 = "SELECT * FROM cases WHERE state = 'to_bill'";
$resultMYSQL1 = mysqli_query($conn_MYSQL, $queryMYSQL1);    //order executes
$num_row = mysqli_num_rows($resultMYSQL1);   
       

if ($num_row > 0)
{
    for ($v=0; $v<$num_row; $v++)
    {
        echo "<p>******************************************************************<p>Iterazione V=".$v."<p>";
        $rowMYSQL1 = mysqli_fetch_assoc($resultMYSQL1);
    
        $clienteDocumento = $rowMYSQL1["account_id"];
        $numero_tt = $rowMYSQL1["case_number"];
           
        $queryMYSQL5 = "SELECT * FROM cases_aos_quotes_1_c WHERE cases_aos_quotes_1cases_ida = '".$rowMYSQL1["id"]."'";
        $resultMYSQL5 = mysqli_query($conn_MYSQL, $queryMYSQL5);    //order executes
        $rowMYSQL5 = mysqli_fetch_assoc($resultMYSQL5);
        echo "<p>queryMYSQL5: ". $queryMYSQL5 . "<br>";
        echo "<p>id: ". $rowMYSQL1["id"] . "<br>";
       
        $queryMYSQL6 = "SELECT * FROM aos_quotes WHERE id = '".$rowMYSQL5["cases_aos_quotes_1aos_quotes_idb"]."'";
        $resultMYSQL6 = mysqli_query($conn_MYSQL, $queryMYSQL6);    //order executes
        $rowMYSQL6 = mysqli_fetch_assoc($resultMYSQL6);
        echo "<p>queryMYSQL6: ". $queryMYSQL6 . "<br>";
        echo "<p>cases_aos_quotes_1aos_quotes_idb: ". $rowMYSQL5["cases_aos_quotes_1aos_quotes_idb"] . "<br>";
       
        $queryMYSQL7 = "SELECT * FROM cases_cstm WHERE id_c = '".$rowMYSQL1["id"]."'";
        $resultMYSQL7 = mysqli_query($conn_MYSQL, $queryMYSQL7);    //order executes
        $rowMYSQL7 = mysqli_fetch_assoc($resultMYSQL7);
        echo "<p>queryMYSQL7: ". $queryMYSQL7 . "<br>";
       
       
        if (mysqli_num_rows($resultMYSQL5) != 0)
        {
            $queryMYSQL2 = "SELECT * FROM aos_products_quotes WHERE parent_id = '".$rowMYSQL5["cases_aos_quotes_1aos_quotes_idb"]."'";
            $resultMYSQL2 = mysqli_query($conn_MYSQL, $queryMYSQL2);    //order executes
            echo "<p>queryMYSQL2: ". $queryMYSQL2 . "<br>";
       
       
            $numero_righe = mysqli_num_rows($resultMYSQL2)+1;
           
            echo "<p>Numero righe di ricambi: ". mysqli_num_rows($resultMYSQL2) . "<br>";
        }
        else
        {
            $numero_righe = 1;
            echo "<p>Nessuna riga di ricambi!<br>";
        }
       
        $numero_righe_enable = $numero_righe;       
       
        echo "<p>Numero righe documento: ". $numero_righe . "<br>";
       
       
        if ((float)$rowMYSQL7["pagato_c"] == 1)
        {
            $accontoperc = 100;
        }
        else
        {
            $accontoperc = 0;
        }
       
        $accontofissov = 0;//$rowMYSQL7["acconto_fisso"]+0;
        $accontov = 0;//$rowMYSQL7["acconto_fisso"]+0;
        $abbuonov = 0;//$rowMYSQL7["abbuono"]+0;
        $manodopera_ore = $rowMYSQL7["ore_assistenza_c"]+1-1;
        $tecnico = $rowMYSQL7["tecnico_c"];
        $datatime_tt = strtotime($rowMYSQL7["data_intervento_c"]);
        $data_tt = date( 'Y-m-d', $datatime_tt );

        $note_riferimento = "PROBLEMA: \n" .$rowMYSQL1["description"]." \n\n\n SOLUZIONE: \n ".$rowMYSQL1["resolution"] . " \n\n\n TECNICO: ".$tecnico;
       
        //*********************************** CONNESSIONE AL DB SQL *******************************
        // Dati connessione Database
        $serverName = "192.168.2.12\WKI, 52758";
        $connectionOptions = array(
            "database" => "ADB_COIMAF",
            "uid" => "sa",
            "pwd" => "SiStEmA2006!"
        );
        $data = array();

        // Establishes the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn === false)
        {
            die(formatErrors(sqlsrv_errors()));
        }


        /***************************** TESTA DOCUMENTO ******************************/
        //Formo la query per cercare l'ultimo numero di documento
        $tsqlDOTes = "SELECT MAX(NumeroDoc) as Massimo FROM dbo.DOTes WHERE Cd_Do = '" . $tipo_doumento . "' AND EsAnno = '" . date('Y') . "'";
       
       
        // Cerco i dati del cliente
        $tsqlDOTcf = "SELECT * FROM dbo.CF WHERE Cd_CF = '" . $clienteDocumento ."'";
        $stmtDOTcf = sqlsrv_query($conn, $tsqlDOTcf, array(), array( "Scrollable" => 'static' ));
        $rowCF = sqlsrv_fetch_array($stmtDOTcf, SQLSRV_FETCH_ASSOC);
        echo $tsqlDOTcf;
       
        $codicepagamento = $rowCF["Cd_PG"];
       
        $bancasconto = $rowCF["Cd_CGConto_Banca"];
        if ($bancasconto  == '')
        {
             $bancasconto = "NULL";
        }
        else
        {
             $bancasconto = "'".$bancasconto."'";
        }

        // Executes the query
        $stmtDOTes = sqlsrv_query($conn, $tsqlDOTes, array(), array( "Scrollable" => 'static' ));
        if ($DEBUG) echo "<br>QUERY SQL DOTes: ".sqlsrv_num_rows($stmtDOTes);
        // Individuo l'ultimo numero di documento di tipo RAP utilizzato
        $row = sqlsrv_fetch_array($stmtDOTes, SQLSRV_FETCH_ASSOC);

        $newDocNum = (int)($row["Massimo"])+1;    //Nuovo numero di documento

        //Preparo i dati per l'inserimento del nuovo documento
        $dataDocumento = "".date('Y-m-d')."T".date('H:i:s');
        $EsercizioYear = "".date('Y');
        if ($DEBUG) echo "<br>Ultimo numero documento rilevato:".$row["Massimo"];
        if ($DEBUG) echo "<br>Nuovo numero documento:".$newDocNum;
        if ($DEBUG) echo "<br>Numero righe:".$numero_righe_enable;
        if ($DEBUG) echo "<br>Numero utente ARCA:".$numero_utente_arca." (".$nome_utente.")";
        if ($DEBUG) echo "<br>Data documento:".$dataDocumento;
        if ($DEBUG) echo "<br>Esercizio:".$EsercizioYear;
        if ($DEBUG) echo "<br>Codice Pagamento:".$codicepagamento;
        if ($DEBUG) echo "<br>Banca di sconto:".$bancasconto;
        if ($DEBUG) echo "<br>Acconto percentuale:".$accontoperc;
        if ($DEBUG) echo "<br>Acconto fisso V:".$accontofissov;
        if ($DEBUG) echo "<br>Acconto V:".$accontov;
        if ($DEBUG) echo "<br>Abbuono V:".$abbuonov;
        if ($DEBUG) echo "<br>Numero tiket:".$numero_tt;
        if ($DEBUG) echo "<br>Data intervento:".$data_tt;
        if ($DEBUG) echo "<br>Note:".$note_riferimento;
       
        $tsqlDOTesINSERT = "INSERT INTO dbo.DOTes "
        . "(Cd_Do, TipoDocumento, DoBitMask, Cd_CF, CliFor, Cd_CN, Contabile, TipoFattura, ImportiIvati, IvaSospesa, Esecutivo, Prelevabile, Modificabile, ModificabilePdf, "
        . "NumeroDoc, DataDoc, Cd_MGEsercizio, EsAnno, Cd_CGConto_Banca, Cd_VL, Decimali, DecimaliPrzUn,Cambio, MagPFlag, MagAFlag, Cd_LS_1, Cd_LS_2, Cd_PG, Colli, PesoLordo, PesoNetto, "
        . "VolumeTotale, AbbuonoV, RigheMerce, RigheSpesa, RigheMerceEvadibili, AccontoPerc, AccontoFissoV, AccontoV, CGCorrispondenzaIvaMerce, UserIns, UserUpd, IvaSplit, NotePiede, Cd_DoTrasporto, Cd_DoAspBene, Cd_DoSottoCommessa, NumeroDocRif, DataDocRif)" //, Cd_DoSped, Cd_DoPorto, )"
        . " VALUES ('".$tipo_doumento."', 'D', 128, '".$clienteDocumento."', 'C', '".$tipo_doumento."', 0, 0,0, 0, 1, 1, 1,1,"
        . $newDocNum . ",'" . $dataDocumento. "', " . $EsercizioYear . ", " . $EsercizioYear . ", " . $bancasconto . ",  'EUR', 2,3,1, 0,0,'0000001','0000001','". $codicepagamento ."',0,0,0,"
        . "0,'".$abbuonov."', ".$numero_righe_enable.",0,".$numero_righe_enable.",'".$accontoperc."','".$accontofissov."','".$accontov."',1,".$numero_utente_arca.",".$numero_utente_arca.",0, NULL, '".$trasporto."', '".$asp_beni."', 'ASSISTENZA', 'TT-".$numero_tt."','".$data_tt."T00:00:00')"; //, '".$porto."', '".$spedizione."')";

        if ($DEBUG) echo "<br><br>";
        if ($DEBUG) echo $tsqlDOTesINSERT;
        if ($DEBUG) echo "<br><br>";
       
        // Eseguo l'inserimento
        $stmtDOTesINSERT = sqlsrv_query($conn, $tsqlDOTesINSERT, array(), array( "Scrollable" => 'static' ));
       

        // Rieseguo la lettura per verifica
        $Id_DOTes = 0;
        $tsqlDOTes = "SELECT * FROM dbo.DOTes WHERE NumeroDocI = " . $newDocNum ." AND Cd_Do = '".$tipo_doumento."' AND EsAnno = '" . date('Y') . "'";
        $stmtDOTes = sqlsrv_query($conn, $tsqlDOTes, array(), array( "Scrollable" => 'static' ));
        $row = sqlsrv_fetch_array($stmtDOTes, SQLSRV_FETCH_ASSOC);
       
        $Id_DOTes = (int)$row["Id_DoTes"];

        if ($DEBUG) echo "<br><br>";
        if ($DEBUG) echo $tsqlDOTes;
        if ($DEBUG) echo "<br><br>";

        if ($Id_DOTes == 0)
        {
            echo "<br> Inserimento testa documento fallito";
            $flag_errore = 1;
            $error_code = 0x0001;
            $error_desc = "Inserimento testa documento fallito";
            $query_error = "SELECT * FROM dbo.DOTes WHERE NumeroDocI = " . $newDocNum ." AND Cd_Do = '".$tipo_doumento."' AND EsAnno = '" . date('Y') . "'";
            $query_error2 = $tsqlDOTesINSERT;
        }
        else
        {
            if ($DEBUG) echo "<br>>>>>> Id_DOTes:" . $Id_DOTes;
            if ($DEBUG) echo "   Testa documento inserita.";       

            /***************************** RIGHE DOCUMENTO ******************************/
           
                /*********************** RIGA DI DEFAULT DI MANODOPERA *********************************/
                           
                $queryMYSQL4 = "SELECT * FROM aos_products WHERE id = '".$prodotto_default."'";
                $resultMYSQL4 = mysqli_query($conn_MYSQL, $queryMYSQL4);    //order executes
                $rowMYSQL4 = mysqli_fetch_assoc($resultMYSQL4);
               
                $cd_ar = $prodotto_default;
                $qta = $manodopera_ore;
               
                $um  ='HH';
                $fattore =1;
                $descrizione = $rowMYSQL4["name"];
                //$descrizione = "Intervento tecnico";   // Nome personalizzato per importazioni sistema ticket
                $prezzo = $fattore * $rowMYSQL4["prezzo_unitario"];
               
                if ($DEBUG) echo "<br><br>****RIGA DI DEFAULT (MAN.ASSISTENZA)****";
               
                if ($DEBUG) echo "<br>Cd_AR:";
                if ($DEBUG) echo $cd_ar;
                if ($DEBUG) echo "<br>Descrizione:";
                if ($DEBUG) echo $descrizione;
                if ($DEBUG) echo "<br>UM:";
                if ($DEBUG) echo $um;
                if ($DEBUG) echo "<br>Fattore:";
                if ($DEBUG) echo $fattore;
                if ($DEBUG) echo "<br>Listino1:";
                if ($DEBUG) echo $prezzo;
                if ($DEBUG) echo "<br>Qta:";
                if ($DEBUG) echo $qta;
               
                $tsqlLSAR = "SELECT Id_LSArticolo FROM dbo.LSArticolo WHERE Cd_AR = '".$cd_ar."'";
                $stmtLSAR = sqlsrv_query($conn, $tsqlLSAR, array(), array( "Scrollable" => 'static' ));
                $row = sqlsrv_fetch_array($stmtLSAR, SQLSRV_FETCH_ASSOC);
                $Id_LSArticolo = (int)$row["Id_LSArticolo"];
               
                if ($DEBUG) echo "<br>Id_LSArticolo:".$Id_LSArticolo."<br>";
               
                if ($qta > 0)
                {   
                    if ($DEBUG) echo "<br>***RIGA CON QTA>0, INSERISCO RIGA...***";
                   
                    $tsqlLSAR = "SELECT Id_LSArticolo FROM dbo.LSArticolo WHERE Cd_AR = '".$cd_ar."'";
                    $stmtLSAR = sqlsrv_query($conn, $tsqlLSAR, array(), array( "Scrollable" => 'static' ));
                    $row = sqlsrv_fetch_array($stmtLSAR, SQLSRV_FETCH_ASSOC);
                    $Id_LSArticolo = (int)$row["Id_LSArticolo"];
                   
                    /***** VERIFICA PRESENZA PREZZI AGEVOLATI PROMOZIONI ********************/
                   
                    $tsqlLSAR_promozioni = "SELECT Prezzo FROM dbo.LSScARCFGruppo WHERE Cd_AR = '".$cd_ar."' AND Cd_CF = '" . $clienteDocumento . "'";
                    $stmtLSAR_promozioni = sqlsrv_query($conn, $tsqlLSAR_promozioni, array(), array( "Scrollable" => 'static' ));
                    //row_promozioni = sqlsrv_fetch_array($stmtLSAR_promozioni, SQLSRV_FETCH_ASSOC);
                   
                   
                   
                    if ($row_promozioni = sqlsrv_fetch_array($stmtLSAR_promozioni, SQLSRV_FETCH_ASSOC))
                    {
                        $prezzo = (int)$row_promozioni["Prezzo"];
                        $descrizione = $descrizione . " (convenzione)";
                        if ($DEBUG) echo "<br>*** Prezzo agevolato da promozione:";
                        if ($DEBUG) echo $prezzo;
                       
                    }
                    else
                    {
                       
                    }
                   
                    if ($DEBUG) echo "<br><br>";
                    if ($DEBUG) echo $tsqlLSAR_promozioni;
                    /************************************************************************/
                    $tsqlAR = "SELECT Cd_CGConto_VI FROM dbo.AR WHERE Cd_AR = '".$cd_ar."'";
                    $stmtAR = sqlsrv_query($conn, $tsqlAR, array(), array( "Scrollable" => 'static' ));
                    $rowAR = sqlsrv_fetch_array($stmtAR, SQLSRV_FETCH_ASSOC);
                    $Cd_CGConto = $rowAR["Cd_CGConto_VI"];
                   
                   
                    $tsqlDORigINSERT = "INSERT INTO dbo.DORig "
                    . "(ID_DOTes, Contabile, NumeroDoc, DataDoc, Cd_MGEsercizio, Cd_DO, TipoDocumento, Cd_CF, Cd_VL, Cambio, Decimali, DecimaliPrzUn, "
                    . "Riga,Cd_MGCausale,Cd_MG_P, Cd_AR, Descrizione, Cd_ARMisura, Cd_CGConto, Cd_Aliquota, "
                    . "Cd_Aliquota_R, Qta, FattoreToUM1, QtaEvadibile, QtaEvasa, PrezzoUnitarioV, ScontoRiga, PrezzoAddizionaleV, "
                    . "PrezzoTotaleV, PrezzoTotaleMovE, Omaggio, Evasa, Evadibile, Esecutivo, FattoreScontoRiga, FattoreScontoTotale, "
                    . "Id_LSArticolo, UserIns, UserUpd, NoteRiga)"
                    . " VALUES ('".$Id_DOTes."', '0', ".$newDocNum.", '".$dataDocumento."', '".$EsercizioYear."', 'RAP', 'D', '".$clienteDocumento."', 'EUR', 1, 2, 3, "
                    . "".($i+1).",'DDT','MP','". $cd_ar ."','".  prepara_stringa($descrizione) .":','".$um."','".$Cd_CGConto."','".$Cd_aliquota."',"
                    . "'".$Cd_aliquota."',".$qta.",".$fattore.",".$qta.",0,".$prezzo.",'',0,"
                    . round(((float)$prezzo*(float)$qta),2).",".round(((float)$prezzo*(float)$qta),2).",1,0,1,1,0,0,"
                    . " ".$Id_LSArticolo.", ".$numero_utente_arca.",".$numero_utente_arca.", '".ucfirst(prepara_stringa($rowMYSQL1["resolution"]))."' )";

                    $totaleImponibile = $totaleImponibile + ((float)$prezzo*(float)$qta);
                    $totaleImponibileLordo = $totaleImponibileLordo + ( ((float)$prezzo)*(float)$qta );
                   
                    if ($DEBUG) echo "<br>";
                    if ($DEBUG) echo $tsqlDORigINSERT;
                    if ($DEBUG) echo "<br>";
                   
                                   
                    $tsqlDORigTRIGGER = "ALTER TABLE dbo.DORig DISABLE TRIGGER DORig_atrg_brd";
                    $stmtDORigTRIGGER = sqlsrv_query($conn, $tsqlDORigTRIGGER, array(), array( "Scrollable" => 'static' ));
                   
                    $stmtDORigINSERT = sqlsrv_query($conn, $tsqlDORigINSERT, array(), array( "Scrollable" => 'static' ));
                   
                    $tsqlDORigTRIGGER = "ALTER TABLE dbo.DORig ENABLE TRIGGER DORig_atrg_brd";
                    $stmtDORigTRIGGER = sqlsrv_query($conn, $tsqlDORigTRIGGER, array(), array( "Scrollable" => 'static' ));
                   
                   
                    $Id_DORig = 0;
                    $tsqlDORig = "SELECT Id_DORig FROM dbo.DORig WHERE ID_DOTes = '".$Id_DOTes."' AND Riga = '".($i+1)."' AND TimeIns > '" . date('Y') . "'";
                    $stmtDORig = sqlsrv_query($conn, $tsqlDORig, array(), array( "Scrollable" => 'static' ));
                    $row = sqlsrv_fetch_array($stmtDORig, SQLSRV_FETCH_ASSOC);
                    $Id_DORig = (int)$row["Id_DORig"];
                   
                    if ($Id_DORig == 0)
                    {
                        echo "<br> !!!!Errore inserimento riga di default in DORig!!!!   - " .$tsqlDORig;
                        $flag_errore = 1;
                        $error_code = 0x0002;
                        $error_desc = "Errore inserimento riga di default in DORig!!!!   - " .$tsqlDORig;
                        $query_error = "SELECT Id_DORig FROM dbo.DORig WHERE ID_DOTes = '".$Id_DOTes."' AND Riga = '".($i+1)."' AND TimeIns > '" . date('Y') . "'";
                        $query_error2 = $tsqlDORigINSERT;
                    }
                    else
                    {
                        if ($DEBUG) echo "<br>>>>>> !!!!Riga di default inserita in  DORig con Id_DORig=".$Id_DORig."!!!!";
                   
                   
                        $tsqlAR = "SELECT Fittizio FROM dbo.AR WHERE Cd_AR = '".$cd_ar."'";
                        $stmtAR = sqlsrv_query($conn, $tsqlAR, array(), array( "Scrollable" => 'static' ));
                        $rowAR = sqlsrv_fetch_array($stmtAR, SQLSRV_FETCH_ASSOC);
                        $AR_fittizio = $rowAR["Fittizio"];
                   
                        if ($AR_fittizio == 0)
                        {

                            $tsqlMGMovINSERT = "INSERT INTO dbo.MGMov "
                            . "(DataMov, Id_DoRig, Cd_MGEsercizio, Cd_AR, Cd_MG, Id_MGMovDes, PartenzaArrivo, PadreComponente, EsplosioneDB, "
                            . "Quantita, Valore, Cd_MGCausale, Ini, Ret, CarA, CarP, CarT, ScaV, ScaP, ScaT)"
                            . " VALUES ('".$dataDocumento."', ".$Id_DORig.",".$EsercizioYear.",'".$cd_ar."','MP', 18, 'P', 'P', 0,"
                            . ($qta*$fattore).",".round($prezzo,2).",'DDT',0,0,0,0,0,1,0,0)";
                           
                            if ($DEBUG) echo "<br>";
                            if ($DEBUG) echo $tsqlMGMovINSERT;
                            if ($DEBUG) echo "<br>";
                           
                            $tsqlMGMovTRIGGER = "ALTER TABLE dbo.MGMov DISABLE TRIGGER MGMov_atrg";
                            $stmtMGMovTRIGGER = sqlsrv_query($conn, $tsqlMGMovTRIGGER, array(), array( "Scrollable" => 'static' ));
                       
                            $stmtMGMovINSERT = sqlsrv_query($conn, $tsqlMGMovINSERT, array(), array( "Scrollable" => 'static' ));
                           
                            $tsqlMGMovTRIGGER = "ALTER TABLE dbo.MGMov ENABLE TRIGGER MGMov_atrg";
                            $stmtMGMovTRIGGER = sqlsrv_query($conn, $tsqlMGMovTRIGGER, array(), array( "Scrollable" => 'static' ));
                           
                            $Id_MGMov = 0;
                            $tsqlMGMov = "SELECT Id_MGMov FROM dbo.MGMov WHERE ID_DoRig = '".$Id_DORig."' AND Cd_MGEsercizio = '" . date('Y') . "'";
                            $stmtMGMov = sqlsrv_query($conn, $tsqlMGMov, array(), array( "Scrollable" => 'static' ));
                            $row = sqlsrv_fetch_array($stmtMGMov, SQLSRV_FETCH_ASSOC);
                            $Id_MGMov = (int)$row["Id_MGMov"];
                           
                            if ($Id_MGMov == 0)
                            {
                                echo "<br> !!!!Errore inserimento riga di default in MGMov!!!!   - " .$tsqlMGMov;
                                $flag_errore = 1;
                                $error_code = 0x0003;
                                $error_desc = "Errore inserimento riga di default in MGMov!!!!   - " .$tsqlMGMov;
                                $query_error = "SELECT Id_MGMov FROM dbo.MGMov WHERE ID_DoRig = '".$Id_DORig."' AND Cd_MGEsercizio = '" . date('Y') . "'";
                                $query_error2 = $tsqlMGMovINSERT;
                            }
                            else
                                if ($DEBUG) echo "<br>>>>>> !!!!Riga di default inserita in  MGMov con Id_MGMov=".$Id_MGMov."!!!!";
                           
                        }
                       
                       
                    }
                   
                    if ($DEBUG) echo "<br><br>*********************INSERIMENTO RIGA TERMINATO CON SUCCESSO********************************<br>";
                   
                   
                }// Chiudo registrazione riga enable
                else
                {// La riga è disable
                    if ($DEBUG) echo "<br><br>!!!! Riga di default non abilitata !!!!";       
                }

                /****************************FINE RIGA DEFAULT  ****************************************/
               
            // Inizio caricamento righe e movimentazione
            for ($i = 2; $i <= $numero_righe; $i++) {
               
                $rowMYSQL2 = mysqli_fetch_assoc($resultMYSQL2);
               
                //$queryMYSQL3 = "SELECT * FROM tkpro_tkprodotti WHERE id = '".$rowMYSQL2["cases_tkpro_tkprodotti_1tkpro_tkprodotti_idb"]."'";
                //$resultMYSQL3 = mysqli_query($conn_MYSQL, $queryMYSQL3);    //order executes
                //$rowMYSQL3 = mysqli_fetch_assoc($resultMYSQL3);
               
                //$queryMYSQL4 = "SELECT * FROM aos_products WHERE id = '".$rowMYSQL3["aos_products_id_c"]."'";
                //$resultMYSQL4 = mysqli_query($conn_MYSQL, $queryMYSQL4);    //order executes
                //$rowMYSQL4 = mysqli_fetch_assoc($resultMYSQL4);
               
                $cd_ar = $rowMYSQL2["part_number"];
                $qta = $rowMYSQL2["product_qty"];
                $prezzo_listino = (float)$rowMYSQL2["product_list_price"];
                $tipo_sconto = $rowMYSQL2["discount"];
               
                if ($tipo_sconto == "Amount")
                {
                    $sconto_articolo_perc = (float)$rowMYSQL2["product_discount"] / ($prezzo_listino / 100);
                }
                else if ($tipo_sconto == "Percentage")
                {
                    $sconto_articolo_perc = (float)$rowMYSQL2["product_discount"];
                }
                else
                {
                    $sconto_articolo_perc = 0;
                }
                   
                $nota_articolo = $rowMYSQL2["description"] . " " . $rowMYSQL2["item_description"];
               
                $um  ='NR';
                $fattore =1;
                $descrizione = $rowMYSQL2["name"];
       
                if ($DEBUG) echo "<br><br>****RIGA " . $i ."****";
               
                if ($DEBUG) echo "<br>Cd_AR:";
                if ($DEBUG) echo $cd_ar;
                if ($DEBUG) echo "<br>Descrizione:";
                if ($DEBUG) echo $descrizione;
                if ($DEBUG) echo "<br>UM:";
                if ($DEBUG) echo $um;
                if ($DEBUG) echo "<br>Fattore:";
                if ($DEBUG) echo $fattore;
                if ($DEBUG) echo "<br>Giacenza:";
                //if ($DEBUG) echo $lista[$i][Giacenza];
                if ($DEBUG) echo "<br>Listino1:";
                if ($DEBUG) echo $prezzo_listino;
                if ($DEBUG) echo "<br>Qta:";
                if ($DEBUG) echo $qta;
                if ($DEBUG) echo "<br>Sconto:";
                if ($DEBUG) echo $sconto_articolo_perc;
               
                $tsqlLSAR = "SELECT Id_LSArticolo FROM dbo.LSArticolo WHERE Cd_AR = '".$cd_ar."'";
                $stmtLSAR = sqlsrv_query($conn, $tsqlLSAR, array(), array( "Scrollable" => 'static' ));
                $row = sqlsrv_fetch_array($stmtLSAR, SQLSRV_FETCH_ASSOC);
                $Id_LSArticolo = (int)$row["Id_LSArticolo"];
               
                if ($DEBUG) echo "<br>Id_LSArticolo:".$Id_LSArticolo."<br>";
               
                if ($qta > 0)
                {   
                    if ($DEBUG) echo "<br>***RIGA CON QTA>0, INSERISCO RIGA...***";
                   
                    $tsqlAR = "SELECT Cd_CGConto_VI FROM dbo.AR WHERE Cd_AR = '".$cd_ar."'";
                    $stmtAR = sqlsrv_query($conn, $tsqlAR, array(), array( "Scrollable" => 'static' ));
                    $rowAR = sqlsrv_fetch_array($stmtAR, SQLSRV_FETCH_ASSOC);
                    $Cd_CGConto = $rowAR["Cd_CGConto_VI"];
                   
                    if ($DEBUG) echo "<br><br>CGConto Articolo: ";
                    if ($DEBUG) echo $Cd_CGConto;
                    if ($DEBUG) echo "<br><br>";
                   
                    if ($Cd_CGConto == "")
                    {
                        $Cd_CGConto = '51010101001';
                        if ($DEBUG) echo "<br><br>CGConto Generico (ContoArticolo Vuoto): ";
                        if ($DEBUG) echo $Cd_CGConto;
                        if ($DEBUG) echo "<br><br>";
                    }
                     
                   
                    $tsqlLSAR = "SELECT Id_LSArticolo FROM dbo.LSArticolo WHERE Cd_AR = '".$cd_ar."'";
                    $stmtLSAR = sqlsrv_query($conn, $tsqlLSAR, array(), array( "Scrollable" => 'static' ));
                    $row = sqlsrv_fetch_array($stmtLSAR, SQLSRV_FETCH_ASSOC);
                    $Id_LSArticolo = (int)$row["Id_LSArticolo"];
                   
                    $tsqlDORigINSERT = "INSERT INTO dbo.DORig "
                    . "(ID_DOTes, Contabile, NumeroDoc, DataDoc, Cd_MGEsercizio, Cd_DO, TipoDocumento, Cd_CF, Cd_VL, Cambio, Decimali, DecimaliPrzUn, "
                    . "Riga,Cd_MGCausale,Cd_MG_P, Cd_AR, Descrizione, Cd_ARMisura, Cd_CGConto, Cd_Aliquota, "
                    . "Cd_Aliquota_R, Qta, FattoreToUM1, QtaEvadibile, QtaEvasa, PrezzoUnitarioV, ScontoRiga, PrezzoAddizionaleV, "
                    . "PrezzoTotaleV, PrezzoTotaleMovE, Omaggio, Evasa, Evadibile, Esecutivo, FattoreScontoRiga, FattoreScontoTotale, "
                    . "Id_LSArticolo, UserIns, UserUpd)"
                    . " VALUES ('".$Id_DOTes."', '0', ".$newDocNum.", '".$dataDocumento."', '".$EsercizioYear."', 'RAP', 'D', '".$clienteDocumento."', 'EUR', 1, 2, 3, "
                    . "".($i).",'DDT','MP','". $cd_ar ."', '".  prepara_stringa($descrizione)."','".$um."','".$Cd_CGConto."','".$Cd_aliquota."',"
                    . "'".$Cd_aliquota."',".$qta.",".$fattore.",".$qta.",0,".$prezzo_listino.",'".$sconto_articolo_perc."',0,"
                    . round((((float)$prezzo_listino*(1-($sconto_articolo_perc/100)))*(float)$qta),2).",".round((((float)$prezzo_listino*(1-($sconto_articolo_perc/100)))*(float)$qta),2).",1,0,1,1,'".((float)$sconto_articolo_perc/100)."','".((float)$sconto_articolo_perc/100)."',"
                    . " ".$Id_LSArticolo.", ".$numero_utente_arca.",".$numero_utente_arca.")";

                    $totaleImponibile = $totaleImponibile + ( ((float)$prezzo_listino*(1-($sconto_articolo_perc/100)))*(float)$qta );
                    $totaleImponibileLordo = $totaleImponibileLordo + ( ((float)$prezzo_listino)*(float)$qta );
                   
                    if ($DEBUG) echo "<br><br>";
                    if ($DEBUG) echo $tsqlDORigINSERT;
                    if ($DEBUG) echo "<br><br>";
                   
                                   
                    $tsqlDORigTRIGGER = "ALTER TABLE dbo.DORig DISABLE TRIGGER DORig_atrg_brd";
                    $stmtDORigTRIGGER = sqlsrv_query($conn, $tsqlDORigTRIGGER, array(), array( "Scrollable" => 'static' ));
                   
                    $stmtDORigINSERT = sqlsrv_query($conn, $tsqlDORigINSERT, array(), array( "Scrollable" => 'static' ));
                   
                    $tsqlDORigTRIGGER = "ALTER TABLE dbo.DORig ENABLE TRIGGER DORig_atrg_brd";
                    $stmtDORigTRIGGER = sqlsrv_query($conn, $tsqlDORigTRIGGER, array(), array( "Scrollable" => 'static' ));
                   
                   
                    $Id_DORig = 0;
                    $tsqlDORig = "SELECT Id_DORig FROM dbo.DORig WHERE ID_DOTes = '".$Id_DOTes."' AND Riga = '".($i)."' AND TimeIns > '" . date('Y') . "'";
                    $stmtDORig = sqlsrv_query($conn, $tsqlDORig, array(), array( "Scrollable" => 'static' ));
                    $row = sqlsrv_fetch_array($stmtDORig, SQLSRV_FETCH_ASSOC);
                    $Id_DORig = (int)$row["Id_DORig"];
                   
                    if ($Id_DORig == 0)
                    {
                        echo "<br> !!!!Errore inserimento riga ".$i." in DORig!!!!   - ".$tsqlDORig;
                        $flag_errore = 1;
                        $error_code = 0x0004;
                        $error_desc = "Errore inserimento riga ".$i." in DORig!!!!   - ".$tsqlDORig;
                        $query_error = "SELECT Id_DORig FROM dbo.DORig WHERE ID_DOTes = '".$Id_DOTes."' AND Riga = '".($i)."' AND TimeIns > '" . date('Y') . "'";
                        $query_error2 = $tsqlDORigINSERT;
                    }
                    else
                    {
                        if ($DEBUG) echo "<br>>>>>> !!!!Riga ".$i." inserita in  DORig con Id_DORig=".$Id_DORig."!!!!";
                   
                       
                        $tsqlAR = "SELECT Fittizio FROM dbo.AR WHERE Cd_AR = '".$cd_ar."'";
                        $stmtAR = sqlsrv_query($conn, $tsqlAR, array(), array( "Scrollable" => 'static' ));
                        $rowAR = sqlsrv_fetch_array($stmtAR, SQLSRV_FETCH_ASSOC);
                        $AR_fittizio = $rowAR["Fittizio"];
                   
                        if ($AR_fittizio == 0)
                        {
                   
                   
                            $tsqlMGMovINSERT = "INSERT INTO dbo.MGMov "
                            . "(DataMov, Id_DoRig, Cd_MGEsercizio, Cd_AR, Cd_MG, Id_MGMovDes, PartenzaArrivo, PadreComponente, EsplosioneDB, "
                            . "Quantita, Valore, Cd_MGCausale, Ini, Ret, CarA, CarP, CarT, ScaV, ScaP, ScaT)"
                            . " VALUES ('".$dataDocumento."', ".$Id_DORig.",".$EsercizioYear.",'".$cd_ar."','MP', 18, 'P', 'P', 0,"
                            . ($qta*$fattore).",".round($prezzo_listino,2).",'DDT',0,0,0,0,0,1,0,0)";
                           
                            if ($DEBUG) echo "<br><br>";
                            if ($DEBUG) echo $tsqlMGMovINSERT;
                            if ($DEBUG) echo "<br><br>";
                           
                            $tsqlMGMovTRIGGER = "ALTER TABLE dbo.MGMov DISABLE TRIGGER MGMov_atrg";
                            $stmtMGMovTRIGGER = sqlsrv_query($conn, $tsqlMGMovTRIGGER, array(), array( "Scrollable" => 'static' ));
                       
                            $stmtMGMovINSERT = sqlsrv_query($conn, $tsqlMGMovINSERT, array(), array( "Scrollable" => 'static' ));
                           
                            $tsqlMGMovTRIGGER = "ALTER TABLE dbo.MGMov ENABLE TRIGGER MGMov_atrg";
                            $stmtMGMovTRIGGER = sqlsrv_query($conn, $tsqlMGMovTRIGGER, array(), array( "Scrollable" => 'static' ));
                           
                            $Id_MGMov = 0;
                            $tsqlMGMov = "SELECT Id_MGMov FROM dbo.MGMov WHERE ID_DoRig = '".$Id_DORig."' AND Cd_MGEsercizio = '" . date('Y') . "'";
                            $stmtMGMov = sqlsrv_query($conn, $tsqlMGMov, array(), array( "Scrollable" => 'static' ));
                            $row = sqlsrv_fetch_array($stmtMGMov, SQLSRV_FETCH_ASSOC);
                            $Id_MGMov = (int)$row["Id_MGMov"];
                           
                            if ($Id_MGMov == 0)
                            {
                                echo "<br> !!!!Errore inserimento riga ".$i." in MGMov!!!!   - " .$tsqlMGMov;
                                $flag_errore = 1;
                                $error_code = 0x0005;
                                $error_desc = "Errore inserimento riga ".$i." in MGMov!!!!   - " .$tsqlMGMov;
                                $query_error = "SELECT Id_MGMov FROM dbo.MGMov WHERE ID_DoRig = '".$Id_DORig."' AND Cd_MGEsercizio = '" . date('Y') . "'";
                                $query_error2 = $tsqlMGMovINSERT;
                            }
                            else
                                if ($DEBUG) echo "<br>>>>>> !!!!Riga ".$i." inserita in  MGMov con Id_MGMov=".$Id_MGMov."!!!!";
                           
                       
                        }
                    }
                   
                    if ($DEBUG) echo "<br>*********************INSERIMENTO RIGA TERMINATO CON SUCCESSO********************************<br>";
                   
                   
                }// Chiudo registrazione riga enable
                else
                {// La riga è disable
                    if ($DEBUG) echo "<br><br>!!!! Riga " + $i + " non abilitata !!!!";       
                }
               
               
            }// Chiudo for delle righe
                       
                       
            $totaleImposta = ($totaleImponibile * 0.22);
            $totaleDocumento = $totaleImposta + $totaleImponibile;
           
            /***************** TOTALI DOCUMENTO **************/
           
            if ((float)$rowMYSQL7["pagato_c"] == 1)
            {
                $acconto_tot = $totaleDocumento;
                $netto_pagare = 0;
            }
            else
            {
                $acconto_tot = 0;
                $netto_pagare = $totaleDocumento;
            }
           
            $tsqlDOTotaliINSERT = "INSERT INTO dbo.DOTotali "
            . "(Id_DoTes, Cambio, AbbuonoV, AccontoV, AccontoE, TotImponibileV, TotImponibileE, TotImpostaV, TotImpostaE, TotDocumentoV, TotDocumentoE, TotMerceLordoV, TotMerceNettoV,"
            . "TotEsenteV, TotSpese_TV, TotSpese_NV, TotSpese_MV, TotSpese_BV, TotSpese_AV, TotSpese_VV, TotSpese_ZV, Totspese_RV, "
            . "TotScontoV, TotOmaggio_MV, TotOmaggio_IV, TotaPagareV, TotaPagareE, TotProvvigione_1V, TotProvvigione_2V, RA_ImportoV, "
            . "TotImpostaRCV, TotImpostaSPV) "
            . "VALUES (".$Id_DOTes.",1,0,".round($acconto_tot,2).",".round($acconto_tot,2).",".round($totaleImponibile,2).",".round($totaleImponibile,2).",".round($totaleImposta,2).",".round($totaleImposta,2).",".round($totaleDocumento,2).",".round($totaleDocumento,2).",".round($totaleImponibileLordo,2).",".round($totaleImponibile,2).", "
            . "0,0,0,0,0,0,0,0,0,"
            . "0,0,0,".round($netto_pagare,2).",".round($netto_pagare,2).",0,0,0, "
            . "0,0)";
           

            if ($DEBUG) echo "<br><br>";
            if ($DEBUG) echo $tsqlDOTotaliINSERT;
            if ($DEBUG) echo "<br><br>";

            $stmtDOTotaliINSERT = sqlsrv_query($conn, $tsqlDOTotaliINSERT, array(), array( "Scrollable" => 'static' ));
           
            $Id_DoTotali = 0;
            $tsqlDOTotali = "SELECT Id_DoTotali FROM dbo.DOTotali WHERE Id_DoTes = '".$Id_DOTes."'";
            $stmtDOTotali = sqlsrv_query($conn, $tsqlDOTotali, array(), array( "Scrollable" => 'static' ));
            $row = sqlsrv_fetch_array($stmtDOTotali, SQLSRV_FETCH_ASSOC);
            $Id_DoTotali = (int)$row["Id_DoTotali"];
           
            if ($Id_DoTotali == 0)
            {
                echo "<br> !!!!Errore inserimento in DOTotali!!!!   - " .$tsqlDOTotali;
                $flag_errore = 1;
                $error_code = 0x0006;
                $error_desc = "Errore inserimento in DOTotali!!!!   - " .$tsqlDOTotali;
                $query_error = "SELECT Id_DoTotali FROM dbo.DOTotali WHERE Id_DoTes = '".$Id_DOTes."'";
                $query_error2 = $tsqlDOTotaliINSERT;
            }
            else
                if ($DEBUG) echo "<br> >>>>> Riga inserita in  DOTotali con Id_DoTotali=".$Id_DoTotali."!!!!";
           
           
           
            /***************** IVA DOCUMENTO **************/
           
            $Cd_CGConto = '51010101001';
           
            //Formo la query per cercare l'ultimo numero di documento
            $tsqlDOIva = "SELECT MAX(Id_DOIva) as Massimo FROM dbo.DOIva";
       
            // Executes the query
            $stmtDOIva = sqlsrv_query($conn, $tsqlDOIva, array(), array( "Scrollable" => 'static' ));
            if ($DEBUG) echo "QUERY SQL DOIva: ".sqlsrv_num_rows($stmtDOIva);
            // Individuo l'ultimo numero di documento di tipo RAP utilizzato
            $row = sqlsrv_fetch_array($stmtDOIva, SQLSRV_FETCH_ASSOC);

            $newIvaDocNum = (int)($row["Massimo"])+1;    //Nuovo numero di documento
           
            $tsqlDOIvaINSERT = "INSERT INTO dbo.DOIva "
            . "(Id_DOTes, Cd_Aliquota, Aliquota, Cambio, ImponibileV, ImpostaV, Omaggio, Cd_CGConto, Cd_DOSottoCommessa) "
            . "VALUES (".$Id_DOTes.", '".$Cd_aliquota."', '".$Aliquota."', '1.000000',".round($totaleImponibile,2).",".round($totaleImposta,2).", '1', '".$Cd_CGConto."','ASSISTENZA')";
           

            if ($DEBUG) echo "<br><br>";
            if ($DEBUG) echo $tsqlDOIvaINSERT;
            if ($DEBUG) echo "<br><br>";

            $stmtDOIvaINSERT = sqlsrv_query($conn, $tsqlDOIvaINSERT, array(), array( "Scrollable" => 'static' ));
           
            $Id_DoTotali = 0;
            $tsqlDOIva = "SELECT Id_DOIva FROM dbo.DOIva WHERE Id_DOTes = '".$Id_DOTes."'";
            $stmtDOIva = sqlsrv_query($conn, $tsqlDOIva, array(), array( "Scrollable" => 'static' ));
            $row = sqlsrv_fetch_array($stmtDOIva, SQLSRV_FETCH_ASSOC);
            $Id_DoIva = (int)$row["Id_DOIva"];
           
            if ($Id_DoIva == 0)
            {
                echo "<br> !!!!Errore inserimento in DOIva!!!!   - " .$tsqlDOIva;
                $flag_errore = 1;
                $error_code = 0x0007;
                $error_desc = "Errore inserimento in DOIva!!!!   - " .$tsqlDOIva;
                $query_error = "SELECT Id_DOIva FROM dbo.DOIva WHERE Id_DOTes = '".$Id_DOTes."'";
                $query_error2 = $tsqlDOIvaINSERT;
            }
            else
                if ($DEBUG) echo "<br> >>>>> Riga inserita in  DOIva con Id_DoTes=".$Id_DOTes."!!!!";
           
           
           
           
                   
        }// chiusura if testa doc inserita
       
        // Error handling
        //if ($stmt === false)
        //{
        //    die(formatErrors(sqlsrv_errors()));
        //}

        //Chiudo le connessioni   
        sqlsrv_free_stmt($stmtDOTesINSERT);
        sqlsrv_free_stmt($stmtDOTes);
        //sqlsrv_free_stmt($stmtDORigINSERT);
        sqlsrv_free_stmt($stmtDORig);
        //sqlsrv_free_stmt($stmtMVMovINSERT);
        //sqlsrv_free_stmt($stmtMVMov);
        sqlsrv_free_stmt($stmtDOTotaliINSERT);
        sqlsrv_free_stmt($stmtDOTotali);
        sqlsrv_free_stmt($stmtDOIvaINSERT);
        sqlsrv_free_stmt($stmtDOIva);
       
        sqlsrv_close($conn);
       
        $time_end=time();
       
        if ($flag_errore == 0)
        {
            echo "<p><p>************************************************* PROCESSO TERMINATO CON SUCCESSO!! ***********************************************";           
           
            $queryMYSQL_end = "UPDATE cases SET state = 'Closed' WHERE id = '" .$rowMYSQL1["id"] . "'";
            $resultMYSQL_end = mysqli_query($conn_MYSQL, $queryMYSQL_end);    //order executes
           
            $logfile = fopen("/log/sync.coimaf.local/ImportRAP-".$today = date("y-m-d").".txt", "a+") or die("\nUnable to open file!");
            $txt = " ". $today = date("d-m-y h:i:s") . " - Processo terminato correttamente in " . ($time_end-$time_start) . " secondi.\t Ticket:" . $numero_tt . "    \tDocumento:" . $newDocNum . "   \tCodice errore:" . $error_code . "   \tDescrizione errore:" . $error_desc . "   \tQuery:" . $query_error . " \n";
            fwrite($logfile, $txt);
            fclose($logfile);
           
        }
        else
        {
            echo "<p><p>************************************************* ERRORI NEL PROCESSO!! ***********************************************";           
           
            $queryMYSQL_end = "UPDATE cases SET state = 'Error' WHERE id = '" .$rowMYSQL1["id"] . "'";
            $resultMYSQL_end = mysqli_query($conn_MYSQL, $queryMYSQL_end);    //order executes
           
            $logfile = fopen("/log/sync.coimaf.local/ImportRAP-".$today = date("y-m-d").".txt", "a+") or die("\nUnable to open file!");
            $txt = " ". $today = date("d-m-y h:i:s") . " - Processo terminato con errori in " . ($time_end-$time_start) . " secondi.\t Ticket:" . $numero_tt . "    \tDocumento:" . $newDocNum . "   \tCodice errore:" . $error_code . "   \tDescrizione errore:" . $error_desc . "   \tQuery:" . $query_error . "    \tQuery:" . $query_error2 . " \n";
            fwrite($logfile, $txt);
            fclose($logfile);
        }
    }
}//Chiudo if righe > 0
else
{
    echo '<br><br><p align="center" style=" text-align: center; font-size:38;"> Nessun documento da importare';
    $logfile = fopen("/log/sync.coimaf.local/ImportRAP-".$today = date("y-m-d").".txt", "a+") or die("\nUnable to open file!");
    $txt = " ". $today = date("d-m-y h:i:s") . " - Nessun documento da importare \n";
    fwrite($logfile, $txt);
    fclose($logfile);
}


?>