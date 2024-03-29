<?php
include 'conn.php';
$GetUserID = $_GET['uid']; // Using the GET method to retrieve form the URL
$UserType = $_GET['aty'];
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
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>&aty=<?php echo $UserType ?>">Select a Set</a></li>
            <li class="active"><a href="createFlashcard.php?uid=<?php echo $GetUserID ?>&aty=<?php echo $UserType ?>">Create a Card</a></li>
            <?php
            // PHP to give teachers access to the pages relating to the creation of classes as well as inviting students to classes
            if ($UserType >= 2) {
               echo "<li><a href='createClass.php?uid=" . $GetUserID . "&aty=" . $UserType . "'>Create a Class</a></li>";
               echo "<li><a href='inviteStudent.php?uid=" . $GetUserID . "&aty=" . $UserType . "'>Invite Student to a Class</a></li>";
            } else {
               echo "<li><a href='joinClass.php?uid=" . $GetUserID . "&aty=" . $UserType . "'>Join a Class</a></li>";
            }
            ?>
            <div class="shiftRight">
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
            <label for="FlashcardFront">Enter the flashcard front text</label>
            <textarea name="FlashcardFront" id="FlashcardFront" placeholder="Flashcard Front" required></textarea>
         </div>
         <div id="CreateFlashcard-FlashcardBack">
            <label for="FlashcardBack">Enter the flashcard back text</label>
            <textarea name="FlashcardBack" id="FlashcardBack" placeholder="Flashcard back" required></textarea>
         </div>
         <div id="CreateFlashcard-NewSet">
            <label for="NewSet">Would you like to create a new set?</label>
            <input type="hidden" name="NewSet" value="no" />
            <input type="checkbox" name="NewSet" id="NewSet" onclick="checkboxClicked()" value="yes">
         </div>
         <div id="CreateFlashcard-CardSet">
            <label for="CardSet">Which set would you like to add the card to?</label>
            <br>
            <!-- Creating a select input so that users cannot input the name of a set that does not exist in the database -->
            <select name="CardSet" id="CardSet">
               <?php
               // Get and store all of the users sets
               $sql = $conn->prepare("SELECT SetID, SetTitle FROM sets WHERE OwnerID = ?");
               $sql->bind_param('i', $GetUserID);
               $sql->execute();
               $sql->store_result();
               $sql->bind_result($SetID, $SetTitle);
               $resultRows = $sql->num_rows();
               if ($resultRows > 0) {
                  while ($sql->fetch()) { // Fetch the results of the query
                     // Put the user's sets as options in the '<select>' element
                     echo "<option value='" . $SetID . "'>" . $SetTitle . "</option>";
                  }
               }
               ?>
            </select>
         </div>
         <div id="CreateFlashcard-SetTitle">
            <label for="SetTitle">What would you like to call the new set?</label>
            <input type="text" name="SetTitle" id="SetTitle" placeholder="Set Name">
         </div>
         <div id="CreateFlashcard-TeacherClasses">
            <?php
            // PHP to allow teachers to see their classes by creating a select element, containing their classes as the options
            // This element is only show if the account type logged in is a teacher or admin
            if ($UserType >= 2) {
               echo "<label for='SetClass'>What class would you like to add the set to?</label><select name='SetClass' id='SetClass'><option value=''>----</option>";
               // Get and store all of the teachers classes
               $sql = $conn->prepare("SELECT ClassID, ClassName FROM classinfo WHERE ClassTeacher = ?");
               $sql->bind_param('i', $GetUserID);
               $sql->execute();
               $sql->store_result();
               $sql->bind_result($ClassCard, $ClassName);
               $resultRows = $sql->num_rows();
               if ($resultRows > 0) {
                  while ($sql->fetch()) { // Fetch the results of the query
                     // Put the user's classes as options in the '<select>' element
                     echo "<option value='" . $ClassCard . "'>" . $ClassName . "</option>";
                  }
               }
            }
            echo "</select>";
            ?>
         </div>
         <button type="submit" name="SubmitForm">Submit</button>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetFlashcardTitle = $_POST['FlashcardTitle'];
         $GetFlashcardFront = $_POST['FlashcardFront'];
         $GetFlashcardBack = $_POST['FlashcardBack'];
         if ($_POST['NewSet'] == "yes") { // Check if the user is adding to a new set
            //Create the new set
            $GetSetTitle = $_POST['SetTitle']; #
            $sql_createSet = $conn->prepare("INSERT INTO sets (OwnerID, SetTitle) VALUES (?, ?)");
            // Preparing the statement, to prevent SQL injection attacks
            $sql_createSet->bind_param('is', $GetUserID, $GetSetTitle);
            // Adding the parameters of the INSERT statement
            if ($sql_createSet->execute() !== TRUE) {
               echo "Error: " . $sql_createSet->error . "<br>" . $conn->error;
            } else { // If the set was successfully created create the card
               $sql_getSetID = $conn->prepare("SELECT SetID FROM sets WHERE SetTitle = ? AND OwnerID = ?");
               $sql_getSetID->bind_param('si', $GetSetTitle, $GetUserID);
               $sql_getSetID->execute();
               $sql_getSetID->store_result();
               $sql_getSetID->bind_result($SetID);
               $resultRows = $sql_getSetID->num_rows();
               if ($resultRows > 0) {
                  while ($sql_getSetID->fetch()) {
                     $sql_createCard = $conn->prepare("INSERT INTO flashcardinfo (CardSet, CardTitle, CardFront, CardBack) VALUES (?, ?, ?, ?)");
                     // Preparing the statement, to prevent SQL injection attacks
                     $sql_createCard->bind_param('isss', $SetID, $GetFlashcardTitle, $GetFlashcardFront, $GetFlashcardBack);
                     // Adding the parameters of the INSERT statement
                     $sql_createCard->execute();
                     // Add the set to the class if one is selected
                     if ($UserType >= 2) {
                        if ($_POST['SetClass'] !== "----") {
                           $ClassID = $_POST['SetClass'];
                           $sql_AddSetToClass = $conn->prepare("INSERT INTO classsets (ClassID, SetID) VALUES (?, ?)");
                           $sql_AddSetToClass->bind_param('ii', $ClassID, $SetID);
                           $sql_AddSetToClass->execute();
                        }
                     }
                  }
               }
            }
         } else { // Create the card and add it to the user defined set
            $GetSetID = $_POST['CardSet'];
            $sql_createCard = $conn->prepare("INSERT INTO flashcardinfo (CardSet, CardTitle, CardFront, CardBack) VALUES (?, ?, ?, ?)");
            // Preparing the statement, to prevent SQL injection attacks
            $sql_createCard->bind_param('isss', $GetSetID, $GetFlashcardTitle, $GetFlashcardFront, $GetFlashcardBack);
            // Adding the parameters of the INSERT statement
            $sql_createCard->execute();
         }
         // Refresh the page after everything else has been executed, in order to allow the options to be added if a new set is created
         $URL = "createFlashcard.php?uid=$GetUserID";
         echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
      }
      ?>
   </main>
</body>

</html>
<script src="JavaScript\CheckBoxClicked.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>
<script src="JavaScript\ChangeFontSize.js"></script>