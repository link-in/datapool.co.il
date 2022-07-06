<?php

if (isset($post))
	$page_id = $post->ID;
else
	$page_id = 0;

$tdl_options = woodstock_global_var();
$layout_type = (!empty($tdl_options['tdl_layout_type'])) ? $tdl_options['tdl_layout_type'] : 'fullwidth'; 
if ($layout_type == 'boxed') {$layout_type = 'tdl-boxed';} elseif ($layout_type == 'float_box') {$layout_type = 'tdl-boxed tdl-floating-boxed';} else {$layout_type = 'fullwidth';};
$logo_description = isset($tdl_options['tdl_logo_description']) && $tdl_options['tdl_logo_description'];
$maincontent_color_scheme = (!empty($tdl_options['tdl_maincontent_color_scheme'])) ? $tdl_options['tdl_maincontent_color_scheme'] : 'mc-light';
$header_searchboxdrop_color_scheme = (!empty($tdl_options['tdl_header_searchboxdrop_color_scheme'])) ? $tdl_options['tdl_header_searchboxdrop_color_scheme'] : 'sd-light';
$sidebarnav_color_scheme = (!empty($tdl_options['tdl_sidebarnav_color_scheme'])) ? $tdl_options['tdl_sidebarnav_color_scheme'] : 'snd-light';

if(function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag()))
$page_id = get_option('woocommerce_shop_page_id');
$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php esc_html(bloginfo( 'charset' )); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_html(bloginfo( 'pingback_url' )); ?>">

	<?php
		if (is_singular() && get_option('thread_comments'))
			wp_enqueue_script('comment-reply');

		wp_head();
	?>

</head>

<body <?php body_class(); ?> <?php echo woodstock_main_bg_color(); ?>>
	<?php wp_body_open(); ?>

	<?php if ( (isset($tdl_options['tdl_page_loader'])) && (trim($tdl_options['tdl_page_loader']) == "1" ) ) : ?>
		<div id="wstock-loader-wrapper">
			<div class="wstock-loader-section">
				<div class="wstock-loader-<?php echo esc_attr($tdl_options['tdl_page_loader_spinner']); ?>"></div>
			</div>
		</div>
	<?php endif; ?>

	<div id="off-container" class="off-container">

	<div class="off-drop">
    <div class="off-drop-after"></div>	
    <div class="off-content">
    
 	<?php echo woodstock_main_bg() ?>

	<div id="page-wrap" class="<?php echo esc_attr($layout_type); ?>
	<?php echo esc_attr($maincontent_color_scheme);?>">


	<div class="boxed-layout <?php echo esc_attr($header_searchboxdrop_color_scheme);?> <?php echo esc_attr($sidebarnav_color_scheme); ?>">
               
        <?php if ( isset($tdl_options['main_header_layout']) ) : ?>
								
			<?php if ( $tdl_options['main_header_layout'] == "1" ) : ?>
				<?php get_template_part( 'header', 'default' ); ?>
	        <?php elseif ( $tdl_options['main_header_layout'] == "2" ) : ?>
	        	<?php get_template_part( 'header', 'centered' ); ?>
			<?php endif; ?>	                                
	        <?php else : ?>                          
	            <?php get_template_part( 'header', 'default' ); ?>
        <?php endif; ?>
       