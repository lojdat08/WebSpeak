const changeProfileImageForm = document.getElementById("profileImageForm");
const newProfileImage = document.getElementById("newProfileImage");

changeProfileImageForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const profileImage = newProfileImage.files[0];
    if (!profileImage) return;

    const formData = new FormData();
    formData.append('newProfileImage', profileImage);

    fetch('lib/setProfileImageLib.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP response:', data); // logs whatever PHP returns
        location.reload();
    })
    .catch(error => console.error('Error sending data:', error));
});