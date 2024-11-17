<?php
// Start session
session_start();

if (!isset($_SESSION['student_id'])) {
   header("Location: login.php");
   exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
   // Establish connection
   include('connection.php');

   // Get user ID from session
   $student_id = $_SESSION['user_id'];

   // Update data in users_info table
   $sql_info = "UPDATE USERS_INFO SET first_name=?, last_name=?, DOB=?, student_email=? WHERE student_id=?";
   $stmt_info = $conn->prepare($sql_info);
   $stmt_info->bind_param("ssssi", $first_name, $last_name, $DOB, $student_email, $student_id);

   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $DOB = $_POST['DOB'];
   $student_email = $_POST['student_email'];

   $stmt_info->execute();
   $stmt_info->close();

   // Update data in users_program table
   $program = $_POST['program'];
   $sql_program = "UPDATE USERS_PROGRAM SET program=? WHERE student_id=?";
   $stmt_program = $conn->prepare($sql_program);
   $stmt_program->bind_param("si", $program, $student_id);

   $stmt_program->execute();
   $stmt_program->close();

   // Update data in users_avatar table
   $avatar = $_POST['avatar'];
   $sql_avatar = "UPDATE USERS_AVATAR SET avatar=? WHERE student_id=?";
   $stmt_avatar = $conn->prepare($sql_avatar);
   $stmt_avatar->bind_param("si", $avatar, $student_id);

   $stmt_avatar->execute();
   $stmt_avatar->close();

   // Update data in users_address table
   $street_number = $_POST['street_number'];
   $street_name = $_POST['street_name'];
   $city = $_POST['city'];
   $province = $_POST['province'];
   $postal_code = $_POST['postal_code'];
   $sql_address = "UPDATE USERS_ADDRESS SET street_number=?, street_name=?, city=?, province=?, postal_code=? WHERE student_id=?";
   $stmt_address = $conn->prepare($sql_address);
   $stmt_address->bind_param("sssssi", $street_number, $street_name, $city, $province, $postal_code, $student_id);

   $stmt_address->execute();
   $stmt_address->close();

   // Close connection
   $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Update SYSCX profile</title>
   <link rel="stylesheet" href="assets/css/reset.css">
   <link rel="stylesheet" href="assets/css/style.css">
   <script src="assets/js/profile.js"></script>
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
   <main id="profile-middle">
      <section>
         <h2>Update Profile Information</h2>
         <form action="" method="post">
            <div class="input-sections">
               <fieldset>
                  <legend>
                     <span>Personal information</span>
                  </legend>
                  <div>
                     <label for="first_name">First Name:</label>
                     <input type="text" id="first_name" name="first_name" placeholder="ex: John Snow">
                     <label for="last_name">Last Name:</label>
                     <input type="text" id="last_name" name="last_name">
                     <label for="DOB">DOB:</label>
                     <input type="date" id="DOB" name="DOB">
                  </div>
               </fieldset>
            </div>
            <div class="input-sections">
               <fieldset>
                  <legend>
                     <span>Address</span>
                  </legend>
                  <div>
                     <label for="street_number">Street Number:</label>
                     <input type="text" id="street_number" name="street_number">
                     <label for="street_name">Street name:</label>
                     <input type="text" id="street_name" name="street_name">
                     <br>
                     <label for="city">City:</label>
                     <input type="text" id="city" name="city">
                     <label for="province">Province:</label>
                     <input type="text" id="province" name="province">
                     <label for="postal_code">Postal Code:</label>
                     <input type="text" id="postal_code" name="postal_code">
                  </div>
               </fieldset>
            </div>
            <div class="input-sections">
               <fieldset>
                  <legend>
                     <span>Profile Information</span>
                  </legend>
                  <div>
                     <label for="student_email">Email address:</label>
                     <input type="email" id="student_email" name="student_email">
                     <br>
                     <label for="program">Program</label>
                     <select id="program" name="program">
                        <option value="choose">Choose Program</option>
                        <option value="Computer Systems Engineering">Computer Systems Engineering</option>
                        <option value="Software Engineering">Software Engineering</option>
                        <option value="Communications Engineering">Communications Engineering</option>
                        <option value="Biomedical and Electrical">Biomedical and Electrical</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="Special">Special</option>
                     </select>
                     <br>
                     <div>
                        <label>Choose your Avatar</label>
                        <br>
                        <input type="radio" id="avatar1" name="avatar" value="avatar1">
                        <label for="avatar1"><img src="images/img_avatar1.png" alt="none"></label>
                        <input type="radio" id="avatar2" name="avatar" value="avatar2">
                        <label for="avatar2"><img src="images/img_avatar2.png" alt="none"></label>
                        <input type="radio" id="avatar3" name="avatar" value="avatar3">
                        <label for="avatar3"><img src="images/img_avatar3.png" alt="none"></label>
                        <input type="radio" id="avatar4" name="avatar" value="avatar4">
                        <label for="avatar4"><img src="images/img_avatar4.png" alt="none"></label>
                        <input type="radio" id="avatar5" name="avatar" value="avatar5">
                        <label for="avatar5"><img src="images/img_avatar5.png" alt="none"></label>
                     </div>
                     <input type="submit" value="Submit">
                     <input type="reset" value="Reset">
                  </div>
               </fieldset>
            </div>
         </form>
      </section>
   </main>
</body>
</html>