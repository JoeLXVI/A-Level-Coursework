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
         <h1>Join a Class</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" class="ClassCredentials">
         <label for="ClassCode">Enter the class code</label>
         <input type="text" name="ClassCode" id="ClassCode" required placeholder="Class Code"> <!-- This will be provided to the student by email -->
         <button type="submit">Submit</button>
      </form>
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>