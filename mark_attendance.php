<?php
session_start();
include 'connectToDatabase.php';
$conn = connectToDatabase();

if (!isset($_GET['course_id'])) {
    exit('No course ID provided');
}

$course_id = $_GET['course_id'];

$sql = "SELECT students.id, students.name 
        FROM registrations
        JOIN students ON registrations.student_id = students.id
        WHERE registrations.course_id = '$course_id'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
</head>
<body>
    <h2>Mark Attendance</h2>
    <form action='process_attendance.php' method='POST'>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<label>{$row['name']}</label>";
            echo "<select name='attendance[{$row['id']}]'>
                <option value='Present'>Present</option>
                <option value='Absent'>Absent</option>
                <option value='Late'>Late</option>
                </select>";
        }
        ?>
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <input type='submit' value='Submit'>
    </form>
    <a href="course.php">Course Page</a>
</body>
</html>
