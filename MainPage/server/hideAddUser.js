const addUserButton = document.getElementById("addUserDiv");

const urlParams = new URLSearchParams(window.location.search);
const serverId = urlParams.get("serverId");
if(serverId == null)
{
    addUserButton.style.display = "none";
}