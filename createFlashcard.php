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
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Home</a></li>
            <li class="active"><a href="createFlashcard.php?uid=<?php echo $GetUserID ?>">Create a Card</a></li>
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
         <!-- Form allowing the user to enter all relevant information to the creation of a new flashcard -->
         <!-- Divs are being used to wrap the label and input into effectively 'one element', 
         which allows for the grid layout to be better utilised -->
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
            <input type="hidden" name="NewSet" value="no" />
            <input type="checkbox" name="NewSet" id="NewSet" onclick="checkboxClicked()" value="yes">
         </div>
         <div id="CreateFlashcard-SetNumber">
            <label for="SetNumber">What number set would you like to add the flashcard to?</label>
            <input type="number" name="SetNumber" id="SetNumber" placeholder="Set Number">
         </div>
         <div id="CreateFlashcard-SetTitle">
            <label for="SetTitle">What would you like to call the new set?</label>
            <input type="text" name="SetTitle" id="SetTitle" placeholder="Set Name">
         </div>
         <button type="submit" name="SubmitForm">Submit</button>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetFlashcardTitle = $_POST['FlashcardTitle'];
         if (strpos($GetFlashcardTitle, "'")) { // Checking if the string contains an apostrophe
            $pos = strpos($GetFlashcardTitle, "'");
            $GetFlashcardTitle = substr_replace($GetFlashcardTitle, "'", $pos, 0); // Adding a second apostrophe in order to prevent strings being broken in the query
         }
         $GetFlashcardFront = $_POST['FlashcardFront'];
         if (strpos($GetFlashcardFront, "'")) {
            $pos = strpos($GetFlashcardFront, "'");
            $GetFlashcardFront = substr_replace($GetFlashcardFront, "'", $pos, 0);
         }
         $GetFlashcardBack = $_POST['FlashcardBack'];
         if (strpos($GetFlashcardBack, "'")) {
            $pos = strpos($GetFlashcardBack, "'");
            $GetFlashcardBack = substr_replace($GetFlashcardBack, "'", $pos, 0);
         }
         if ($_POST['NewSet'] == "yes") { // Check if the user is adding to a new set
            //Create the new set
            $GetSetTitle = $_POST['SetTitle'];
            if (strpos($GetSetTitle, "'")) { // Checking if the string contains an apostrophe
               $pos = strpos($GetSetTitle, "'");
               $GetSetTitle = substr_replace($GetSetTitle, "'", $pos, 0); // Adding a second apostrophe in order to prevent strings being broken in the query
            }
            $sql_createSet = $conn->prepare("INSERT INTO sets (OwnerID, SetTitle) VALUES (?, ?)");
            // Preparing the statement, to prevent SQL injection attacks
            $sql_createSet->bind_param('is', $GetSetID, $GetSetTitle);
            // Adding the parameters of the INSERT statement
            if ($sql_createSet->execute() !== TRUE) {
               echo "Error: " . $sql_createSet . "<br>" . $conn->error;
            } else { // If the set was successfully created create the card
               $sql_getSetID = "SELECT * FROM sets WHERE SetTitle = '$GetSetTitle' AND OwnerID = $GetUserID";
               $result = mysqli_query($conn, $sql_getSetID);
               $resultRows = mysqli_num_rows($result);
               if ($resultRows > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                     $SetID = $row['SetID'];
                     $sql_createCard = $conn->prepare("INSERT INTO flashcardinfo (CardSet, CardTitle, CardFront, CardBack) VALUES (?, ?, ?, ?)");
                     // Preparing the statement, to prevent SQL injection attacks
                     $sql_createCard->bind_param('isss', $SetID, $GetFlashcardTitle, $GetFlashcardFront, $GetFlashcardBack);
                     // Adding the parameters of the INSERT statement
                     $sql_createCard->execute();
                  }
               }
            }
         } else { // Create the card and add it to the user defined set
            $GetSetID = $_POST['SetNumber'];
            $sql_createCard = $conn->prepare("INSERT INTO flashcardinfo (CardSet, CardTitle, CardFront, CardBack) VALUES (?, ?, ?, ?)");
            // Preparing the statement, to prevent SQL injection attacks
            $sql_createCard->bind_param('isss', $GetSetID, $GetFlashcardTitle, $GetFlashcardFront, $GetFlashcardBack);
            // Adding the parameters of the INSERT statement
            $sql_createCard->execute();
         }
      }
      ?>
   </main>
</body>

</html>
<script src="JavaScript\CheckBoxClicked.js"></script>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>