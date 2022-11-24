let href = location.href;
let webNavBtns = document.querySelectorAll(".nav-btn");
webNavBtns.forEach((webNavBtn) => {
    if(href.includes(webNavBtn.getAttribute("href"))) {
        webNavBtn.style.color = "red";
    }
})

// carousel set
const carouselBtns = document.querySelectorAll("[data-carousel-button]"); //get the next and prev button
carouselBtns.forEach((carouselBtn) => {//for clicking the next or prev button
    carouselBtn.onclick = () => { // listen event for clicking the button
        const offset = carouselBtn.dataset.carouselButton === "next" ? 1 : -1; //to get the next img or prev img index
        const slides = carouselBtn.closest("[data-carousel]").querySelector("[data-slides]");// to get all images depending on the parent element
        const activeSlide = slides.querySelector("[data-active]"); //get the active slide (the shown img)
        let newIndex = [...slides.children].indexOf(activeSlide) + offset; //to get the next slide
        if(newIndex < 0) newIndex = slides.children.length - 1; // if the slides is 0
        if(newIndex >= slides.children.length) newIndex = 0;// if the slides is max length
        slides.children[newIndex].dataset.active = true; //add the active dataset for the slide to show
        delete activeSlide.dataset.active; // delete the active dataset 
    }
})
// carousel set

let input = document.querySelector(".add-rating-form .input-field input");
let label = document.querySelector(".add-rating-form .input-field label");
input.onfocus = () => {
    label.style.top = "-2rem";
    label.style.left = "0rem";
}
input.onblur = () => {
    if (!(input && input.value)) {
        label.style.top = "0px";
        label.style.left = "1rem";
    }
}