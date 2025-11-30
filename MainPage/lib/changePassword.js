const changePasswordForm = document.getElementById("changePasswordForm");
const oldPassword = document.getElementById("oldPassword");
const newPassword = document.getElementById("newPassword");
const newPasswordAgain = document.getElementById("newPasswordAgain");

changePasswordForm.addEventListener('submit', function(e) {
    e.preventDefault();

    if (!oldPassword.value || !newPassword.value || !newPasswordAgain.value) return;
    if(newPassword.value.length < 5 || newPassword.value.length > 30) {
        window.alert("New password must be between 5 and 30 characters.");
        return;
    }
    else if(oldPassword.value === newPassword.value) {
        window.alert("New password must be different from the old password.");
        return;
    }
    else if(newPassword.value !== newPasswordAgain.value) {
        window.alert("New passwords do not match.");
        return;
    }

    const formData = new FormData();
    formData.append('oldPassword', oldPassword.value);
    formData.append('newPassword', newPassword.value);

    fetch('lib/changePasswordLib.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        if(data === "Old password is incorrect.") {
            window.alert("The old password you entered is incorrect.");
        }
        else if (data === "Password changed successfully.") {
            window.alert("Password changed successfully.");
        }
        else if(data === "User not found.") {
            window.alert("User not found.");
        }
        else if(!data){
            window.alert("An error occurred.");
        }
        location.reload();
    })
    .catch(error => console.error('Error sending data:', error));
});