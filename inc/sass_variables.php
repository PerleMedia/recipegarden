<?php 
/**
 * Color variables pulled from ACF, requires post update to generate
 */
$background = get_field('global_background','option');
$primary = get_field('global_color_one','option'); 
$secondary = get_field('global_color_two','option');
$highlight = get_field('global_color_three','option');
$accent = get_field('global_color_four','option');
$text_color = get_field('global_text','option');

$header_background = get_field('header_background','option');
$header_primary = get_field('header_color_one','option');
$header_secondary = get_field('header_color_two','option');
$header_highlight = get_field('header_color_three','option');
$header_accent = get_field('header_color_four','option');

$footer_background = get_field('footer_background','option');
$footer_primary = get_field('footer_color_one','option');
$footer_secondary = get_field('footer_color_two','option');
$footer_highlight = get_field('footer_color_three','option');
$footer_accent = get_field('footer_color_four','option');?>
$background_color: <?php if($background) : echo $background; else : echo "#FAFAFA"; endif; ?>;
$primary_color: <?php if($primary) : echo $primary; else : echo "#BD176D"; endif; ?>;
$secondary_color: <?php if($secondary) : echo $secondary; else : echo "#991EB4"; endif; ?>;
$highlight_color: <?php if($highlight) : echo $highlight; else : echo "#4C36F0"; endif; ?>;
$accent_color: <?php if($accent) : echo $accent; else : echo "#221A24"; endif; ?>;
$text_color: <?php if($text_color) : echo $text_color; else : echo "#272727"; endif; ?>;

$header_background: <?php if($header_background) : echo $header_background; else : echo "#272727"; endif; ?>;
$header_primary: <?php if($header_primary) : echo $header_primary; else : echo "#FFFFFF"; endif; ?>;
$header_secondary: <?php if($header_secondary) : echo $header_secondary; else : echo "#BD176D"; endif; ?>;
$header_highlight: <?php if($header_highlight) : echo $header_highlight; else : echo "#991EB4"; endif; ?>;
$header_accent: <?php if($header_accent) : echo $header_accent; else : echo "#484848"; endif; ?>;

$footer_background: <?php if($footer_background) : echo $footer_background; else : echo "#272727"; endif; ?>;
$footer_primary: <?php if($footer_primary) : echo $footer_primary; else : echo "#FFFFFF"; endif; ?>;
$footer_secondary: <?php if($footer_secondary) : echo $footer_secondary; else : echo "#BD176D"; endif; ?>;
$footer_highlight: <?php if($footer_highlight) : echo $footer_highlight; else : echo "#991EB4"; endif; ?>;
$footer_accent: <?php if($footer_accent) : echo $footer_accent; else : echo "#1C1B1B"; endif; ?>;

$perlemedia_gradient:linear-gradient(98deg, $primary_color 0%, $secondary_color 100%);

