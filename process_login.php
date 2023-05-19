<?php
include 'connectToDatabase.php';

session_start();

$conn = connectToDatabase();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$userType = $_POST['userType'];

if ($userType === 'teacher') {
    $query = "SELECT * FROM teachers WHERE email='$email'";
    $loginPage = "index.php";
    $redirectPage = "teacher_course.php";
    $sessionVariable = 'teacher_id';
} else if ($userType === 'student') {
    $query = "SELECT * FROM students WHERE email='$email'";
    $loginPage = "index.php";
    $redirectPage = "student_course.php";
    $sessionVariable = 'student_id';
} else {
	header("Location: index.php?message=Invalid, please try again.");
    exit();
}

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION[$sessionVariable] = $user['id'];
            header("Location: $redirectPage");
            exit();
        } else {
            header("Location: $loginPage?message=Invalid password&type=danger");
            exit();
        }
    } else {
        header("Location: $loginPage?message=Username or Password is incorrect, please try again. &type=danger");
        exit();
    }
} else {
    header("Location: $loginPage?message=Query failed&type=danger");
    exit();
}
?>
