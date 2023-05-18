<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();


$sql = "SELECT courses.id, courses.course_name FROM courses INNER JOIN registrations ON courses.id = registrations.course_id WHERE registrations.student_id = '{$_SESSION['student_id']}'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
    <script src="JS/main.js" defer></script>
</head>
<body>
    <table>
        <tr><th>Course ID</th><th>Course Name</th><th></th></tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td class='course-name' data-course-id='{$row['id']}'>{$row['course_name']}</td>";
            echo "<td>";
            echo "<a href='student_attendance.php?course_id={$row['id']}'>Attendance Info</a>";  
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
