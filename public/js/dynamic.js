let indiceSlide = 0;
mostraSlide(indiceSlide);

function prossimaSlide(n) {
mostraSlide(indiceSlide += n);
}

function currentSlide(n) {
mostraSlide(indiceSlide = n);
}

function mostraSlide(n) {
let i;
let slides = document.querySelectorAll("#primoContenuto img");
console.log(slides)
let dots = document.querySelectorAll(".puntiniCarosello button");

if (n > slides.length) {indiceSlide = 1}    
if (n < 1) {indiceSlide = slides.length}
for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
}
for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace("active", "");
}
slides[indiceSlide-1].style.display = "block";  
dots[indiceSlide-1].className += "active";
}