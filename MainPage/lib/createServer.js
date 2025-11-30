const form = document.getElementById("createServerForm");
const serverNameInput = document.getElementById("createServerText");
const serverImageInput = document.getElementById("createServerImage");

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const serverName = serverNameInput.value.trim();
    const imageFile = serverImageInput.files[0];
    if (!serverName || !imageFile) return;

    const formData = new FormData();
    formData.append('serverName', serverName);
    formData.append('serverImage', imageFile)

    fetch('lib/createServerLib.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        location.href = "index.php";
    })
    .catch(error => console.error('Error sending data:', error));
});