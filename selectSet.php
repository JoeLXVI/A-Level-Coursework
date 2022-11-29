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
            <li class="active"><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Home</a></li>
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
         <h1>Select a Set</h1>
         <hr>
      </div>
   </header>
   <main>
      <h2>Choose from one of the following sets</h2>
      <div id="SelectSet-Container">
         <?php
         // Retrieve all the sets belonging to the logged in user
         $sql_GetUserSets = $conn->prepare("SELECT SetID, SetTitle FROM sets WHERE OwnerID = ?");
         $sql_GetUserSets->bind_param('i', $GetUserID);
         $sql_GetUserSets->execute();
         $sql_GetUserSets->store_result();
         $sql_GetUserSets->bind_result($SetID, $SetTitle);
         $resultRows = $sql_GetUserSets->num_rows();
         $count = 1;
         if ($resultRows > 0) {
            while ($sql_GetUserSets->fetch()) { // Fetch the results of the query
               // Display all of the sets to the user, with a javascript function to allow them to view the specified set
               echo "<div class='SelectSet-Box' onclick='redirect($SetID, $GetUserID)')><p>" . $count . " - " .  $SetTitle . "</p><p>Created by <i>you</i></p></div>";
               $count += 1;
            }
         }

         // Retrieve all the sets from classes the user is in
         $sql_GetUserClasses = $conn->prepare("SELECT ClassID FROM classstudents WHERE StudentID = ?");
         $sql_GetUserClasses->bind_param('i', $GetUserID);
         $sql_GetUserClasses->execute();
         $sql_GetUserClasses->store_result();
         $sql_GetUserClasses->bind_result($ClassID);
         $resultRows = $sql_GetUserClasses->num_rows();
         if ($resultRows > 0) {
            while ($sql_GetUserClasses->fetch()) {
               // Get the name of the class
               $sql_GetClassName = $conn->prepare("SELECT ClassName FROM classinfo WHERE ClassID = ?");
               $sql_GetClassName->bind_param('i', $ClassID);
               $sql_GetClassName->execute();
               $sql_GetClassName->store_result();
               $sql_GetClassName->bind_result($ClassName);

               // Get the sets from the class
               $sql_GetClassSets = $conn->prepare("SELECT SetID FROM classsets WHERE ClassID = ?");
               $sql_GetClassSets->bind_param('i', $ClassID);
               $sql_GetClassSets->execute();
               $sql_GetClassSets->store_result();
               $sql_GetClassSets->bind_result($SetID);

               while ($sql_GetClassName->fetch() and $sql_GetClassSets->fetch()) {
                  // Get the titles of the sets
                  $sql_GetSetNames = $conn->prepare("SELECT SetTitle FROM sets WHERE SetID = ?");
                  $sql_GetSetNames->bind_param('i', $SetID);
                  $sql_GetSetNames->execute();
                  $sql_GetSetNames->store_result();
                  $sql_GetSetNames->bind_result($SetTitle);
                  while ($sql_GetSetNames->fetch()) {
                     echo "<div class='SelectSet-Box' onclick='redirect($SetID, $GetUserID)')><p>" . $count . " - " .  $SetTitle . "</p><p>Created by <i>" . $ClassName . "</i></p></div>";
                     $count += 1;
                  }
               }
            }
         }
         ?>
      </div>
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>
<script src="JavaScript\SetRedirect.js"></script>