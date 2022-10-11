let textSize = localStorage.getItem("textSize");
const increaseText = document.getElementById("increaseText");
const decreaseText = document.getElementById("decreaseText");
const sizesArray = ["normalFontSize", "largerFontSize", "largestFontSize"];

function increaseSize(currentSize) {
   console.log("increase");
   currentIndex = sizesArray.indexOf(currentSize);
   newSize = sizesArray[currentIndex + 1];
   body.classList.replace(currentSize, newSize);
   localStorage.setItem("textSize", newSize);
}

function decreaseSize(currentSize) {
   console.log("decrease");
   currentIndex = sizesArray.indexOf(currentSize);
   newSize = sizesArray[currentIndex - 1];
   body.classList.replace(currentSize, newSize);
   localStorage.setItem("textSize", newSize);
}

if (textSize !== "normalFontSize") {
   if (textSize === "largerFontSize") {
      body.classList.replace("normalFontSize", "largerFontSize");
   } else if (textSize === "largestFontSize") {
      body.classList.replace("normalFontSize", "largestFontSize");
   }
}

increaseText.addEventListener("click", () => {
   textSize = localStorage.getItem("textSize");
   if (textSize === "largestFontSize") {
      return;
   }
   increaseSize(textSize);
});

decreaseText.addEventListener("click", () => {
   textSize = localStorage.getItem("textSize");
   if (textSize === "normalFontSize") {
      return;
   }
   decreaseSize(textSize);
});
