<?php
include 'conn.php';
$GetSetID = $_GET['sid']; // Using the GET method to retrieve form the URL
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
         <h1>Flashcard Viewer</h1>
         <hr>
      </div>
   </header>
   <!-- Using inline styling as these properties are only needed on this page -->
   <main style="position: relative;">
      <!-- Using inline styling as these properties are only needed on this page -->
      <h2 style="position: absolute; top:41px;">
         <?php
         $sql_GetSetTitle = $conn->prepare("SELECT SetTitle FROM sets WHERE SetID = ?");
         $sql_GetSetTitle->bind_param('i', $GetSetID);
         $sql_GetSetTitle->execute();
         $sql_GetSetTitle->store_result();
         $sql_GetSetTitle->bind_result($SetTitle);
         $resultRows = $sql_GetSetTitle->num_rows();
         if ($resultRows > 0) {
            while ($sql_GetSetTitle->fetch()) {
               echo $SetTitle;
            }
         }
         ?>
      </h2>
      <div id="SetViewer-Container">
         <?php
         // Select and store all of the flashcards in the set
         $sql_GetCards = $conn->prepare("SELECT CardTitle, CardFront, CardBack FROM flashcardinfo WHERE CardSet = ?");
         $sql_GetCards->bind_param('i', $GetSetID);
         $sql_GetCards->execute();
         $sql_GetCards->store_result();
         $sql_GetCards->bind_result($CardTitle, $CardFront, $CardBack);
         $resultRows = $sql_GetCards->num_rows();
         if ($resultRows > 0) {
            while ($sql_GetCards->fetch()) {
               // Displaying all of the flashcards in the set
               echo "<div class='card unrotated' onclick='rotate(this)'><div class='content'><div class='front'><h3>" . $CardTitle . "</h3><p>" . $CardFront . "</p></div><div class='back'><p>" . $CardBack . "</p></div></div></div>";
            }
         }
         ?>
      </div>
      <div id="SetViewer-Information">
         <p><b>Click</b> on the card to flip it</p>
         <p>Use the <b>arrow keys</b> to navigate between cards</p>
      </div>
   </main>
</body>

</html>
<script src="JavaScript\RotateFlashcard.js"></script>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>
<script src="JavaScript\ChangeCard.js"></script>
<script>
   var maxCardPHP = <?php echo json_encode($resultRows); ?>;
   localStorage.setItem('maxCard', maxCardPHP.toString());
   localStorage.setItem('currentCard', '1')
   localStorage.setItem("moveLeft", "no");
   localStorage.setItem("moveRight", "yes");
</script>