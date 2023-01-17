<?php
include "conn.php";
$GetUserID = $_GET['uid']; // Using the GET method to retrieve form the URL
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
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Select a Set</a></li>
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
                     echo "<li><a href='inviteStudent.php?uid=" . $GetUserID . "'>Invite Student to a Class</a></li>";
                  } else {
                     echo "<li><a href='joinClass.php?uid=" . $GetUserID . "'>Join a Class</a></li>";
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
         <h1>Validate Account</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" method="post" class="UserCredentials">
         <label for="ValidationCode">Enter your validation code</label>
         <input type="text" name="ValidationCode" id="ValdationCode" required placeholder="Validation Code">
         <button type="submit" name="SubmitForm">Submit</button>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetUserValidationCode = $_POST['ValidationCode'];
         // Select the validation code of the user
         $sql = $conn->prepare("SELECT ValidationCode FROM users WHERE UserID = ?");
         $sql->bind_param('i', $GetUserID);
         $sql->execute();
         $sql->store_result();
         $sql->bind_result($ValidationCode);
         while ($sql->fetch()) { // Fetch the results of the query
            if ($GetUserValidationCode === $ValidationCode) {
               $sql = $conn->prepare("UPDATE users SET Validated=1 WHERE UserID = ?");
               $sql->bind_param('i', $GetUserID);
               if ($sql->execute() === TRUE) { // Check if the update has gone through
                  $URL = "selectSet.php?uid=$GetUserID";
                  // Redirect the user using JavaScript
                  echo "<script type='text/javascript'>alert('Account Validated'); document.location.href='{$URL}';</script>";
                  // If JavaScript is not enabled this performs the same function
                  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
               } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
               }
            } else {
               echo 'Incorrect Code';
            }
         }
      }
      ?>
   </main>
</body>

</html>