function ChangeRoom(roomId) {
  const url = new URL(window.location.href);

  url.searchParams.set("roomId", roomId);
  const currentPage = window.location.pathname.split("/").pop();

  if (currentPage !== "index.php")
  {
    const params = window.location.search;
    window.location.replace("index.php" + params + "&roomId=" + roomId);
  }
  else
  {
    window.location.href = url;
  }
}