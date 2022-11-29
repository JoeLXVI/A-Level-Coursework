<?php
include 'conn.php';
$GetUserID = $_GET['uid']; // Using the GET method to retrieve form the URL

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
            <!-- The anchor elements containing php in the href allow for the user to be redirected with their ID in the URl -->
            <!-- This means that the user is recognised throughout the entire website and can see the sets linked to them -->
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Home</a></li>
            <li><a href="createFlashcard.php?uid=<?php echo $GetUserID ?>">Create a Card</a></li>
            <?php
            // PHP to give teachers access to the pages relating to the creation of classes as well as inviting students to classes
            $sql_GetAccountType = $conn->prepare("SELECT UserType FROM users WHERE UserID = ?");
            $sql_GetAccountType->bind_param('i', $GetUserID);
            $sql_GetAccountType->execute();
            $sql_GetAccountType->store_result();
            $sql_GetAccountType->bind_result($UserType);
            $resultRows = $sql_GetAccountType->num_rows();
            if ($resultRows > 0) {
               while ($sql_GetAccountType->fetch()) { // Fetch the results of the query
                  if ($UserType >= 2) {
                     echo "<li><a href='createClass.php?uid=" . $GetUserID . "'>Create a Class</a></li>";
                     echo "<li class='active'><a href='inviteStudent.php?uid=" . $GetUserID . "'>Invite Student to a Class</a></li>";
                  }
               }
            }
            ?>
            <div class="shiftRight">
               <li><a href="signIn.php">Sign In </a></li>
               <li id="increaseText"><a href="#">Increase Font Size</a></li>
               <li id="decreaseText"><a href="#">Decrease Font Size</a></li>
               <li id="themeToggle"><a href="#">Toggle Theme</a></li>
            </div>
         </ul>
      </nav>
      <div class="title">
         <h1>Invite a Student to a Class</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" class="ClassCredentials" method="POST">
         <label for="StudentEmail">Please enter the email address of the student</label>
         <input type="email" id="StudentEmail" name="StudentEmail" placeholder="example@email.com" required>
         <label for="ClassID">Which class would you like to add them to?</label>
         <select name="ClassID" id="ClassID">
            <?php
            // Get and store all of the users sets
            $sql = $conn->prepare("SELECT ClassID, ClassName FROM classinfo WHERE ClassTeacher = ?");
            $sql->bind_param('i', $GetUserID);
            $sql->execute();
            $sql->store_result();
            $sql->bind_result($ClassID, $ClassName);
            $resultRows = $sql->num_rows();
            if ($resultRows > 0) {
               while ($sql->fetch()) { // Fetch the results of the query
                  // Put the user's sets as options in the '<select>' element
                  echo "<option value='" . $ClassID . "'>" . $ClassName . "</option>";
               }
            }
            ?>
         </select>
         <button type="submit" name="SubmitForm">Submit</button>
      </form>
      <!-- PHP to check that the student email exists within the database, and then email the class code to the student -->
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetStudentEmail = $_POST['StudentEmail'];
         $GetClassID = $_POST['ClassID'];
         // Check if the student email exists
         $sql_CheckStudentEmail = $conn->prepare("SELECT UserID, UserName FROM users WHERE EmailAddress = ?");
         $sql_CheckStudentEmail->bind_param('s', $GetStudentEmail);
         $sql_CheckStudentEmail->execute();
         $sql_CheckStudentEmail->store_result();
         $sql_CheckStudentEmail->bind_result($UserID, $GetUserName);
         $resultRows = $sql_CheckStudentEmail->num_rows();
         while ($sql_CheckStudentEmail->fetch()) {
            if ($resultRows > 0) {
               // Get the class name and code to put into the email
               $sql_GetClassInfo = $conn->prepare("SELECT ClassName, ClassCode FROM classinfo WHERE ClassID = ?");
               $sql_GetClassInfo->bind_param('i', $GetClassID);
               $sql_GetClassInfo->execute();
               $sql_GetClassInfo->store_result();
               $sql_GetClassInfo->bind_result($StoredClassName, $ClassCode);
               while ($sql_GetClassInfo->fetch()) {
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
                  $mail->Password = "CourseworkSignUp";
                  $mail->SetFrom("signupcoursework@hotmail.com");
                  // Construct the email to be sent
                  $mail->AddAddress($GetStudentEmail, $GetUserName);
                  $mail->Subject = 'Your Validation Code';
                  $message = "<center>Hi " . $GetUserName . ", <br><br> You have been invited to join the class '" . $StoredClassName . "'<br><br> Use the following code <a href='localhost/A-Level-Coursework/joinClass.php?uid=" . $UserID . "'>here</a> to join the class: " . $ClassCode . "</center>";
                  $mail->msgHTML($message);
                  $mail->From = $mail->Username;
                  // Send the email and check for any errors
                  if (!$mail->Send()) {
                     echo "Mailer Error: " . $mail->ErrorInfo;
                  } else {
                     $URL = "inviteStudent.php?uid=$GetUserID";
                     echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                  }
               }
            }
         }
      }
      ?>
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>