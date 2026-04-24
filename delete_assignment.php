<?php
include 'db.php';
checkLogin();

if ($_SESSION['role'] === 'admin' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // This will also delete related submissions because of 'ON DELETE CASCADE' in your SQL
    $sql = "DELETE FROM assignments WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>