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


$(document).ready(function() {

    $("#faq").hide();// Hide all FAQ sections initially
    $("#searchBar").on("keyup", function() {
        let searchText = $(this).val().toLowerCase();

        if (searchText.length > 0) {
            $("#faq").show();// show FAQ sections 
            $("#mainContent").hide(); // Hide all other elements
            $("#faq > div").each(function() {
                let questionText = $(this).find("h3").text().toLowerCase();

                if (questionText.includes(searchText)) {
                    $(this).show(); // Show matching FAQs
                } else {
                    $(this).hide(); // Hide non-matching FAQs
                }
            });
        } else {
            $("#mainContent").show(); // Show everything back when input is empty
            $("#faq").hide(); // hide all FAQs
        }
    });
});


// $(document).ready(function () {
//     // Search function
//     $('#searchBar').on('input', function () {
//         var searchQuery = $(this).val().toLowerCase(); // Get the value from the search bar and make it lowercase

//         // Loop through all navbar items and filter based on the search query
//         $('#navItems .nav-item').each(function () {
//             var itemText = $(this).text().toLowerCase(); // Get the text of the current item and make it lowercase

//             if (itemText.indexOf(searchQuery) > -1) {
//                 $(this).show(); // Show the item if it matches the search query
//             } else {
//                 $(this).hide(); // Hide the item if it doesn't match
//             }
//         });
//     });
// });



