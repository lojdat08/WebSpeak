const addUserForm = document.getElementById("addUserForm");
const addUsername = document.getElementById("addUsername");

addUserForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const addUsernameValue = addUsername.value;

  const url = new URL(window.location.href);
  const serverId = url.searchParams.get("serverId");

  if (!addUsernameValue) {
    window.alert("Username cannot be empty.");
    return;
  }
  if (!serverId) {
    return;
  }

  const formData = new FormData();
  formData.append("addUsername", addUsernameValue);
  formData.append("serverId", serverId);

  fetch("lib/addUserToServerLib.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("PHP response:", data); // logs whatever PHP returns
      if (data === "Username does not exist") {
        window.alert("The username you are trying to add does not exist.");
      } else if (data === "User is not in server") {
        window.alert("You do not have permission to add users to this server.");
      } else if (data === "User is already in server") {
        window.alert("This user is already in the server.");
      } else {
        location.reload("index.php");
      }
    })
    .catch((error) => console.error("Error sending data:", error));
});
