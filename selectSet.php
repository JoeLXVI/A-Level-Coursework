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
         $sql = $conn->prepare("SELECT SetID, SetTitle FROM sets WHERE OwnerID = ?");
         $sql->bind_param('i', $GetUserID);
         $sql->execute();
         $sql->store_result();
         $sql->bind_result($SetID, $SetTitle);
         $resultRows = $sql->num_rows();
         if ($resultRows > 0) {
            $count = 1;
            while ($sql->fetch()) { // Fetch the results of the query
               // Display all of the sets to the user, with a javascript function to allow them to view the specified set
               echo "<div class='SelectSet-Box' onclick='redirect($SetID, $GetUserID)')><p>" . $count . " - " .  $SetTitle . "</p></div>";
               $count += 1;
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