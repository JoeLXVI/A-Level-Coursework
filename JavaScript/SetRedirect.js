function redirect(SetID) {
   // Redirect the user to the page to view their selected set
   window.location.href = `viewFlashcard.php?sid=${SetID}`;
}
