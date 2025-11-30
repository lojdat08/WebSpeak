const removeFriendButton = document.getElementById("removeFriendButton");

const urlParams = new URLSearchParams(window.location.search);
const removeFriendId = urlParams.get("friendId");
if (removeFriendId == null) {
  removeFriendButton.style.display = "none";
}

removeFriendButton.addEventListener("click", function (e) {
  e.preventDefault();

  const urlParams = new URLSearchParams(window.location.search);
  const removeFriendId = urlParams.get("friendId");

  const formData = new FormData();
  formData.append("friendId", removeFriendId);

  fetch("lib/removeFriendLib.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("PHP response:", data); // logs whatever PHP returns
      if (data === "You are not friends with this user") {
        window.alert("You are not friends with this user");
      } else {
        location.reload("index.php");
      }
    })
    .catch((error) => console.error("Error sending data:", error));
});
