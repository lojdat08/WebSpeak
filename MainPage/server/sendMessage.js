const form = document.getElementById("sendMessageForm");
const input = document.getElementById("textMessageForm");

form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent page reload / URL change

    const text = input.value.trim();
    if (!text) return;

    const params = new URLSearchParams(window.location.search);
    let roomId = params.get("roomId");

    if(roomId == null)
    {
        window.alert("You must be in a room to write messages.");
        return;
    }

    // Send the data via POST to your PHP file
    fetch('lib/writeMessage.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'message=' + encodeURIComponent(text) + '&roomId=' + encodeURIComponent(roomId)
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        input.value = ''; // clear input after sending
        location.reload();
    })
    .catch(error => console.error('Error sending data:', error));
});