const form = document.getElementById("createRoomForm");
const roomInput = document.getElementById("createRoomText");
const roomTypeInput = document.getElementById("createRoomType");

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const roomName = roomInput.value.trim();
    const roomType = roomTypeInput.value.trim();
    const params = new URLSearchParams(window.location.search);
    let serverId = params.get("serverId");
    if (!roomName || !roomType || !serverId) return;

    fetch('lib/createRoomLib.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'roomName=' + encodeURIComponent(roomName) + '&roomType=' + encodeURIComponent(roomType) + '&serverId=' + encodeURIComponent(serverId)
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        location.href = "index.php?" + data;
    })
    .catch(error => console.error('Error sending data:', error));
});