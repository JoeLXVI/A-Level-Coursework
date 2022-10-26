<?php
include "conn.php";
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
         <h1>Sign In</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" class="UserCredentials" method="POST">
         <label for="UserName">Enter your name</label>
         <input type="text" name="UserName" id="UserName" placeholder="Name" required>
         <label for="UserPassword">Enter your password</label>
         <input type="password" name="UserPassword" id="UserPassword" placeholder="Password" required>
         <button type="submit" name="SubmitForm">Submit</button>
         <a href="signUp.php" id="createAccount">Create an account</a>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetUserName = $_POST['UserName'];
         $GetUserPassword = $_POST['UserPassword'];
         $sql = "SELECT * FROM users WHERE UserName = '$GetUserName'";
         $result = mysqli_query($conn, $sql);
         $resultRows = mysqli_num_rows($result);
         if ($resultRows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               if (password_verify($GetUserPassword, $row['UserPassword'])) {
                  $UserID = $row['UserID'];
                  echo $UserID;
                  // Redirect the user using JavaScript
                  $URL = "selectSet.php?uid=$UserID";
                  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                  // If JavaScript is not enabled this performs the same function
                  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
               } else {
                  echo "Incorrect Name and Password Combination";
               }
            }
         }
      }
      ?>
   </main>
</body>

</html>

<script src="JavaScript\ToggleTheme.js"></script>
<script src="JavaScript\ChangeFontSize.js"></script>