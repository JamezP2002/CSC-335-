document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".carousel");
    const images = document.querySelectorAll(".carousel img");
    let currentIndex = 0;

    function showNextImage() {
        // Move to the next image
        currentIndex = (currentIndex + 1) % images.length; // Loop back to the start if at the end
        const offset = -currentIndex * 100; // Calculate offset for transform
        carousel.style.transform = `translateX(${offset}%)`;
    }

    // Rotate images every 3 seconds
    setInterval(showNextImage, 3000);
});
