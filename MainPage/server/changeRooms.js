function ChangeRoom(roomId) {
  const url = new URL(window.location.href);

  url.searchParams.set("roomId", roomId);

  window.location.href = url;
}