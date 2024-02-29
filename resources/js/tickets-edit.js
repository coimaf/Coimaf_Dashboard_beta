document.getElementById('customerInput').addEventListener('input', function() {
    var selectedOption = document.querySelector('#customer option[value="' + this.value + '"]');
    var cdCFInput = document.getElementById('selectedCdCFInput');
    var Cd_CFClasse3Input = document.getElementById('selectedCd_CFClasse3Input');

    if (selectedOption) {
        Cd_CFClasse3Input.value = selectedOption.getAttribute('data-Cd_CFClasse3');
        cdCFInput.value = selectedOption.getAttribute('data-cd-cf');
    } else {
        Cd_CFClasse3Input.value = '';
        cdCFInput.value = ''; // Se l'utente cancella l'input, azzera il valore di Cd_CF
    }
});

document.getElementById('articleInput').addEventListener('input', function() {
    var selectedOption = document.querySelector('#art option[value="' + this.value + '"]');
    var descInput = document.getElementById('descInput');
    var priceInput = document.getElementById('prz');
    var quantityInput = document.getElementById('qnt');
    var scontoInput = document.getElementById('sconto');
    
    if (selectedOption) {
        descInput.value = selectedOption.getAttribute('data-desc');
        var price = parseFloat(selectedOption.getAttribute('data-prezzo')); // Ottieni il prezzo come float
        priceInput.value = formatPrice(price); // Formatta il prezzo
        quantityInput.value = 1;
        updateTotal();
    } else {
        descInput.value = '';
        priceInput.value = '0.000'; // Imposta il prezzo a 0.000 se l'opzione non è selezionata
        quantityInput.value = 0;
        scontoInput.value = 0;
        updateTotal();
    }
});

function formatPrice(price) {
    var formattedPrice = price.toFixed(3); // Ottieni il prezzo con tre decimali
    // Aggiungi gli zeri finali se necessario
    var parts = formattedPrice.split('.');
    if (parts.length === 1) {
        formattedPrice += '.000';
    } else if (parts.length === 2 && parts[1].length === 1) {
        formattedPrice += '00';
    } else if (parts.length === 2 && parts[1].length === 2) {
        formattedPrice += '0';
    }
    return formattedPrice;
}

document.getElementById('qnt').addEventListener('input', function() {
    updateTotal();
});

document.getElementById('descInput').addEventListener('input', function() {
    var selectedOption = document.querySelector('#desc option[value="' + this.value + '"]');
    var articleInput = document.getElementById('articleInput');
    var priceInput = document.getElementById('prz');
    var quantityInput = document.getElementById('qnt');
    var scontoInput = document.getElementById('sconto');
    
    if (selectedOption) {
        articleInput.value = selectedOption.getAttribute('data-art');
        var price = parseFloat(selectedOption.getAttribute('data-prezzo')) / 100; // Converti il prezzo da centesimi a euro
        priceInput.value = price; // Visualizza il prezzo con due decimali
        quantityInput.value = 1; // Imposta la quantità a 1
        updateTotal();
    } else {
        articleInput.value = '';
        priceInput.value = '0';
        quantityInput.value = 0; // Imposta la quantità a 0
        scontoInput.value = 0;
        updateTotal();
    }
});

document.getElementById('qnt').addEventListener('input', function() {
    updateTotal();
});

function updateTotal() {
    var quantity = parseFloat(document.getElementById('qnt').value);
    var price = parseFloat(document.getElementById('prz').value);
    
    if (isNaN(quantity)) {
        quantity = 0;
    }
    
    if (isNaN(price)) {
        price = 0;
    }
    
    var total = quantity * price;
    document.getElementById('tot').value = total.toFixed(3); // Ottieni il totale con tre decimali
}

document.getElementById('sconto').addEventListener('input', function() {
    updateTotalWithDiscount();
});

function updateTotalWithDiscount() {
    var quantity = parseFloat(document.getElementById('qnt').value);
    var price = parseFloat(document.getElementById('prz').value);
    var discount = parseFloat(document.getElementById('sconto').value);
    
    if (isNaN(quantity)) {
        quantity = 0;
    }
    
    if (isNaN(price)) {
        price = 0;
    }
    
    if (isNaN(discount)) {
        discount = 0;
    }
    
    var subtotal = quantity * price;
    var discountAmount = (subtotal * discount) / 100;
    var total = subtotal - discountAmount;
    
    document.getElementById('tot').value = total.toFixed(3); // Ottieni il totale con tre decimali
}

document.addEventListener('DOMContentLoaded', function() {
    
    // Pulisci gli input per l'articolo e la descrizione
    document.getElementById('articleInput').value = '';
    document.getElementById('descInput').value = '';
    
    // Imposta il prezzo, la quantità e lo sconto a 0
    document.getElementById('prz').value = '0';
    document.getElementById('qnt').value = '0';
    document.getElementById('sconto').value = '0';
    
    // Calcola e imposta il totale
    updateTotalWithDiscount();
});


function updateTotalTot() {
    var total = 0;
    var prz = document.querySelectorAll('.total');
    
    prz.forEach(function(element) {
        var value = parseFloat(element.textContent.replace(/\./g, '').replace(',', '.')); // Rimuovi i punti e sostituisci la virgola con un punto
        total += value; // Aggiungi il valore al totale
    });
    
    var formattedTotal = total.toLocaleString('it-IT', { minimumFractionDigits: 3 }) + ' €'; // Formatta il totale secondo il formato desiderato
    
    // Aggiorna il contenuto della cella con id "totalCell" con il totale formattato
    document.getElementById('totalCell').textContent = formattedTotal;
}



function calculateIVA() {
    var total = parseFloat(document.getElementById('totalCell').textContent.replace(/\./g, '').replace(',', '.')); // Ottieni il totale senza il simbolo '€'
    var ivaPercentage = 22; // Percentuale IVA del 22%
    var iva = total * (ivaPercentage / 100); // Calcola l'IVA
    var formattedIVA = iva.toLocaleString('it-IT', { minimumFractionDigits: 3 }) + ' €'; // Formatta l'IVA secondo il formato desiderato
    document.getElementById('iva').textContent = formattedIVA; // Aggiorna il contenuto della cella con id "iva" con l'IVA formattata

    var totalToPay = total + iva; // Calcola l'importo totale da pagare
    var formattedTotalToPay = totalToPay.toLocaleString('it-IT', { minimumFractionDigits: 3 }) + ' €'; // Formatta l'importo totale da pagare secondo il formato desiderato
    document.getElementById('aPagare').textContent = formattedTotalToPay; // Aggiorna il contenuto della cella con id "aPagare" con l'importo totale da pagare formattato
}

window.onload = function() {
    updateTotalTot();
    calculateIVA();
};
