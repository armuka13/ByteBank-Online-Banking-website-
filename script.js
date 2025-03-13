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



