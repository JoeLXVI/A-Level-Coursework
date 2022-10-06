<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>NEA Flashcard Website</title>
   <link rel="stylesheet" href="CSS\styles.css">
</head>

<body class="darkTheme largerFontSize">
   <header>
      <nav>
         <ul>
            <li><a href="">Home</a></li>
            <div class="shiftRight">
               <li class="active"><a href="signUp.php">Sign In</a></li>
               <li id="increaseText"><a href="#">Increase Font Size</a></li>
               <li id="decreaseText"><a href="#">Decrease Font Size</a></li>
               <li id="themeToggle"><a href="#">Toggle Theme</a></li>
            </div>
         </ul>
      </nav>
      <div class="title">
         <h1>Sign Up</h1>
         <hr>
      </div>
   </header>
   <main>
      <form action="" class="UserCredentials">
         <label for="UserName">Enter your name</label>
         <input type="text" name="UserName" placeholder="Name" required>
         <label for="UserEmail">Enter your email address</label>
         <input type="email" name="UserEmail" placeholder="example@email.com" required>
         <label for="UserPassword">Enter your password</label>
         <input type="password" name="UserPassword" placeholder="Password" required>
         <label for="userConfirmPassword">Confirm your password</label>
         <input type="password" name="UserConfirmPassword" placeholder="Retype Password" required>
         <button type="submit">Sign Up</button>
      </form>
   </main>
</body>

</html>