<?php
include 'header.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['student_file'])) {
    $aid = $_POST['assignment_id'];
    $uid = $_SESSION['user_id'];
    $file = $_FILES['student_file'];

    // PHP Validation (Server-Side)
    $allowed_ext = ['pdf', 'docx', 'zip'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<div class='alert alert-danger mt-3 text-center'>PHP Error: Only PDF, DOCX, and ZIP allowed.</div>";
    // Change 5000000 to 1000000
        } elseif ($file['size'] > 1000000) { 
            echo "<div class='alert alert-danger mt-3 text-center'>PHP Error: File too large (Max 1MB).</div>";
        } else {
        $folder = "uploads/";
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        
        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $file['name']);
        if (move_uploaded_file($file['tmp_name'], $folder . $fileName)) {
            mysqli_query($conn, "INSERT INTO submissions (user_id, assignment_id, file_path) VALUES ('$uid', '$aid', '$fileName')");
            echo "<div class='alert alert-success mt-3 text-center'>Successfully submitted!</div>";
        }
    }
}

$assignments = mysqli_query($conn, "SELECT * FROM assignments");
?>

<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 600px; border-radius: 12px;">
        <h3 class="mb-4 text-center">Upload Assignment</h3>
        
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Select Assignment</label>
                <select name="assignment_id" class="form-select" required>
                    <option value="">-- Choose Assignment --</option>
                    <?php while($row = mysqli_fetch_assoc($assignments)): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File (PDF, DOCX, ZIP)</label>
                <input type="file" id="student_file" name="student_file" class="form-control" accept=".pdf,.docx,.zip" required>
                <p id="js-error" class="text-danger small mt-2 fw-bold"></p>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Submit File</button>
        </form>
    </div>
</div>

<script>
document.getElementById('uploadForm').onsubmit = function(e) {
    const fileInput = document.getElementById('student_file');
    const errorDiv = document.getElementById('js-error');
    const file = fileInput.files[0];
    
    // Clear previous error messages
    errorDiv.innerHTML = "";

    if (file) {
        // Check Extension
        const fileName = file.name;
        const extension = fileName.split('.').pop().toLowerCase();
        const allowed = ['pdf', 'docx', 'zip'];

        if (!allowed.includes(extension)) {
            e.preventDefault(); // Stop the form from submitting
            errorDiv.innerHTML = "JS Error: Only PDF, DOCX, and ZIP files are allowed!";
            return false;
        }

        // 2. Check Size (Changed from 5MB to 1MB)
        if (file.size > 1 * 1024 * 1024) {
            e.preventDefault(); 
            errorDiv.innerHTML = "JS Error: File is too large! Maximum 1MB allowed.";
            return false;
        }
    }
};
</script>

<?php include 'footer.php'; ?>