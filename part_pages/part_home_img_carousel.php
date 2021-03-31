<!-- home page image carousel! -->
<div class="embla" id="embla">
    <div class="embla__viewport">
        <div class="embla__container">
        <?php
            // each successive image is in an array of with the link and caption
            $image1 = array("https://i.imgur.com/3r7byMX.png", "Rashford Strikes Again in the game vs. Newcastle United.");
            $image2 = array("https://i.imgur.com/UxBGyCb.png", "Gylfi Sigurdsson has a great track record vs. Liverpool.");
            $image3 = array("https://i.imgur.com/SGBcnXU.png", "James Maddison has scored from outside the area more than any other player this season");
            $image4 = array("https://i.imgur.com/97BtQXN.png", "West Ham had a shock result against Tottenham, beating them 2-1");
            $image5 = array("https://i.imgur.com/Ok815ec.jpg", "Manchester United and Liverpool were once neck and neck in this seasons title race");
            $carouselMainArray = array($image1, $image2, $image3, $image4, $image5);
            
            // loop through and print each image and caption
            foreach ($carouselMainArray as $slide) {
                $link = $slide[0];
                $caption = $slide[1];
                echo "
                    <div class='my_image_maintain_aspect embla__slide'>
                        <figure>
                            <img src='{$link}' alt='{$caption}' class='box embla__slide__img'>
                            <caption class='subtitle is-6 is-size-7-mobile'>{$caption}</caption>
                        </figure>
                    </div>";
            }
                    
        ?>
        </div>
    </div>

    <!-- embla prev and next Buttons -->
    <button class="embla__button embla__button--prev" type="button">
        <svg
          class="embla__button__svg"
          viewBox="137.718 -1.001 366.563 643.999"
        >
          <path
            d="M428.36 12.5c16.67-16.67 43.76-16.67 60.42 0 16.67 16.67 16.67 43.76 0 60.42L241.7 320c148.25 148.24 230.61 230.6 247.08 247.08 16.67 16.66 16.67 43.75 0 60.42-16.67 16.66-43.76 16.67-60.42 0-27.72-27.71-249.45-249.37-277.16-277.08a42.308 42.308 0 0 1-12.48-30.34c0-11.1 4.1-22.05 12.48-30.42C206.63 234.23 400.64 40.21 428.36 12.5z"
          ></path>
        </svg>
      </button>

      <button class="embla__button embla__button--next" type="button">
        <svg class="embla__button__svg" viewBox="0 0 238.003 238.003">
          <path
            d="M181.776 107.719L78.705 4.648c-6.198-6.198-16.273-6.198-22.47 0s-6.198 16.273 0 22.47l91.883 91.883-91.883 91.883c-6.198 6.198-6.198 16.273 0 22.47s16.273 6.198 22.47 0l103.071-103.039a15.741 15.741 0 0 0 4.64-11.283c0-4.13-1.526-8.199-4.64-11.313z"
          ></path>
        </svg>
      </button>
</div>