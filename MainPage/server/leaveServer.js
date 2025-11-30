const leaveServerButton = document.getElementById("leaveServerButton");

const leaveServerurlParams = new URLSearchParams(window.location.search);
const leaveServerId = leaveServerurlParams.get("serverId");
if (leaveServerId == null) {
  leaveServerButton.style.display = "none";
}

leaveServerButton.addEventListener("click", function (e) {
  e.preventDefault();

  const leaveServerurlParams = new URLSearchParams(window.location.search);
  const leaveServerId = leaveServerurlParams.get("serverId");

  const formData = new FormData();
  formData.append("leaveServerId", leaveServerId);

  fetch("lib/leaveServerLib.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("PHP response:", data); // logs whatever PHP returns
      if (data === "Can't get your user info.") {
        window.alert("Can't get your user info.");
      } else if (data === "You are not in this server.") {
        window.alert("You are not in this server.");
      } else {
        location.reload("index.php");
      }
    })
    .catch((error) => console.error("Error sending data:", error));
});
