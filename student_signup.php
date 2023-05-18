<!DOCTYPE html>
<html>
<head>
  <title>Student Registration</title>
  <link rel="stylesheet" type="text/css" href="CSS/styles.css">
  <script src="JS/main.js"></script>
</head>
<body>
  <div id="message"></div>
  <form id="registerForm" action="process_signup.php" method="post">
    <h2>Student Registration</h2>
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
	<input type="hidden" name="signup_type" value="student">
    <input type="submit" value="Register">
  </form>
  <p>Already registered? <a href="student_login.php">Login here</a></p>
</body>
</html>
