<?php
function FriendsId(int $friendId1, int $friendId2, $conn): int
{
    try {
        $stmt = $conn->prepare("SELECT *
                            FROM friends
                            WHERE friendId1 = ? AND friendId2 = ?
                            OR friendId1 = ? AND friendId2 = ?"); // get friendsId
        $stmt->bind_param("iiii", $friendId1, $friendId2, $friendId2, $friendId1);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying check servers";
    }
    if (empty($result)) {
        return -1;
    }
    if(mysqli_num_rows($result) == 0) {
        return -1;
    }
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
}
