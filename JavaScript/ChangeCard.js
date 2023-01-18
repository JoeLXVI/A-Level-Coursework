const container = document.getElementById("SetViewer-Container");
let moveRight = localStorage.getItem("moveRight");
let moveLeft = localStorage.getItem("moveLeft");
let currentCard = localStorage.getItem("currentCard");
let maxCard = localStorage.getItem("maxCard");
let locked = false;

function getTranslateX() {
   // Find the current position of the container
   var style = window.getComputedStyle(container);
   var matrix = new WebKitCSSMatrix(style.transform);
   console.log(matrix.m41);
   // Return the current x value of the css transform property
   return matrix.m41;
}

function moveCardLeft() {
   console.log("function left");
   // Get the current card the user is on
   currentCard = Number(localStorage.getItem("currentCard"));
   console.log(currentCard);
   // Check if the current card isn't the first in the set
   if (currentCard > 1) {
      currentPos = getTranslateX();
      container.style.transform = "translateX(" + (currentPos + 1500) + "px)"; // Shift the container by the gap property and width of the card
      localStorage.setItem("moveRight", "yes");
      // Update the card number in local storage
      newCard = currentCard - 1;
      localStorage.setItem("currentCard", newCard.toString());
   } else if (currentCard == 1) {
      // If the current card is the first in the set the user can not move to the left
      localStorage.setItem("moveLeft", "no");
   }
}

function moveCardRight() {
   console.log("function right");
   // Get the current card the user is on
   currentCard = Number(localStorage.getItem("currentCard"));
   maxCard = Number(localStorage.getItem("maxCard"));
   // Check if the current card isn't the last in the set
   if (currentCard < maxCard) {
      currentPos = getTranslateX();
      container.style.transform = "translateX(" + (currentPos - 1500) + "px)"; // Shift the container by the gap property and width of the card
      localStorage.setItem("moveLeft", "yes");
      // Update the card number in local storage
      newCard = currentCard + 1;
      localStorage.setItem("currentCard", newCard.toString());
   } else if (currentCard == maxCard) {
      // If the current card is the last in the set the user can not move to the right
      localStorage.setItem("moveRight", "no");
   }
}

document.onkeydown = function (event) {
   moveRight = localStorage.getItem("moveRight");
   moveLeft = localStorage.getItem("moveLeft");
   if (locked) {
      // If the timeout on the functions is not over, ignore the key press
      return;
   }
   // Check which key has been pressed and call the function to move in that direction, as well as locking the functions
   if (event.key === "ArrowLeft") {
      console.log("arrowleft");
      if (moveLeft === "yes") {
         moveCardLeft();
         locked = true;
      }
   }
   if (event.key === "ArrowRight") {
      console.log("arrowright");
      if (moveRight === "yes") {
         moveCardRight();
         locked = true;
      }
   }
   setTimeout(function () {
      // Prevent the user from pressing keys during the animation of switching the card
      locked = false;
      console.log("timeout done");
   }, 2001);
};
