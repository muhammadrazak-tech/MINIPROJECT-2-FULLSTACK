<?php
include 'header.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($user = mysqli_fetch_assoc($res)) {
        if (password_verify($password, $user['password'])) { // Verify hashing
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='container'><div class='alert alert-danger'>Invalid password.</div></div>";
        }
    } else {
        echo "<div class='container'><div class='alert alert-danger'>User not found.</div></div>";
    }
}
?>
<div class="container">
    <div class="card p-4 mx-auto shadow" style="max-width: 400px;">
        <h2 class="text-center">Login</h2>
        <form method="POST">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-success w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <small>New user? <a href="register.php">Click here to register</a></small>
        </div>
    </div>
</div>