const form = document.querySelector('#fileUploadForm');
const fileInput = document.querySelector('#fileToUpload');
const uploadIcon = document.querySelector('#uploadFile');

if (form) {
    uploadIcon.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        form.submit();
    });
}