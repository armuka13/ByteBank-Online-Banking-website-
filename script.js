// //Shikoje kete funksion per te shfaqur ose fshire navbarin
//     function toggleNavbar() {
//         if (window.innerWidth < 768) {
//             document.getElementById("myNavbar").style.display = "none";
//         } else {
//             document.getElementById("myNavbar").style.display = "block";
//         }
//     }

//     window.addEventListener("resize", toggleNavbar);
//     toggleNavbar(); // Run on page load

    //gets from the main page Sign Up which reads register and Log In which reads login

    var formType = new URLSearchParams(window.location.search).get('formType');

    //Checks if it is register of login
    if (formType === 'register') {
        $("#signInForm").hide();
        $("#registerForm").show();
    } else if (formType === 'login') {
        $("#registerForm").hide();
        $("#signInForm").show();
    }

//When clicking on Sign In or Register it will hide the other form
$("#signInTxt").click(function() {
    $("#registerForm").hide();
    $("#signInForm").show();
})

$("#registerTxt").click(function() {
    $("#signInForm").hide();
    $("#registerForm").show();
})

$(document).ready(function () {
    $("#faq").hide(); // Hide all FAQ sections initially

    $("#searchBar").on("keyup", function () {
        let searchText = $(this).val().toLowerCase();

        if (searchText.length > 0) {
            $("#faq").show(); // Show FAQ sections
            $("#mainContent").hide(); // Hide the main content

            // Search through FAQ questions and their associated text
            $("#faq > div").each(function () {
                let questionText = $(this).find("h3").text().toLowerCase();
                let additionalText = $(this).find("p").text().toLowerCase(); // Include text below the question

                if (questionText.includes(searchText) || additionalText.includes(searchText)) {
                    $(this).show(); // Show matching FAQs
                } else {
                    $(this).hide(); // Hide non-matching FAQs
                }
            });

            // Search through all other content except the header and FAQ
            $("body *").not("header, header *, #faq, #faq *").each(function () {
                let elementText = $(this).text().toLowerCase();

                if (elementText.includes(searchText)) {
                    $(this).show(); // Show matching elements
                } else {
                    $(this).hide(); // Hide non-matching elements
                }
            });
        } else {
            $("#mainContent").show(); // Show the main content when input is empty
            $("#faq").hide(); // Hide all FAQs
            $("body *").not("header, header *").show(); // Show all elements except the header
        }
    });
});

$(document).ready(function() {

        // Show the alarm immediately with a fade-in effect
        $("#error-alert").fadeIn();

        // Set a timer to hide the alarm after 5 seconds (5000 ms)
        setTimeout(function() {
            $("#error-alert").fadeOut();  // Hide the alarm with a fade-out effect
        }, 5000);  // Hide after 5 seconds
});


function showSideBar(){
    const sidebar = document.querySelector('.sideBar');
    sidebar.style.display = 'flex';
}


