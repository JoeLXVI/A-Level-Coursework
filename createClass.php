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
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Select a Set</a></li>
            <li><a href="createFlashcard.php?uid=<?php echo $GetUserID ?>">Create a Card</a></li>
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
                     echo "<li class='active'><a href='createClass.php?uid=" . $GetUserID . "'>Create a Class</a></li>";
                     echo "<li><a href='inviteStudent.php?uid=" . $GetUserID . "'>Invite Student to a Class</a></li>";
                  }
               }
            }
            ?>
            <!-- Seperating the navigation buttons that will be pushed to the right hand side of the page -->
            <div class="shiftRight">
               <li id="increaseText"><a href="#">Increase Font Size</a></li>
               <li id="decreaseText"><a href="#">Decrease Font Size</a></li>
               <li id="themeToggle"><a href="#">Toggle Theme</a></li>
            </div>
         </ul>
      </nav>
      <div class="title">
         <h1>Create a Class</h1>
         <hr>
      </div>
   </header>
   <main>
      <!-- Form for teachers to create a class -->
      <form action="" class="ClassCredentials" method="POST">
         <label for="ClassName">What would you like to call the class?</label>
         <input type="text" id="ClassName" name="ClassName" placeholder="Class Name" required>
         <label for="ClassSubject">What subject is the class for?</label>
         <input type="text" id="ClassSubject" name="ClassSubject" placeholder="Subject" required>
         <button type="submit" name="SubmitForm">Submit</button>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         if ($UserType === 2) {
            $GetClassName = $_POST['ClassName'];
            $GetClassSubject = $_POST['ClassSubject'];
            // Generate a 7 character class code
            $CreateClassCode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7);
            // This try catch block acts to catch any duplicate class codes that are generated
            // It handles this error by generating a new class code when there is a duplicate error
            try {
               $sql_CreateClass = $conn->prepare("INSERT INTO classinfo (ClassTeacher, ClassName, ClassSubject, ClassCode) VALUES (?, ?, ?, ?)");
               $sql_CreateClass->bind_param('isss', $GetUserID, $GetClassName, $GetClassSubject, $CreateClassCode);
               if ($sql_CreateClass->execute() !== TRUE) {
                  if (strpos($sql_CreateClass->error, 'Duplicate error')) {
                     throw new Exception('Duplicate class code');
                  }
               }
            } catch (Exception $e) {
               $CreateNewClassCode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 7);
               if ($CreateClassCode !== $CreateNewClassCode) {
               }
               $TestClassCode = "1234567";
               $sql_CreateClass = $conn->prepare("INSERT INTO classinfo (ClassTeacher, ClassName, ClassSubject, ClassCode) VALUES (?, ?, ?, ?)");
               $sql_CreateClass->bind_param('isss', $GetUserID, $GetClassName, $GetClassSubject, $CreateNewClassCode);
               if ($sql_CreateClass->execute() !== TRUE) {
                  echo "Error: " . $sql_CreateClass->error . "<br>" . $conn->error;
               }
            }
         }
      }
      ?>
   </main>
</body>

</html>
<script src="JavaScript\ChangeFontSize.js"></script>
<script src="JavaScript\ToggleTheme.js"></script>