const uploadButton = document.getElementById('upload-button');


if (uploadButton){
  uploadButton.addEventListener('click', handleFileUpload);}

function handleFileUpload() {
  const fileInput = document.createElement('input');
  fileInput.type = 'file';
  fileInput.name = 'fileToUpload'
  fileInput.accept = '*';
  fileInput.addEventListener('change', attachFile);
  fileInput.click();
}
async function attachFile(event) {
    const file = event.target.files[0];
    
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id');
    
    const formData = new FormData();
    formData.append('fileToUpload', file);
    formData.append('id', ticketId);
    
    const response = await fetch('../api/api_attach_file.php', {
      method: 'POST',
      body: formData,
    });
  
    const message = await response.json();
    
    if (message.file != 'error'){
        const files = document.querySelector('#files')

        const downloadLink = document.createElement('a')
        downloadLink.href = "../files/ticket" + ticketId + "_" + message.file
        downloadLink.download = message.file
        downloadLink.textContent = message.file

        files.append(downloadLink)
    }

  }