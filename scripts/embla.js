// all code copied from 
https://codesandbox.io/s/embla-carousel-default-vanilla-gqh0n?file=/src/js/index.js:0-748
// from the basic embla page - https://www.embla-carousel.com/examples/basic/

var wrap = document.querySelector(".embla");
var viewPort = wrap.querySelector(".embla__viewport");
var prevBtn = wrap.querySelector(".embla__button--prev");
var nextBtn = wrap.querySelector(".embla__button--next");
var embla = EmblaCarousel(viewPort, { loop: true });

var disablePrevNextBtns = (prevBtn, nextBtn, embla) => {
    return () => {
        if (embla.canScrollPrev()) prevBtn.removeAttribute('disabled');
        else prevBtn.setAttribute('disabled', 'disabled');

        if (embla.canScrollNext()) nextBtn.removeAttribute('disabled');
        else nextBtn.setAttribute('disabled', 'disabled');
    };
};

var setupPrevNextBtns = (prevBtn, nextBtn, embla) => {
    prevBtn.addEventListener('click', embla.scrollPrev, false);
    nextBtn.addEventListener('click', embla.scrollNext, false);
};

var disablePrevAndNextBtns = disablePrevNextBtns(prevBtn, nextBtn, embla);
setupPrevNextBtns(prevBtn, nextBtn, embla);

embla.on("select", disablePrevAndNextBtns);
embla.on("init", disablePrevAndNextBtns);

