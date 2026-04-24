<?php
include 'header.php';
checkLogin();

if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized.");
}
?>
<div class="container">
    <h2 class="mb-4">Admin: All Submissions</h2>
    
    <div class="mb-3">
        <input type="text" id="live_search" class="form-control" placeholder="Type student name to search...">
    </div>

    <div class="card shadow">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Student</th>
                    <th>Assignment</th>
                    <th>File</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="submission_table">
                </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initial load
    fetchData();

    function fetchData(query = '') {
        $.ajax({
            url: "fetch_process.php",
            method: "POST",
            data: {search: query},
            success: function(data) {
                $('#submission_table').html(data);
            }
        });
    }

    $('#live_search').keyup(function() {
        var search = $(this).val();
        fetchData(search);
    });
});
</script>