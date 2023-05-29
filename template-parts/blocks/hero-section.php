<?php
    $background_image = get_sub_field('hero_image');
    $heading = get_sub_field('hero_heading');
    $subheading = get_sub_field('hero_subheading');
    $gradient = get_sub_field('hero_gradient');
    $colorOne = $gradient['first_color'];
    $colorTwo = $gradient['second_color'];
    $textColor = get_sub_field('hero_text_color');?>
    
    <div class="hero-block">

        <?php if ($background_image) : ?>
            <div class="block-wrapper" style="background-image:url('<?php echo $background_image['url'];?>');">
        <?php else : ?>
            <div class="block-wrapper">
        <?php endif;  ?>

        <?php if ($gradient) : ?>
            <div class="overlay <?php echo $textColor;?>" style="background: <?php echo $colorOne?>; background: linear-gradient(140deg, <?php echo $colorOne?> 0%, <?php echo $colorTwo?> 100%);">
        <?php else : ?>
            <div class="overlay <?php echo $textColor;?>"> 
        <?php endif; ?>  

            <?php if ($heading) : ?>
                <h1 class="banner-heading"><?php echo $heading; ?></h1>
            <?php else : ?>
                <h1 class="banner-heading"><?php the_title(); ?></h1>
            <?php endif; ?>
            <p><?php echo $subheading;?></p>
        </div><!-- .overlay -->
    </div><!-- .block-wrapper -->
</div><!-- .hero-block -->

