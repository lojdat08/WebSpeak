const form = document.getElementById("sendMessageForm");
const input = document.getElementById("textMessageForm");

const params = new URLSearchParams(window.location.search);
let roomId = params.get("roomId");
if(roomId == null)
{
    form.style.display = "none";
}

form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent page reload / URL change

    const text = input.value.trim();
    if (!text) return;

    const params = new URLSearchParams(window.location.search);
    let roomId = params.get("roomId");
    let serverId = params.get("serverId");

    if(roomId == null || serverId == null)
    {
        window.alert("You must be in a room to write messages.");
        return;
    }

    fetch('lib/writeMessage.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'message=' + encodeURIComponent(text) + '&roomId=' + encodeURIComponent(roomId) + '&serverId=' + encodeURIComponent(serverId)
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        input.value = '';
        location.reload();
    })
    .catch(error => console.error('Error sending data:', error));
});