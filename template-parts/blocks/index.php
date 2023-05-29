<?php
$className = 'acf-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if( have_rows('content_blocks') ):
    while ( have_rows('content_blocks') ) : the_row();?>
        <div class="<?php echo esc_attr($className); ?>"> 
            <?php get_the_right_row(get_row_layout());?>
        </div>
    <?php endwhile; 
endif;?>