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
         <h1>invite a Student to a Class</h1>
         <hr>
      </div>
   </header>
   <main>
      <div id="TeachersClasses">
         <h2>Your Classes</h2>
         <ul>
            <li>Class 1</li>
            <li>Class 2</li>
            <li>Class 3</li>
            <li>Class 4</li>
            <li>Class 5</li>
            <!-- The List Items will be generated through php, using text from the database -->
         </ul>
      </div>
      <form action="" class="ClassCredentials">
         <label for="ClassName">Please enter the email address of the student</label>
         <input type="email" id="StudentEmail" name="StudentEmail" placeholder="example@email.com" required>
         <label for="ClassName">Which class would you like to add them to?</label>
         <input type="text" id="ClassName" name="ClassName" placeholder="Class Name" required>
         <button type="submit">Submit</button>
      </form>
      <!-- PHP to check that the student email and class name exist within the database, and then email the class code to the student -->
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>