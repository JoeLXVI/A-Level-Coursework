function addRotate(card) {
   // Update the clicked card's class list to replace unrotated with rotated
   card.classList.remove("unrotated");
   card.classList.add("rotated");
}

function removeRotate(card) {
   // Update the clicked card's class list to replace rotated with unrotated
   card.classList.remove("rotated");
   card.classList.add("unrotated");
}

function rotate(clickedCard) {
   if (clickedCard.classList.contains("unrotated")) {
      // If the card is unrotated, add the rotated class to it
      addRotate(clickedCard);
   } else if (clickedCard.classList.contains("rotated")) {
      // If the card is unrotated, add the unrotated class to it
      removeRotate(clickedCard);
   }
}
