let darkMode = localStorage.getItem("darkMode");
const themeToggle = document.getElementById("themeToggle");
const body = document.body;

function enableDarkMode() {
   body.classList.replace("lightTheme", "darkTheme");
   localStorage.setItem("darkMode", "enabled");
}

function enableLightMode() {
   body.classList.replace("darkTheme", "lightTheme");
   localStorage.setItem("darkMode", "disabed");
}

if (darkMode !== "enabled") {
   enableLightMode();
}

themeToggle.addEventListener("click", () => {
   darkMode = localStorage.getItem("darkMode");
   if (darkMode !== "enabled") {
      enableDarkMode();
   } else if (darkMode === "enabled") {
      enableLightMode();
   }
});
