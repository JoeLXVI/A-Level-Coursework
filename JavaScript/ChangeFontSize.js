let textSize = localStorage.getItem("textSize");
const increaseText = document.getElementById("increaseText");
const decreaseText = document.getElementById("decreaseText");
const sizesArray = ["normalFontSize", "largerFontSize", "largestFontSize"];

function increaseSize(currentSize) {
   console.log("increase");
   // Get the index of the current size and add one to it
   currentIndex = sizesArray.indexOf(currentSize);
   newSize = sizesArray[currentIndex + 1];
   // Modify the body class list so that the new size replaces the old size
   body.classList.replace(currentSize, newSize);
   // Store the new size in local storage
   localStorage.setItem("textSize", newSize);
}

function decreaseSize(currentSize) {
   console.log("decrease");
   // Get the index of the current size and subtract one from it
   currentIndex = sizesArray.indexOf(currentSize);
   newSize = sizesArray[currentIndex - 1];
   // Modify the body class list so that the new size replaces the old size
   body.classList.replace(currentSize, newSize);
   // Store the new size in local storage
   localStorage.setItem("textSize", newSize);
}

// Check if the last used font was not the normal size when the page is laoded and reloaded
if (textSize !== "normalFontSize") {
   // If the last used font size was not the normal size, replace it with the previously used size
   if (textSize === "largerFontSize") {
      body.classList.replace("normalFontSize", "largerFontSize");
   } else if (textSize === "largestFontSize") {
      body.classList.replace("normalFontSize", "largestFontSize");
   }
}

increaseText.addEventListener("click", () => {
   // Check if the font size is not already the largest and if it is not call the increase text size function
   textSize = localStorage.getItem("textSize");
   if (textSize === "largestFontSize") {
      return;
   }
   increaseSize(textSize);
});

decreaseText.addEventListener("click", () => {
   // Check if the font size is not already the normal font size and if it is not call the decrease text size function
   textSize = localStorage.getItem("textSize");
   if (textSize === "normalFontSize") {
      return;
   }
   decreaseSize(textSize);
});
