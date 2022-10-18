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
            <li class="active"><a href="createFlashcard.php">Create a Card</a></li>
            <div class="shiftRight">
               <li><a href="signIn.php">Sign In </a></li>
               <li id="increaseText"><a href="#">Increase Font Size</a></li>
               <li id="decreaseText"><a href="#">Decrease Font Size</a></li>
               <li id="themeToggle"><a href="#">Toggle Theme</a></li>
            </div>
         </ul>
      </nav>
      <div class="title">
         <h1>Create a Flashcard</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" method="post" class="CreateFlashcard">
         <div id="CreateFlashcard-FlashcardTitle">
            <label for="FlashcardTitle">Enter the flashcard title</label>
            <input type="text" name="FlashcardTitle" id="FlashcardTitle" placeholder="Flashcard Title" required>
         </div>
         <div id="CreateFlashcard-FlashcardFront">
            <label for="FlashcardFront">Enter the flashcard title</label>
            <textarea name="FlashcardFront" id="FlashcardFront" placeholder="Flashcard Front" required></textarea>
         </div>
         <div id="CreateFlashcard-FlashcardBack">
            <label for="FlashcardBack">Enter the flashcard title</label>
            <textarea name="FlashcardBack" id="FlashcardBack" placeholder="Flashcard back" required></textarea>
         </div>
         <div id="CreateFlashcard-NewSet">
            <label for="NewSet">Would you like to create a new set?</label>
            <input type="checkbox" name="NewSet" id="NewSet" onclick="checkboxClicked()" value="yes">
         </div>
         <div id="CreateFlashcard-SetNumber">
            <label for="SetNumber">What number set would you like to add the flashcard to?</label>
            <input type="number" name="SetNumber" id="SetNumber" placeholder="Set Number" required>
         </div>
         <div id="CreateFlashcard-SetTitle">
            <label for="SetTitle">What would you like to call the new set?</label>
            <input type="text" name="SetTitle" id="SetTitle" placeholder="Set Name" required>
         </div>
         <button type="submit">Submit</button>
      </form>
   </main>
</body>

</html>
<script src="JavaScript\CheckBoxClicked.js"></script>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>