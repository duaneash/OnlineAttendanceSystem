<?php
include 'connectToDatabase.php';

session_start();

$conn = connectToDatabase();

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$hash = password_hash($password, PASSWORD_BCRYPT);

// Assuming there's a signup_type hidden field in your forms to identify if it's a student or a teacher signup
$signup_type = $_POST['signup_type'];

if ($signup_type == 'teacher') {
    $query = "INSERT INTO teachers (name, email, password) VALUES ('$name', '$email', '$hash')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'Registration successful!';
        $_SESSION['signup_message_type'] = 'success';
        header("Location: teacher_login.php?message=Registration successful&type=success");
    } else {
        $_SESSION['message'] = 'Registration failed!';
        $_SESSION['signup_message_type'] = 'danger';
        header("Location: teacher_login.php?message=Registration failed&type=danger");
    }
} else if ($signup_type == 'student') {
    $query = "INSERT INTO students (name, email, password) VALUES ('$name', '$email', '$hash')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'Registration successful!';
        $_SESSION['signup_message_type'] = 'success';
        header("Location: student_login.php?message=Registration successful&type=success");
    } else {
        $_SESSION['message'] = 'Registration failed!';
        $_SESSION['signup_message_type'] = 'danger';
        header("Location: student_login.php?message=Registration failed&type=danger");
    }
} else {
    // If the signup type is neither teacher nor student
    $_SESSION['message'] = 'Invalid signup type!';
    $_SESSION['signup_message_type'] = 'danger';
    header("Location: signup.php?message=Invalid signup type&type=danger");
}
?>
