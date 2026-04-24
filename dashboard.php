<?php
include 'header.php';
checkLogin();

$uid = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Get All Assignments (For everyone to see)
$assignments = mysqli_query($conn, "SELECT * FROM assignments ORDER BY created_at DESC");

// Get Student's Own Submissions (Only for students)
$my_submissions = [];
if ($role == 'student') {
    $sub_sql = "SELECT s.*, a.title FROM submissions s 
                JOIN assignments a ON s.assignment_id = a.id 
                WHERE s.user_id = $uid ORDER BY s.submitted_at DESC LIMIT 5";
    $my_submissions = mysqli_query($conn, $sub_sql);
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="<?php echo ($role == 'student') ? 'col-md-7' : 'col-md-12'; ?>">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><?php echo ($role == 'admin') ? 'Manage Assignments' : 'Available Assignments'; ?></h2>
                <?php if ($role == 'admin'): ?>
                    <a href="create_assignment.php" class="btn btn-primary">+ New Assignment</a>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php while($row = mysqli_fetch_assoc($assignments)): ?>
                    <div class="col-md-<?php echo ($role == 'student') ? '12' : '4'; ?> mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="fw-bold"><?php echo $row['title']; ?></h5>
                                <p class="small text-muted"><?php echo $row['description']; ?></p>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <?php if ($role == 'admin'): ?>
                                        <a href="edit_assignment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <a href="delete_assignment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this assignment?')">Delete</a>
                                    <?php else: ?>
                                        <a href="submit_assignment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Submit Work</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <?php if ($role == 'student'): ?>
        <div class="col-md-5">
            <h3 class="mb-4 text-primary">My Recent Work</h3>
            <?php if (mysqli_num_rows($my_submissions) > 0): ?>
                <?php while($sub = mysqli_fetch_assoc($my_submissions)): ?>
                    <div class="card mb-3 border-start border-primary border-4 shadow-sm">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0 fw-bold"><?php echo $sub['title']; ?></h6>
                                    <small class="text-muted"><?php echo date('d M, h:i A', strtotime($sub['submitted_at'])); ?></small>
                                </div>
                                <span class="badge bg-light text-dark border">Submitted</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex gap-2">
                                <a href="uploads/<?php echo $sub['file_path']; ?>" class="btn btn-sm btn-light border flex-grow-1" target="_blank">View</a>
                                <a href="edit_submission.php?id=<?php echo $sub['id']; ?>" class="btn btn-sm btn-warning">Replace</a>
                                <a href="delete_submission.php?id=<?php echo $sub['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this file?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <div class="text-center">
                    <a href="view_submissions.php" class="btn btn-link btn-sm">View All My Submissions</a>
                </div>
            <?php else: ?>
                <div class="alert alert-light border text-center">
                    <p class="mb-0 text-muted">You haven't submitted anything yet.</p>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>