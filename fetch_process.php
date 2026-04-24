<?php
include 'db.php';

$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

$query = "SELECT s.file_path, s.submitted_at, a.title, u.name 
          FROM submissions s 
          LEFT JOIN assignments a ON s.assignment_id = a.id 
          LEFT JOIN users u ON s.user_id = u.id";

if ($search != '') {
    $query .= " WHERE u.name LIKE '%$search%'";
}

$query .= " ORDER BY s.id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['title']}</td>
                <td><a href='uploads/{$row['file_path']}' target='_blank'>View File</a></td>
                <td>{$row['submitted_at']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center'>No records found.</td></tr>";
}
?>