<?php
include 'header.php';
checkLogin();

if ($_SESSION['role'] !== 'admin') { die("Admins only."); }

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM assignments WHERE id = $id");
$data = mysqli_fetch_assoc($res);

if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "UPDATE assignments SET title='$title', description='$desc' WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated successfully!'); window.location='dashboard.php';</script>";
    }
}
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 600px;">
        <h3>Edit Assignment</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" required><?php echo $data['description']; ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Update Assignment</button>
            <a href="dashboard.php" class="btn btn-link w-100 mt-2">Cancel</a>
        </form>
    </div>
</div>