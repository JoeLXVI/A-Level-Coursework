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
         <div class="SelectSet-Box">
            <p>Set 1</p>
         </div>
         <div class="SelectSet-Box">
            <p>Set 2</p>
         </div>
         <div class="SelectSet-Box">
            <p>Set 3</p>
         </div>
         <div class="SelectSet-Box">
            <p>Set 4</p>
         </div>
         <div class="SelectSet-Box">
            <p>Set 5</p>
         </div>
         <div class="SelectSet-Box">
            <p>Set 6</p>
         </div>
         <div class="SelectSet-Box">
            <p>Set 7</p>
         </div>
      </div>
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>