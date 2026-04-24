<?php
include 'header.php';
checkLogin();

// Get the submission ID from the URL
$id = mysqli_real_escape_string($conn, $_GET['id']);
$uid = $_SESSION['user_id'];

// SECURITY CHECK: Only fetch if this submission belongs to the logged-in student
$res = mysqli_query($conn, "SELECT * FROM submissions WHERE id='$id' AND user_id='$uid'");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    die("<div class='container mt-5'><div class='alert alert-danger'>Access Denied or Submission not found.</div></div>");
}

if (isset($_POST['update_file'])) {
    $file = $_FILES['new_file'];
    $allowed = ['pdf', 'docx', 'zip'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo "<div class='alert alert-danger'>Invalid format. Only PDF, DOCX, ZIP allowed.</div>";
    } else {
        $folder = "uploads/";
        
        // Delete the OLD physical file from the folder
        if (file_exists($folder . $data['file_path'])) {
            unlink($folder . $data['file_path']);
        }

        // Upload the NEW physical file
        $newFileName = time() . "_" . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $folder . $newFileName)) {
            
            // Update the database with the new filename
            mysqli_query($conn, "UPDATE submissions SET file_path='$newFileName', submitted_at=NOW() WHERE id='$id'");
            echo "<script>alert('File replaced successfully!'); window.location='view_submissions.php';</script>";
        }
    }
}
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto shadow-sm" style="max-width: 500px;">
        <h3>Update Your Submission</h3>
        <p class="text-muted small">Current file: <?php echo $data['file_path']; ?></p>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Select New File</label>
                <input type="file" name="new_file" class="form-control" required>
            </div>
            <button type="submit" name="update_file" class="btn btn-warning w-100">Replace & Upload</button>
            <a href="view_submissions.php" class="btn btn-link w-100 mt-2">Cancel</a>
        </form>
    </div>
</div>