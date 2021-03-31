<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="stylesheets/mystyles.css">
        <link rel="stylesheet" href="stylesheets/embla_styles.css">
        <link rel="shortcut icon" href="images/favicon.png" type="image/png">
        <script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
        <title>EPL Match Statistic Finder</title>
    </head>
<body>
    <?php
        // require(__DIR__ . "/part_pages/part_home_img_carousel.php");
    ?>

    <div class="embla">
      <div class="embla__viewport">
        <div class="embla__container">
          <div class="embla__slide">
            <img class="embla__slide__img" src="https://i.imgur.com/eDSK70B.png" />
          </div>
          <div class="embla__slide">
            <img class="embla__slide__img" src="https://i.imgur.com/3xunymx.png" />
          </div>
          <div class="embla__slide">
            <img class="embla__slide__img" src="https://i.imgur.com/Ze4g6MN.png" />
          </div>
          <div class="embla__slide">
            <img class="embla__slide__img" src="https://i.imgur.com/IbqFdMh.png" />
          </div>
          <div class="embla__slide">
            <img class="embla__slide__img" src="https://i.imgur.com/Ok815ec.jpg" />
          </div>
        </div>
      </div>

      <!-- Buttons -->
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
    
</body>
    <script src="scripts/embla.js"></script>
    <script src="scripts/my_script.js"></script>
    <script type="text/javascript">
    var emblaNode = document.querySelector('.embla')
    var options = { loop: true }

    var embla = EmblaCarousel(emblaNode, options)
    </script>
</html>



