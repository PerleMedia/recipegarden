<?php
/**
 * Template part for displaying filterable recipe grid items
 *
 * @package PerleMedia
 */

?>

<a class="recipe-card" href="<?php echo get_permalink( $post->ID ) ?>">
    <h3><?php echo $post->post_title; ?></h3>
    <div class="wrapper">
        <div class="image-wrapper">
            <?php echo get_the_post_thumbnail($post->ID); ?>
            <div class="meta">
                <div class="calories">
                    <span><?php echo get_field('calories', $post->ID); ?></span>
                </div>
            </div>
        </div>
        
    </div>
</a> 