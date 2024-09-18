function previewImage(event) {
    const file = event.target.files[0];
    const currentLogo = document.getElementById('currentLogo');
    const noLogoText = document.getElementById('noLogoText');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            currentLogo.src = e.target.result;
            currentLogo.style.display = 'block';
            noLogoText.style.display = 'none';
        }
        reader.readAsDataURL(file);
    } else {
        currentLogo.src = '';
        currentLogo.style.display = 'none';
        noLogoText.style.display = 'block';
    }
}


function showDeleteModal() {
    $('#deleteAccountModal').modal('show');
}