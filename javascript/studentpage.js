// Function to toggle the visibility of a popup
function togglePopup() {
    
    // Get the popup element by its ID
    const popupElement = document.getElementById("popup-1");

    // Toggle the 'active' class on the popup element
    // The 'active' class is used to control the visibility of the popup through CSS
    popupElement.classList.toggle("active");
}
