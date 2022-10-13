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
   <main>
      <h2>Set Title</h2> <!-- The text of this element will be taken from the database, via php -->
      <div id="SetViewer-Container">
         <!-- The following will be replaced with php that will create the same HTML, but with text loaded from the database -->
         <div class="card unrotated" onclick="rotate(this)">
            <div class="content">
               <div class="front">
                  <h3>Example Card</h3>
                  <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Porro, nihil?</p>
               </div>
               <div class="back">
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque exercitationem architecto reiciendis error iste placeat qui. Blanditiis quod aperiam cum!</p>
               </div>
            </div>
         </div>
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