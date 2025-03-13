//Shikoje kete funksion per te shfaqur ose fshire navbarin
    function toggleNavbar() {
        if (window.innerWidth < 768) {
            document.getElementById("myNavbar").style.display = "none";
        } else {
            document.getElementById("myNavbar").style.display = "block";
        }
    }

    window.addEventListener("resize", toggleNavbar);
    toggleNavbar(); // Run on page load
