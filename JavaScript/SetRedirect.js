function redirect(SetID, UserID) {
   // Redirect the user to the page to view their selected set
   window.location.href = `viewFlashcard.php?sid=${SetID}&uid=${UserID}`;
}
