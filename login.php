<?php
session_start();
include('connection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
   <meta charset="utf-8">
   <title>SYSCX - Login</title>
   <link rel="stylesheet" href="assets/css/reset.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>
</head>
<body>
    <header>
        <h1>SYSCX</h1>
        <p>Social media for SYSC students in Carleton University</p>
    </header>
    <div id="info-right"></div>
    <nav id="nav-left">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="#">Log out</a></li>
        </ul>
    </nav>
    <main id="middle">
      <section>
        <h2>Login</h2>
        <form action="login_process.php" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </section>
   </main>
</body>
</html>
