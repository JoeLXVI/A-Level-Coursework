<?php
include "conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src\Exception.php';
require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>NEA Flashcard Website</title>
   <link rel="stylesheet" href="CSS\styles.css">
</head>

<body class="darkTheme normalFontSize">
   <header>
      <nav>
         <ul>
            <li><a href="selectSet.php">Home</a></li>
            <li><a href="createFlashcard.php">Create a Card</a></li>
            <div class="shiftRight">
               <li class="active"><a href="signIn.php">Sign In</a></li>
               <li id="increaseText"><a href="#">Increase Font Size</a></li>
               <li id="decreaseText"><a href="#">Decrease Font Size</a></li>
               <li id="themeToggle"><a href="#">Toggle Theme</a></li>
            </div>
         </ul>
      </nav>
      <div class="title">
         <h1>Sign Up</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" class="UserCredentials" method="POST">
         <!-- Form for the user to enter their desired account details -->
         <label for="UserName">Enter your name</label>
         <input type="text" name="UserName" id="UserName" placeholder="Name" required>
         <label for="UserEmail">Enter your email address</label>
         <input type="email" name="UserEmail" id="UserEmail" placeholder="example@email.com" required>
         <label for="UserPassword">Enter your password</label>
         <input type="password" name="UserPassword" id="UserPassword" placeholder="Password" required>
         <label for="UserConfirmPassword">Confirm your password</label>
         <input type="password" name="UserConfirmPassword" id="UserConfirmPassword" placeholder="Retype Password" required>
         <div id="AccountType-Option">
            <label for="">Are you a student or teacher?</label>
            <div id="StudentOption">
               <input type="radio" name="AccountOption" id="AccountOption" value="1">
               <label for="">Student</label>
            </div>
            <div id="TeacherOption">
               <input type="radio" name="AccountOption" id="AccountOption" value="2">
               <label for="">Teacher</label>
            </div>
         </div>
         <button type="submit" name="SubmitForm">Sign Up</button>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetUserName = $_POST['UserName'];
         $GetUserEmail = $_POST['UserEmail'];
         $GetUserPassword = $_POST['UserPassword'];
         $GetUserConfirmPassword = $_POST['UserConfirmPassword'];
         $GetUserAccountType = $_POST['AccountOption'];
         $UserValidationCode = substr(str_shuffle("0123456789"), 0, 5); //Generate a 5 digit validation code
         if ($GetUserPassword !== $GetUserConfirmPassword) {
            echo "Passwords do not match";
            exit;
         }
         $HashedPassword = password_hash($GetUserPassword, PASSWORD_DEFAULT);
         //SQL Query to create the user in the database
         $sql = "INSERT INTO users (UserName, EmailAddress, UserPassword, UserType, ValidationCode) VALUES ('$GetUserName', '$GetUserEmail', '$HashedPassword', $GetUserAccountType, '$UserValidationCode')";
         if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
         }

         // Code to send an email containing the validation code to the user
         // Initiate the library
         $mail = new PHPMailer();
         //Set the email to SMTP 
         $mail->IsSMTP();
         $mail->SMTPDebug = 2;
         $mail->SMTPAuth = true;
         // Log in to the created Account
         $mail->Host = "smtp.office365.com";
         $mail->Port = 587;
         $mail->Username = "signupcoursework@hotmail.com";
         $mail->Password = "pcA6dftVRd5yNkG";
         $mail->SetFrom("signupcoursework@hotmail.com");
         // Construct the email to be sent
         $mail->AddAddress($GetUserEmail, $GetUserName);
         $mail->Subject = 'Your Validation Code';
         $message = "<center>Hi " . $GetUserName . ", <br><br> Your validation code is: <br>" . $UserValidationCode . "</center>";
         $mail->msgHTML($message);
         $mail->From = $mail->Username;
         // Send the email and check for any errors
         if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
         } else {
            echo "<script>window.location.assign('validateAccount.php')</script>";
         }
      }
      ?>
   </main>
</body>

</html>

<script src="JavaScript\ToggleTheme.js"></script>
<script src="JavaScript\ChangeFontSize.js"></script>