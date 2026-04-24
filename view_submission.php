<?php
include 'header.php';
checkLogin();

$uid = $_SESSION['user_id'];
// Fetch only the logged-in student's submissions
$sql = "SELECT s.*, a.title 
        FROM submissions s 
        JOIN assignments a ON s.assignment_id = a.id 
        WHERE s.user_id = $uid 
        ORDER BY s.submitted_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
    <h2 class="mb-4">My Submissions</h2>
    <div class="card shadow">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Assignment</th>
                    <th>File</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><a href="uploads/<?php echo $row['file_path']; ?>" target="_blank">View File</a></td>
                    <td><?php echo $row['submitted_at']; ?></td>
                    <td>
                        <a href="edit_submission.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Replace File</a>
                        <a href="delete_submission.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete your submission?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>