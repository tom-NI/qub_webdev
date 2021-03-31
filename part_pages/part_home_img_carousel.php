<!-- home page image carousel! -->
<div class='carousel carousel-animated carousel-animate-slide' id="home_carousel">
    <div class='carousel-container' id="carousel_container">
        <div class="my_image_maintain_aspect carousel-item has-background is-active">
            <figure>
                <img src="https://i.imgur.com/Ok815ec.jpg" alt="" class="is-background box">
                <caption class="subtitle is-6 is-size-7-mobile">Manchester United and Liverpool are neck and neck this season in the title race</caption>
            </figure>
        </div>
        <?php
            // each image is in an array of link, then the caption afterwards
            $image1 = array("https://i.imgur.com/eDSK70B.png", "Rashford Strikes Again in the game vs. Newcastle United.");
            $image2 = array("https://i.imgur.com/3xunymx.png", "Gylfi Sigurdsson has a great track record vs. Liverpool.");
            $image3 = array("https://i.imgur.com/Ze4g6MN.png", "James Maddison has scored from outside the area more than any other player this season");
            $image4 = array("https://i.imgur.com/IbqFdMh.png", "West Ham had a shock result against Tottenham, beating them 2-1");
            $carouselMainArray = array($image1, $image2, $image3, $image4);
            
            // loop through and print each image
            foreach ($carouselMainArray as $image)
                $link = $image[0];
                $caption = $image[1];
                echo "
                    <div class='my_image_maintain_aspect carousel-item has-background my-element'>
                        <figure>
                            <img src='{$link}' alt='{$caption}' class='is-background box'>
                            <caption class='subtitle is-6 is-size-7-mobile'>{$caption}</caption>
                        </figure>
                    </div>";
        ?>

    </div>
</div>
<script>bulmaCarousel.attach('#carousel_container', {loop: true, autoplay: true});</script>