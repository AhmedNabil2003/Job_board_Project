function previewImage(event) {
    var imagePreview = document.getElementById('image-preview');
    var currentImage = document.getElementById('current-image');

    // إذا كانت الصورة القديمة موجودة، قم بحذفها
    if (currentImage) {
        currentImage.remove();
    }

    // إنشاء عنصر جديد لعرض الصورة المختارة
    var newImage = document.createElement('img');
    newImage.src = URL.createObjectURL(event.target.files[0]);
    newImage.width = 100;  // يمكنك تعديل حجم الصورة هنا إذا لزم الأمر
    newImage.alt = 'New Profile Picture';
    newImage.id = 'current-image';  // نفس المعرف لإمكانية التعامل معها لاحقاً

    // إضافة الصورة الجديدة في المعاينة
    imagePreview.appendChild(newImage);

    // تحديث اسم الزر ليعرض اسم الملف الذي تم اختياره
    var fileInput = event.target;
    var fileName = fileInput.files[0].name;
    fileInput.nextElementSibling.innerText = fileName;
}