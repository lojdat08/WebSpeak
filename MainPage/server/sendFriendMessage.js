const form = document.getElementById("sendMessageForm");
const input = document.getElementById("textMessageForm");

const params = new URLSearchParams(window.location.search);
let friendId = params.get("friendId");
if(friendId == null)
{
    form.style.display = "none";
}

form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent page reload / URL change

    const text = input.value.trim();
    if (!text) return;

    const params = new URLSearchParams(window.location.search);
    let friendId = params.get("friendId");

    if(friendId == null)
    {
        window.alert("You must be in a chat with friend to write messages.");
        return;
    }

    const formData = new FormData();
    formData.append("message", text);
    formData.append("friendId", friendId);

    fetch('lib/writeFriendMessage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        input.value = '';
        location.reload();
    })
    .catch(error => console.error('Error sending data:', error));
});