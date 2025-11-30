const addFriendForm = document.getElementById("addFriendForm");
const friendUsername = document.getElementById("friendUsername");

addFriendForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const friendUsernameValue = friendUsername.value;

  if (!friendUsernameValue) {
    window.alert("Username cannot be empty.");
    return;
  }

  const formData = new FormData();
  formData.append("friendUsername", friendUsernameValue);

  fetch("lib/addFriendLib.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("PHP response:", data); // logs whatever PHP returns
      if (data === "Username does not exist") {
        window.alert("The username you are trying to add does not exist.");
      } else if (data === "User is already your friend") {
        window.alert("User is already your friend.");
      } else if (data === "You can't be your friend") {
        window.alert("You can't be your own friend.");
      } else {
        //location.reload("index.php");
      }
    })
    .catch((error) => console.error("Error sending data:", error));
});
