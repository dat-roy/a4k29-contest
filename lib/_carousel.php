<div class="carousel">
    <div class="slides">
        <img src="./assets/img/1.jpg" alt="slide image" class="slide">
        <img src="./assets/img/2.jpg" alt="slide image" class="slide">
        <img src="./assets/img/3.jpg" alt="slide image" class="slide">
    </div>
    <div class="controls">
        <div class="control prev-slide">&#9668;</div>
        <div class="control next-slide">&#9658;</div>
    </div>
</div>
<script>
	const delay = 3000; //ms

const slides = document.querySelector(".slides");
const slidesCount = slides.childElementCount;
const maxLeft = (slidesCount - 1) * 100 * -1;

let current = 0;

function changeSlide(next = true) {
  if (next) {
    current += current > maxLeft ? -100 : current * -1;
  } else {
    current = current < 0 ? current + 100 : maxLeft;
  }

  slides.style.left = current + "%";
}

// Controls
document.querySelector(".next-slide").addEventListener("click", function () {
  changeSlide();
});

document.querySelector(".prev-slide").addEventListener("click", function () {
  changeSlide(false);
  restart();
});

</script>