<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <title>Ticket</title>
</head>
<body>
    <div class="print-preview">
        
        <div class="layout-container">
            <!-- Prima metà della pagina -->
            <div class="half-page">
                <div class="logo-container">
                    <img src="{{ asset('assets/coimaf_logo.png') }}" alt="">
                    <p style="font-size: 6px; width:100px;">COIMAF SRL <br>
                        VIA DEL LAVORO <br>
                        88060 SAN SOSTENE (CZ)<br>
                        Tel. 0967.522303<br>
                        info@coimaf.com<br>
                        www.coimaf.com
                    </p>
                </div>
                
                <div class="numero-ticket-container">
                    <p> </p>
                    <p style="text-align: center;  font-size: 10px; margin-top: 20px">Ticket Numero 1 del 29/01/2024</p>
                </div>
                
                <div class="cliente-container">
                    <h6 style="padding: 0; margin: 0; font-size: 8px;">DATI CLIENTE</h6>
                    <hr class="hr-print">
                    <p style="font-size: 9px;" class="grassetto">COSTARABA</p>
                    <p style="font-size: 9px;">321239392</p>
                    <p style="font-size: 9px;">VIA ROMA</p>
                    <p style="font-size: 9px;">88060 MONTAURO (CZ)</p>
                </div>
                
                <div class="problema-container">
                    <h6 style="margin-top: 40px; margin-bottom: 0; padding:0;">PROBLEMA: FRIGO - MODELLO - 02221551220</h6>
                    
                    <h6 style="text-align:end; padding:0; margin-top: 40px; margin-bottom:0;">Priorità Normale</h6>
                </div>
                <hr class="hr-print">
                
                <div style="height: 100px;">
                    <br>
                    <p>Non si accende piu' la spia del Frigo</p>
                </div>
                
                <div style="height: 180px;">
                    <h6 style="padding: 0; margin: 0; font-size: 8px;">SOLUZIONE</h6>
                    <hr class="hr-print">
                </div>
                
                <div class="layout-container">
                    <div>
                        <p style="margin-bottom: 50px;">Data intervento</p>
                        <hr class="hr-print">
                    </div>
                    <div>
                        <p style="margin-bottom: 50px; text-align: center">Firma</p>
                        <hr style="width: 100px" class="hr-print">
                    </div>
                </div>
            </div>
            
            <hr class="dashed-line">
            
            <!-- Seconda metà della pagina - Duplicato della prima metà -->
            <div class="half-page">
                <div class="logo-container">
                    <img src="{{ asset('assets/coimaf_logo.png') }}" alt="">
                    <p style="font-size: 6px; width:100px;">COIMAF SRL <br>
                        VIA DEL LAVORO <br>
                        88060 SAN SOSTENE (CZ)<br>
                        Tel. 0967.522303<br>
                        info@coimaf.com<br>
                        www.coimaf.com
                    </p>
                </div>
                
                <div class="numero-ticket-container">
                    <p> </p>
                    <p style="text-align: center;  font-size: 10px; margin-top: 20px">Ticket Numero 1 del 29/01/2024</p>
                </div>
                
                <div class="cliente-container">
                    <h6 style="padding: 0; margin: 0; font-size: 8px;">DATI CLIENTE</h6>
                    <hr class="hr-print">
                    <p style="font-size: 9px;" class="grassetto">COSTARABA</p>
                    <p style="font-size: 9px;">321239392</p>
                    <p style="font-size: 9px;">VIA ROMA</p>
                    <p style="font-size: 9px;">88060 MONTAURO (CZ)</p>
                </div>
                
                <div class="problema-container">
                    <h6 style="margin-top: 40px; margin-bottom: 0; padding:0;">PROBLEMA: FRIGO - MODELLO - 02221551220</h6>
                    
                    <h6 style="text-align:end; padding:0; margin-top: 40px; margin-bottom:0;">Priorità Normale</h6>
                </div>
                <hr class="hr-print">
                
                <div style="height: 100px;">
                    <br>
                    <p>Non si accende piu' la spia del Frigo</p>
                </div>
                
                <div style="height: 180px;">
                    <h6 style="padding: 0; margin: 0; font-size: 8px;">SOLUZIONE</h6>
                    <hr class="hr-print">
                </div>
                
                <div class="layout-container">
                    <div>
                        <p style="margin-bottom: 50px;">Data intervento</p>
                        <hr class="hr-print">
                    </div>
                    <div>
                        <p style="margin-bottom: 50px; text-align: center">Firma</p>
                        <hr style="width: 100px" class="hr-print">
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .layout-container {
                display: flex;
                justify-content: space-between;
            }
            
            .half-page {
                width: 50%;
                margin: 0 10px;
            }
            
            .grassetto {
                font-weight: bold;
            }
            
            @media print {
                body{
                    font-family: 'Lato', sans-serif;
                }
                p{
                    padding: 0;
                    margin: 0;
                }
                #printButton {
                    visibility: hidden;
                }
                
                .logo-container {
                    display: flex;
                    margin-bottom: 20px;
                    justify-content: space-around;
                }
                
                .logo-container img {
                    width: 100%;
                    margin: 0 0px;
                    margin-right: 30px;
                    align-self: flex-end;
                }
                
                .numero-ticket-container {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 60px;
                }
                
                .hr-print {
                    border: 1px solid #000; /* Aggiungi uno stile al tuo hr */
                    margin: 10px 0;
                }
                
                .dashed-line {
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    left: 50%;
                    border: none;
                    border-left: 1px dashed #000;
                    height: 95%;
                }
                
                .problema-container{
                    display: flex;
                    justify-content: space-between;
                }
            }
        </style>
    </body>
    </html>
    