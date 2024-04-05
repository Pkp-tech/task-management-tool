$(document).ready(function() {
    // Wait for the DOM to be fully loaded
console.log('heyyy');
    // Select the element to hide
    const $dashboardMessage = $('#dashboard-message');

    // Hide the element after 5 seconds (5000 milliseconds)
    setTimeout(function () {
        $dashboardMessage.hide(); // Using jQuery's hide() method to hide the element
    }, 5000); // 5000 milliseconds = 5 seconds
});
