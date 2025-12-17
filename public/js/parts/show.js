let currentDetailSlide = 0;
const detailSlides = document.querySelectorAll('#partCarousel .carousel-slide');
const detailIndicators = document.querySelectorAll('#partCarousel ~ .carousel-indicators .carousel-indicator');

function showDetailSlide(n) {
    if (n >= detailSlides.length) currentDetailSlide = 0;
    if (n < 0) currentDetailSlide = detailSlides.length - 1;

    const offset = -currentDetailSlide * 100;
    document.getElementById('partCarousel').style.transform = `translateX(${offset}%)`;

    detailIndicators.forEach((ind, i) => {
        ind.classList.toggle('active', i === currentDetailSlide);
    });
}

function moveDetailCarousel(direction) {
    currentDetailSlide += direction;
    showDetailSlide(currentDetailSlide);
}

function goToDetailSlide(n) {
    currentDetailSlide = n;
    showDetailSlide(currentDetailSlide);
}


function increaseQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}