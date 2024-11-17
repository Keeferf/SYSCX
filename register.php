<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Register on SYSCX</title>
   <link rel="stylesheet" href="assets/css/reset.css">
   <link rel="stylesheet" href="assets/css/style.css">
   <script src="register.js"></script>
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
   <main id="profile-middle">
      <section>
         <h2>Update Profile Information</h2>
         <form method="post" onsubmit="return validatePaddword()">
            <div class="input-sections">
               <fieldset>
                  <legend>
                     <span>Personal information</span>
                  </legend>
                  <div>
                     <label for="firstname">First Name:</label>
                     <input type="text" id="firstname" name="first_name" placeholder="ex: John Snow">
                     <label for="lastname">Last Name:</label>
                     <input type="text" id="lastname" name="last_name">
                     <label for="dateofbirth">DOB:</label>
                     <input type="date" id="dateofbirth" name="DOB">
                  </div>
               </fieldset>
            </div>
            <div class="input-sections">
               <fieldset>
                  <legend>
                     <span>Profile Information</span>
                  </legend>
                  <div>
                     <label for="emailaddress">Email address:</label>
                     <input type="email" id="emailaddress" name="student_email">
                     <br>
                     <label for="password">Password:</label>
                     <input type="password" id="password" name="password">
                     <br>
                     <label for="confirmPassword">Confirm Password:</label>
                     <input type="password" id="confirmPassword" name="confirm_password">
                     <span id="passwordError" style="color: red;"></span>
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
                     <input type="submit" value="Register">
                     <input type="reset" value="Reset">
                  </div>
               </fieldset>
            </div>
         </form>
      </section>   
   </main>

   <?php
   session_start();

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Establish connection
      include('connection.php');

      // Check if email already exists
      $student_email = $_POST['student_email'];
      $sql_check_email = "SELECT * FROM USERS_INFO WHERE student_email = ?";
      $stmt_check_email = $conn->prepare($sql_check_email);
      $stmt_check_email->bind_param("s", $student_email);
      $stmt_check_email->execute();
      $result_check_email = $stmt_check_email->get_result();

      if ($result_check_email->num_rows > 0) {
         // Email already exists, display error message
         echo "<p>Email address already exists. Please enter a new email address.</p>";
         echo "<a href='register.php'>Go back to registration</a>";
      } else {
         // Email doesn't exist, proceed with registration
         registerUser($conn);
      }

      // Close prepared statement for checking email
      $stmt_check_email->close();
   }

   function registerUser($conn) {
      // Extracting registration data
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $DOB = $_POST['DOB'];

      // Hash password
      $password = $_POST['password'];
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      // Insert info into users_info table
      $student_email = $_POST['student_email'];
      $sql_info = "INSERT INTO USERS_INFO (student_email, first_name, last_name, DOB) VALUES (?, ?, ?, ?)";
      $stmt_info = $conn->prepare($sql_info);
      $stmt_info->bind_param("ssss", $student_email, $first_name, $last_name, $DOB);
      $stmt_info->execute();

      // Get the auto-generated ID from previous insertion
      $student_id = $stmt_info->insert_id;

      // Store student_id in session
      $_SESSION['user_id'] = $student_id;

      // Insert info into users_passwords table
      $sql_password = "INSERT INTO USERS_PASSWORDS (student_id, password) VALUES (?, ?)";
      $stmt_password = $conn->prepare($sql_password);
      $stmt_password->bind_param("is", $student_id, $hashed_password);
      $stmt_password->execute();

      // Insert info into users_program table
      $program = $_POST['program'];
      $sql_program = "INSERT INTO USERS_PROGRAM (student_id, program) VALUES (?, ?)";
      $stmt_program = $conn->prepare($sql_program);
      $stmt_program->bind_param("is", $student_id, $program);
      $stmt_program->execute();

      // Insert default values into users_avatar table
      $sql_avatar = "INSERT INTO USERS_AVATAR (student_id, avatar) VALUES (?, NULL)";
      $stmt_avatar = $conn->prepare($sql_avatar);
      $stmt_avatar->bind_param("i", $student_id);
      $stmt_avatar->execute();

      // Insert default values into users_address table
      $sql_address = "INSERT INTO USERS_ADDRESS (student_id, street_number, street_name, city, province, postal_code) VALUES (?, 0, NULL, NULL, NULL, NULL)";
      $stmt_address = $conn->prepare($sql_address);
      $stmt_address->bind_param("i", $student_id);
      $stmt_address->execute();

      // Close prepared statements
      $stmt_info->close();
      $stmt_password->close();
      $stmt_program->close();
      $stmt_avatar->close();
      $stmt_address->close();

      // Redirect to profile page
      header("Location: profile.php");
      exit();
   }
   ?>
</body>
</html>
