let navbar = document.querySelector('.header .navbar');
let cart = document.querySelector('.cart-items-container');

document.querySelector('#cart-btn').onclick = () =>{
    cart.classList.add('active');
}

document.querySelector('#close-form').onclick = () =>{
    cart.classList.remove('active');
}

var swiper = new Swiper(".home-slider", {
    cnteredSlides:true,
});

let customizedSubmit = document.getElementById("custom-submit-btn");

customizedSubmit.addEventListener('click' , function () {
    alert("Customized cake order requested")
});

// function validateForm(event) {
//     event.preventDefault();
//     const username = document.getElementById("username").value;
//     const email = document.getElementById("email").value;
//     const password = document.getElementById("password").value;
//     const confirmPassword = document.getElementById("confirm-password").value;
//     const errorMessage = document.getElementById("error-message");

//     if (password !== confirmPassword) {
//         errorMessage.textContent = "Passwords do not match!";
//     } else {
//         errorMessage.textContent = "";
//     }
// }