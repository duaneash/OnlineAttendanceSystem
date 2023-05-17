<?php
include 'connectToDatabase.php';

session_start();

// Connect to the database
$conn = connectToDatabase();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM teachers WHERE email='$email'";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['teacher_id'] = $user['id'];
            header("Location: course.php");
        } else {
            header("Location: login.html?message=Invalid password&type=danger");
        }
    } else {
        header("Location: login.html?message=No such user&type=danger");
    }
} else {
    header("Location: login.html?message=Query failed&type=danger");
}
?>
