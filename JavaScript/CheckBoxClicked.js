function checkboxClicked() {
   var checkbox = document.getElementById("NewSet");
   var setNumber = document.getElementById("CreateFlashcard-CardSet");
   var setTitle = document.getElementById("CreateFlashcard-SetTitle");
   var setClass = document.getElementById("CreateFlashcard-TeacherClasses");

   if (checkbox.checked === true) {
      setNumber.style.display = "none";
      setNumber.style.gridRow = "3";
      setTitle.style.display = "block";
      setTitle.style.gridRow = "2";
      setClass.style.display = "block";
   } else {
      setNumber.style.display = "block";
      setNumber.style.gridRow = "2";
      setTitle.style.display = "none";
      setTitle.style.gridRow = "3";
      setClass.style.display = "none";
   }
}
