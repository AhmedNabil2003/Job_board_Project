function previewImage(event) {
    var imagePreview = document.getElementById('image-preview');
    var currentImage = document.getElementById('current-image');

    if (currentImage) {
        currentImage.remove();
    }


    var newImage = document.createElement('img');
    newImage.src = URL.createObjectURL(event.target.files[0]);
    newImage.width = 100; 
    newImage.alt = 'New Profile Picture';
    newImage.id = 'current-image';  

    imagePreview.appendChild(newImage);

    var fileInput = event.target;
    var fileName = fileInput.files[0].name;
    fileInput.nextElementSibling.innerText = fileName;
}