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
            <li><a href="selectSet.php">Home</a></li>
            <li><a href="createFlashcard.php">Create a Card</a></li>
            <div class="shiftRight">
               <li class="active"><a href="signIn.php">Sign In </a></li>
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
         $sql = "SELECT ValidationCode FROM users WHERE UserID = $GetUserID";
         $result = mysqli_query($conn, $sql);
         while ($row = mysqli_fetch_assoc($result)) { // Fetch the results of the query
            if ($GetUserValidationCode === $row['ValidationCode']) {
               $sql = "UPDATE users SET Validated=1 WHERE UserID = $GetUserID";
               if ($conn->query($sql) === TRUE) { // Check if the update has gone through
                  $URL = "selectSet.php?uid=$GetUserID";
                  // Redirect the user using JavaScript
                  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
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