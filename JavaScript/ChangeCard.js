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
   return matrix.m41;
}

function moveCardLeft() {
   console.log("function left");
   currentCard = Number(localStorage.getItem("currentCard"));
   console.log(currentCard);
   if (currentCard > 1) {
      currentPos = getTranslateX();
      container.style.transform = "translateX(" + (currentPos + 1500) + "px)"; // Shift the container by the gap property and width of the card
      localStorage.setItem("moveRight", "yes");
      newCard = currentCard - 1;
      localStorage.setItem("currentCard", newCard.toString());
   } else if (currentCard == 1) {
      localStorage.setItem("moveLeft", "no");
   }
}

function moveCardRight() {
   console.log("function right");
   currentCard = Number(localStorage.getItem("currentCard"));
   maxCard = Number(localStorage.getItem("maxCard"));
   if (currentCard < maxCard) {
      currentPos = getTranslateX();
      container.style.transform = "translateX(" + (currentPos - 1500) + "px)";
      newCard = currentCard + 1;
      localStorage.setItem("moveLeft", "yes");
      localStorage.setItem("currentCard", newCard.toString());
   } else if (currentCard == maxCard) {
      localStorage.setItem("moveRight", "no");
   }
}

document.onkeydown = function (event) {
   moveRight = localStorage.getItem("moveRight");
   moveLeft = localStorage.getItem("moveLeft");
   if (locked) {
      return;
   }
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
