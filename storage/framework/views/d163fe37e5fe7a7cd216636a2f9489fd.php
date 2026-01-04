<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    .hero-text {
        font-weight: 900;
        letter-spacing: -0.02em;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .discount-text {
        font-weight: 900;
        letter-spacing: -0.02em;
    }

    .nav-button {
        transition: all 0.2s ease;
    }

    .nav-button:hover {
        transform: translateY(-1px);
    }

    .cta-button {
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .hero-overlay {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.05));
    }

    /* Header always transparent - no background */
    header {
        background-color: transparent;
    }

    /* Search Modal Animations */
    #searchModal {
        transition: opacity 0.3s ease;
    }

    #searchModal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    #searchModal:not(.hidden) {
        opacity: 1;
        pointer-events: auto;
    }

    #searchModal .search-dropdown {
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        transform-origin: top center;
    }

    #searchModal.closing .search-dropdown {
        animation: slideUp 0.3s cubic-bezier(0.4, 0, 1, 1);
    }

    @keyframes slideDown {
        0% {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes slideUp {
        0% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        100% {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
    }

    /* Beautiful slider animations */
    .slide {
        animation: fadeOut 1s ease-in-out;
    }

    .slide.active {
        animation: fadeInZoom 1.5s ease-in-out;
    }

    @keyframes fadeInZoom {
        0% {
            opacity: 0;
            transform: scale(1.1);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
            transform: scale(1);
        }
        100% {
            opacity: 0;
            transform: scale(1.05);
        }
    }

    .slide img {
        transition: transform 5s ease-out;
    }

    .slide.active img {
        transform: scale(1.05);
    }
</style>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/partials/styles.blade.php ENDPATH**/ ?>