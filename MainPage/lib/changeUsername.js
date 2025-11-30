const changeUsernameForm = document.getElementById("changeUsernameForm");
const newUsername = document.getElementById("newUsername");

changeUsernameForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const username = newUsername.value;
  if (!username) return;
  if (username.length <= 3 || username.length >= 20) {
    window.alert("Username must be between 4 and 19 characters long.");
    return;
  }
  if (username == GetCookie("username")) {
    window.alert("You can't have the same username.");
    return;
  }

  const formData = new FormData();
  formData.append("newUsername", username);

  fetch("lib/changeUsernameLib.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("PHP response:", data); // logs whatever PHP returns
      if (data === "Username is taken") {
        window.alert(
          "This username is already taken. Please choose another one."
        );
      }
      location.reload();
    })
    .catch((error) => console.error("Error sending data:", error));
});

function GetCookie(name) {
  const cookies = document.cookie.split(";");
  for (let cookie of cookies) {
    cookie = cookie.trim();
    if (cookie.startsWith(name + "=")) {
      return decodeURIComponent(cookie.substring(name.length + 1));
    }
  }
  return null;
}
