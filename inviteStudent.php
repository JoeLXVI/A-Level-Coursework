<?php
include 'conn.php';
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
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Home</a></li>
            <li class="active"><a href="createFlashcard.php?uid=<?php echo $GetUserID ?>">Create a Card</a></li>
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
         <h1>invite a Student to a Class</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" class="ClassCredentials">
         <label for="StudentEmail">Please enter the email address of the student</label>
         <input type="email" id="StudentEmail" name="StudentEmail" placeholder="example@email.com" required>
         <label for="ClassName">Which class would you like to add them to?</label>
         <select name="ClassName" id="ClassName">
            <option value="1">Class 1</option>
            <option value="2">Class 2</option>
            <option value="3">Class 3</option>
         </select>
         <button type="submit">Submit</button>
      </form>
      <!-- PHP to check that the student email and class name exist within the database, and then email the class code to the student -->
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>