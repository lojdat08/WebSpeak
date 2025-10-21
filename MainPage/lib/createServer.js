const form = document.getElementById("createServerForm");
const serverNameInput = document.getElementById("createServerText");
const serverImageInput = document.getElementById("createServerImage");

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const serverName = serverNameInput.value.trim();
    const image = serverImageInput.value.trim();
    if (!serverName || !image) return;

    fetch('lib/createServerLib.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'serverName=' + encodeURIComponent(serverName) + '&serverImg=' + encodeURIComponent(image)
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        location.href = "index.php";
    })
    .catch(error => console.error('Error sending data:', error));
});