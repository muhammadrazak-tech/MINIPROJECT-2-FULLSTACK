<?php
include 'db.php';
checkLogin();

$id = $_GET['id'];
$uid = $_SESSION['user_id'];

// Security: Only delete if the user owns the file
$res = mysqli_query($conn, "SELECT * FROM submissions WHERE id=$id AND user_id=$uid");
$data = mysqli_fetch_assoc($res);

if ($data) {
    // Delete physical file from uploads folder
    if (file_exists("uploads/" . $data['file_path'])) {
        unlink("uploads/" . $data['file_path']);
    }

    // Delete record from database
    mysqli_query($conn, "DELETE FROM submissions WHERE id=$id");
    header("Location: view_submissions.php?status=deleted");
} else {
    header("Location: view_submissions.php");
}
exit();