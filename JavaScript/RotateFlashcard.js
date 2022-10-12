/* Creating functions to add or remove from class list */
function addRotate(card) {
   card.classList.remove("unrotated");
   card.classList.add("rotated");
}

function removeRotate(card) {
   card.classList.remove("rotated");
   card.classList.add("unrotated");
}

function rotate(clickedCard) {
   if (clickedCard.classList.contains("unrotated")) {
      addRotate(clickedCard);
   } else if (clickedCard.classList.contains("rotated")) {
      removeRotate(clickedCard);
   }
}
