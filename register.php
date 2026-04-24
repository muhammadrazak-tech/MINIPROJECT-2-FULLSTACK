<?php
include 'header.php';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Hash the password for security
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    // Get the role from the dropdown
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='container mt-3'><div class='alert alert-success shadow-sm'>Registration successful! You can now <a href='login.php' class='alert-link'>Login</a>.</div></div>";
    } else {
        echo "<div class='container mt-3'><div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div></div>";
    }
}
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto shadow-sm" style="max-width: 450px; border-radius: 15px;">
        <h2 class="text-center mb-4">Create Account</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a password" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Register As</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>-- Select Role --</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <button type="submit" name="register" class="btn btn-primary w-100 py-2" style="border-radius: 8px;">
                Register Account
            </button>
            
            <div class="text-center mt-3">
                <small>Already have an account? <a href="login.php">Login here</a></small>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>