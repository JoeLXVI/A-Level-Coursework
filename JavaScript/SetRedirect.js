function redirect(SetID, UserID, UserType) {
   // Redirect the user to the page to view their selected set
   window.location.href = `viewFlashcard.php?sid=${SetID}&uid=${UserID}&aty=${UserType}`;
}
