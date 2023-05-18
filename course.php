<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();


$sql = "SELECT id, course_name FROM courses WHERE teacher_id = '{$_SESSION['teacher_id']}'";
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
        <tr><th>Course ID</th><th>Course Name</th><th>Actions</th><th>Attendance</th><th>Mark Attendance</th></tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td class='course-name' data-course-id='{$row['id']}'>{$row['course_name']}</td>";
            echo "<td>";
            echo "<a href='process_course.php?course_id={$row['id']}'>Delete</a>";
            echo "</td>";
            echo "<td>";
            echo "<a href='attendance.php?course_id={$row['id']}'>View</a>";  
            echo "</td>";
            echo "<td>";
            echo "<a href='mark_attendance.php?course_id={$row['id']}'>Mark</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>


    <form action='process_course.php' method='POST'>
        <input type='text' name='add_course' placeholder='Course Name'>
        <input type='submit' value='Add Course'>
    </form>
    <a href="logout.php">Logout</a>
</body>
</html>
