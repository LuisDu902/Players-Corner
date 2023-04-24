const depImagePreview = document.querySelector('#dep-image-preview');

if (depImagePreview) {
  const depFileInput = document.querySelector('#dep-image');
  depFileInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.addEventListener('load', function () {
      depImagePreview.src = reader.result;
    });
    reader.readAsDataURL(file);
  });
}

const userImagePreview = document.querySelector('#user-image-preview');

if (userImagePreview) {
  const userFileInput = document.querySelector('#user-image');
  userFileInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.addEventListener('load', function () {
      userImagePreview.src = reader.result;
    });
    reader.readAsDataURL(file);
  });
}

