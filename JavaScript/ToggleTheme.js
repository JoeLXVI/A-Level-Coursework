let darkMode = localStorage.getItem("darkMode");
const themeToggle = document.getElementById("themeToggle");
const body = document.body;

function enableDarkMode() {
   // Edit the body's class list so that 'darkTheme' replaces 'lightTheme'
   body.classList.replace("lightTheme", "darkTheme");
   // Store dark mode as enabled in local storage
   localStorage.setItem("darkMode", "enabled");
}

function enableLightMode() {
   // Edit the body's class list so that 'lightTheme' replaces 'darkTheme'
   body.classList.replace("darkTheme", "lightTheme");
   // Store dark mode as disabled in local storage
   localStorage.setItem("darkMode", "disabed");
}

//Check if the previous theme used weas the light teme
if (darkMode !== "enabled") {
   // If light mode was the last used, enable it upon loading and reloading
   enableLightMode();
}

themeToggle.addEventListener("click", () => {
   // Check if dark mode is stored as enabled in local storage
   darkMode = localStorage.getItem("darkMode");
   if (darkMode !== "enabled") {
      // If it is disabled, enable it
      enableDarkMode();
   } else if (darkMode === "enabled") {
      // If it is enabled, disable it
      enableLightMode();
   }
});
