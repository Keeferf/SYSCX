<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Include connection file
include('connection.php');

// Fetch last 10 posts
$sql_last_posts = "SELECT * FROM USERS_POSTS ORDER BY post_date DESC LIMIT 10";
$result_last_posts = $conn->query($sql_last_posts);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>SYSCX - Main</title>
   <link rel="stylesheet" href="assets/css/reset.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
   <header>
      <h1>SYSCX</h1>
      <p>Social media for SYSC students in Carleton University</p>
   </header>
   <div id="info-right">
      <div>
         <h2>Keefer Belanger</h2>
         <img src="images/img_avatar1.png" alt="none">
         <p>Email:</p>
         <p><a href="mailto:keeferbelanger@cmail.carleton.ca">keeferbelanger@cmail.carleton.ca</a></p>
         <p>Program:</p>
         <p>Software Engineering</p>
      </div>
   </div>
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
         <h2>New Post</h2>
         <form method="post">
            <fieldset>
               <table>
                  <tr>
                     <td>
                        <textarea name="new_post" rows="4" cols="40" placeholder="What is happening?! (max 280 char)"></textarea>
                     <br>
                     <input type="submit" value="Post" name="submit">
                     <input type="reset" value="Reset">
                     </td>
                  </tr>
               </table>
            </fieldset>
         </form>
         <h2>Last 10 Posts</h2>
         <?php
         if (isset($result_last_posts) && $result_last_posts->num_rows > 0) {
            while ($row = $result_last_posts->fetch_assoc()) {
               echo "<details>";
               echo "<summary>" . $row['post_date'] . "</summary>";
               echo "<p>" . $row['new_post'] . "</p>";
               echo "</details>";
            }
         }
         else {
            $log_message = date("Y-m-d H:i:s") . " - No posts to display\n";
            $log_file = 'assets/connection_log.txt';
            file_put_contents($log_file, $log_message, FILE_APPEND);
         }
         ?>
      </section>
   </main>

   <?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Establish connection
      include('connection.php');

      // Get user ID from session
      $student_id = $_SESSION['user_id'];

      // User input for a new post
      $new_post = $_POST['new_post'];

      // Insert data into USERS_POSTS table using prepared statement
      $sql_post = "INSERT INTO USERS_POSTS (student_id, new_post, post_date) VALUES (?, ?, NOW())";
      $stmt = $conn->prepare($sql_post);
      $stmt->bind_param("is", $student_id, $new_post);
      $stmt->execute();

      // Log successful or unsuccessful posts
      if ($stmt) {
         $log_message = date("Y-m-d H:i:s") . " - New post added successfully: " . $new_post . "\n";
      } 
      else {
         $log_message = date("Y-m-d H:i:s") . " - Error adding new post: " . $conn->error . "\n";
      }
      $log_file = 'assets/connection_log.txt';
      file_put_contents($log_file, $log_message, FILE_APPEND);

      // Close prepared statement
      $stmt->close();

      // Close connection
      $conn->close();
    }
    ?>

</body>
</html>