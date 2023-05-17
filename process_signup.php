<?php
include 'connectToDatabase.php';

// Connect to the database
$conn = connectToDatabase();

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$hash = password_hash($password, PASSWORD_BCRYPT);

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
?>

