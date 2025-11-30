function ChangeFriend(friendId) {
  const url = new URL(window.location.href);

  url.searchParams.set("friendId", friendId);
  const currentPage = window.location.pathname.split("/").pop();

  if (currentPage !== "friendsIndex.php")
  {
    window.location.replace("friendsIndex.php?friendId=" + friendId);
  }
  else
  {
    window.location.href = url;
  }
}
