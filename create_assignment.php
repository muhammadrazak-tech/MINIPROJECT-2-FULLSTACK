<?php 
include 'db.php';
checkLogin();

// SECURITY: Kick out anyone who isn't an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php?error=unauthorized");
    exit();
}

include 'header.php';

// Simple check: if not admin, kick them out
if ($_SESSION['role'] !== 'admin') { header("Location: dashboard.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    mysqli_query($conn, "INSERT INTO assignments (title, description) VALUES ('$title', '$desc')");
    echo "<script>alert('Assignment Created!');</script>";
}
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 500px;">
        <h3>Admin: Create Assignment</h3>
        <form method="POST">
            <input type="text" name="title" class="form-control mb-3" placeholder="Title (e.g. Mini Project 1)" required>
            <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>
            <button type="submit" class="btn btn-dark w-100">Add to Database</button>
        </form>
    </div>
</div>