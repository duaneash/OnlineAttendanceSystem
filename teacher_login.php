<!DOCTYPE html>
<html>
<head>
  <title>Teacher Login</title> 
  <link rel="stylesheet" type="text/css" href="CSS/styles.css">
  <script src="JS/main.js"></script>
</head>
<body>
  <?php if (isset($_GET['message'])): ?>
    <p class="error-message"><?php echo $_GET['message']; ?></p>
  <?php endif; ?>
  <form id="loginForm" action="process_login.php" method="post">
	<h2>Teacher Login</h2>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
	<input type="hidden" name="userType" value="teacher">
    <input type="submit" value="Login">
  </form>
  <p>Not registered? <a href="teacher_signup.php">Register here</a></p>
</body>
</html>
