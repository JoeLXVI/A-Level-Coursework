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
            <!-- The anchor elements containing php in the href allow for the user to be redirected with their ID in the URl
            This means that the user is recognised throughout the entire website and can see the sets linked to them -->
            <li><a href="selectSet.php?uid=<?php echo $GetUserID ?>">Select a Set</a></li>
            <li><a href="createFlashcard.php?uid=<?php echo $GetUserID ?>">Create a Card</a></li>
            <li class="active"><a href='joinClass.php?uid=<?php echo $GetUserID ?>'>Join a Class</a></li>
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
      <!-- Form to allow users to join a class -->
      <form action="" class="ClassCredentials" method="POST">
         <label for="ClassCode">Enter the class code</label>
         <input type="text" name="ClassCode" id="ClassCode" required placeholder="Class Code"> <!-- This will be provided to the student by email -->
         <button type="submit" name="SubmitForm">Submit</button>
      </form>
      <?php
      if (isset($_POST['SubmitForm'])) { // Check if the form has been submitted
         // Retrieve the user inputs
         $GetClassCode = $_POST['ClassCode'];
         // SQL to get the class ID if the code entered
         $sql_GetClassInfo = $conn->prepare("SELECT ClassID, ClassName FROM classinfo WHERE ClassCode = ?");
         $sql_GetClassInfo->bind_param('s', $GetClassCode);
         $sql_GetClassInfo->execute();
         $sql_GetClassInfo->store_result();
         $sql_GetClassInfo->bind_result($ClassID, $GetClassName);
         $resultRows = $sql_GetClassInfo->num_rows();
         if ($resultRows > 0) {
            while ($sql_GetClassInfo->fetch()) { // Fetch the results of the query
               $sql_AddStudentToClass = $conn->prepare("INSERT INTO ClassStudents (ClassID, StudentID) VALUES (?, ?)");
               $sql_AddStudentToClass->bind_param('ii', $ClassID, $GetUserID);
               if ($sql_AddStudentToClass->execute() !== TRUE) {
                  echo "Error: " . $sql_AddStudentToClass->error . "<br>" . $conn->error;
               } else {
                  echo "<script type='text/javascript'>alert('You have successfully joined: " . $GetClassName . "');</script>";
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