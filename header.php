<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Assignment Portal</a>
        <div class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a class="nav-link" href="create_assignment.php">Create</a>
                    <a class="nav-link" href="view_all_submissions.php">All Submissions</a>
                <?php else: ?>
                    <a class="nav-link" href="submit_assignment.php">Submit Work</a>
                <?php endif; ?>
                <a class="nav-link text-danger" href="logout.php">Logout (<?php echo $_SESSION['name']; ?>)</a>
            <?php else: ?>
                <a class="nav-link" href="login.php">Login</a>
                <a class="nav-link" href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>