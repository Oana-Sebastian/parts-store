let currentSlide = 0;
const slides = document.querySelectorAll('#heroCarousel .carousel-slide');
const indicators = document.querySelectorAll('.carousel-indicators .carousel-indicator');

function showSlide(n) {
    if (n >= slides.length) currentSlide = 0;
    if (n < 0) currentSlide = slides.length - 1;

    const offset = -currentSlide * 100;
    document.getElementById('heroCarousel').style.transform = `translateX(${offset}%)`;

    indicators.forEach((ind, i) => {
        ind.classList.toggle('active', i === currentSlide);
    });
}

function moveCarousel(direction) {
    currentSlide += direction;
    showSlide(currentSlide);
}

function goToSlide(n) {
    currentSlide = n;
    showSlide(currentSlide);
}

setInterval(() => {
    currentSlide++;
    showSlide(currentSlide);
}, 5000);

function changeMiniCarousel(partId, index) {
    const container = document.querySelector(`[data-part-id="${partId}"]`);
    const images = container.querySelectorAll('.carousel-image');
    const dots = container.querySelectorAll('.mini-carousel-dot');

    images.forEach((img, i) => {
        img.style.display = i === index ? 'block' : 'none';
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}