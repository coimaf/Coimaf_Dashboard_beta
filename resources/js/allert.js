document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success alert after 3 seconds
    var successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }

    // Auto-hide error alert after 3 seconds
    var errorAlert = document.getElementById('error-alert');
    if (errorAlert) {
        setTimeout(function() {
            errorAlert.style.display = 'none';
        }, 4000);
    }
});