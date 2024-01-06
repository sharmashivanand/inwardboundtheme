<?php

add_action( 'after_setup_theme', 'ibme_remove_lander_theme_support' );

function ibme_remove_lander_theme_support() {
	// Remove Theme Support
	remove_theme_support( 'lander-silo-menus' );
	remove_theme_support( 'lander-landing-sections' );
	// Reposition Primary Nav Menu
	remove_action( 'lander_after_header', 'lander_primary_nav' );
	add_action( 'lander_after_branding_markup', 'lander_primary_nav' );
	add_action( 'lander_after_branding_markup', 'ibme_extended_top_nav' );
	// Remove default footer
	remove_action( 'lander_footer', 'lander_footer_content' );
}

add_action('lander_before','ibme_page_content');

function ibme_page_content() {
	if(is_page()) {
		remove_action( 'lander_entry_footer', 'lander_post_footer', 10, 2 );
	}
}

add_action('wp_enqueue_scripts', 'enqueue_google_fonts');

function enqueue_google_fonts() {
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap">', array(), null);
}

/* Add Custom Body Class */

add_filter( 'body_class', 'ibme_body_class' );

function ibme_body_class( $classes ) {
	$classes[] = 'ibme';
	return $classes;
}

function ibme_extended_top_nav() {
	wp_nav_menu(
		array(
			'menu'      => 4,
			'container' => 'nav',
		)
	);
}

/** Creating Custom Footer */

add_action( 'lander_footer', 'ibme_custom_footer_content' );

function ibme_custom_footer_content() {
	?>
	<div class="footer-widgets">
		<div class="footer-widget-one footer-widget">
			<?php
			if ( is_active_sidebar( 'footer-widget-one' ) ) {
				dynamic_sidebar( 'footer-widget-one' );  }
			?>
		</div>
		<div class="footer-widget-two footer-widget">
			<?php
			if ( is_active_sidebar( 'footer-widget-two' ) ) {
				dynamic_sidebar( 'footer-widget-two' );  }
			?>
		</div>
		<div class="footer-widget-three footer-widget">
			<?php
			if ( is_active_sidebar( 'footer-widget-three' ) ) {
				dynamic_sidebar( 'footer-widget-three' );  }
			?>
		</div>
	</div>
	<div class="footer-columns">
		<div class="footer-column footer-column-left">
			<?php
			if ( is_active_sidebar( 'footer-widget-four' ) ) {
				dynamic_sidebar( 'footer-widget-four' );  }
			?>
		</div>
		<div class="footer-column footer-column-middle">
			<?php
			if ( is_active_sidebar( 'footer-widget-five' ) ) {
				dynamic_sidebar( 'footer-widget-five' );  }
			?>
		</div>
		<div class="footer-column footer-column-right">
			<?php
			if ( is_active_sidebar( 'footer-widget-six' ) ) {
				dynamic_sidebar( 'footer-widget-six' );  }
			?>
		</div>
	</div>
	<?php
}


/** Registering Footer Wigets */

if ( function_exists( 'register_sidebar' ) ) {
	$footer_widget_one   = array(
		'name'          => __( 'Footer Widget One', 'textdomain' ),
		'id'            => 'footer-widget-one',
		'description'   => __( 'Footer Widget Area (Left)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_two   = array(
		'name'          => __( 'Footer Widget Two', 'textdomain' ),
		'id'            => 'footer-widget-two',
		'description'   => __( 'Footer Widget Area (Middle)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_three = array(
		'name'          => __( 'Footer Widget Three', 'textdomain' ),
		'id'            => 'footer-widget-three',
		'description'   => __( 'Footer Widget Area (Right)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_four = array(
		'name'          => __( 'Footer Widget Four', 'textdomain' ),
		'id'            => 'footer-widget-four',
		'description'   => __( 'Footer Widget Area (Bottom Left)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_five = array(
		'name'          => __( 'Footer Widget Five', 'textdomain' ),
		'id'            => 'footer-widget-five',
		'description'   => __( 'Footer Widget Area (Bottom Middle)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_six = array(
		'name'          => __( 'Footer Widget Six', 'textdomain' ),
		'id'            => 'footer-widget-six',
		'description'   => __( 'Footer Widget Area (Bottom Right)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);

	register_sidebar( $footer_widget_one );
	register_sidebar( $footer_widget_two );
	register_sidebar( $footer_widget_three );
	register_sidebar( $footer_widget_four );
	register_sidebar( $footer_widget_five );
	register_sidebar( $footer_widget_six );

}

/* Redirect all the pages to homepage; for first review */

add_action( 'template_redirect', 'ibme_redirect_home' );

function ibme_redirect_home() {
	if ( current_user_can( 'administrator' ) ) {
		return;
	}
	if ( ! is_front_page() ) {
		wp_redirect( get_permalink( get_option( 'page_on_front' ) ), '302' );
		exit;
	}
}

// Register the shortcode for outputing current year in the footer copyright
add_shortcode('ibme-current-year', 'ibme_current_year_shortcode');

function ibme_current_year_shortcode() {
    // Get the current year
    $current_year = date('Y');

    // Return the current year
    return $current_year;
}

// Register the shortcode for button
add_shortcode('ibme-button', 'ibme_button_handler');

// Define the shortcode function
function ibme_button_handler($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'link'      		=> '#',
            'text'      		=> 'Click Here',
            'color'  			=> '',
            'style'     		=> 'style-1',
            'type'      		=> 'single',
            'button-2-link'     => '', // Link for the second button
            'button-2-text'     => '', // Text for the second button
            'button-2-color' 	=> '', // BG color for the second button
            'button-2-style' 	=> '', // Style for the second button
        ),

        $atts,
        'ibme-button'
    );

    // Sanitize attributes
    $link = esc_url($atts['link']);
    $text = esc_html($atts['text']);
    $color = esc_attr($atts['color']); // possible values: 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavender', 'black', 'white', default set as 'mint'
    $style = esc_attr($atts['style']); // possible values: 'style-1', 'style-2', 'style-3', 'style-4' and 'style-5', default set as 'style-1'
    $type = esc_attr($atts['type']); // possible values: 'dual' or 'single', default set as single

    // Handle "dual" type
    if ($type === 'dual') {
        // Sanitize attributes for the second button
        $button_2_link = esc_url($atts['button-2-link']);
        $button_2_text = esc_html($atts['button-2-text']);
        $button_2_color = esc_attr($atts['button-2-color']);
        $button_2_style = esc_attr($atts['button-2-style']);

        // Generate HTML for the dual buttons
        $button_html = '<div class="inline-buttons">';
        $button_html .= '<a href="' . $link . '" class="ibme-button ' . $color . '-button ' . $style . '">' . $text . '</a>';
        $button_html .= '<a href="' . $button_2_link . '" class="ibme-button ' . $button_2_color . '-button ' . $button_2_style . '">' . $button_2_text . '</a>';
        $button_html .= '</div>';
    } else {
        // Generate HTML for a single button
        $button_html = '<a href="' . $link . '" class="ibme-button ' . $color . '-button ' . $style . '">' . $text . '</a>';
    }

    return $button_html;
}

/**
 * Registering shortcodes for various content blocks 
 */


// Register the shortcode for the "statement_1" block

add_shortcode('ibme_statement_1', 'ibme_statement_1_handler');

function ibme_statement_1_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'      				=> '',
			'text'      				=> '',
			'button-type'      		=> 'single',
			'button-link'      			=> '#',
			'button-text'      			=> 'Click Here',
			'button-color'  			=> '',
			'button-style'     			=> 'style-3',
			'button-2-link'      		=> '#',
			'button-2-text'      		=> 'Click Here',
			'button-2-color'  			=> '',
			'button-2-style'     		=> 'style-4',
			'top-illustration'     		=> 'heart',
			'bottom-illustration'     	=> 'plant'
		),

		$atts,
		'ibme_statement_1'
	);

	// Sanitize attributes
	$title = esc_html($atts['title']);
	$text = esc_html($atts['text']);
	$button_type = esc_attr($atts['button-type']);
	$button_link = esc_url($atts['button-link']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_text = esc_html($atts['button-text']);
	$button_2_text = esc_html($atts['button-2-text']);
	$button_color = esc_attr($atts['button-color']);
	$button_2_color = esc_attr($atts['button-2-color']);
	$button_style = esc_attr($atts['button-style']);
	$button_2_style = esc_attr($atts['button-2-style']);
	$top_illustration = esc_attr($atts['top-illustration']);
	$bottom_illustration = esc_attr($atts['bottom-illustration']);

	$top_illustration_class = 'top-'.$top_illustration.'-'.$button_color;
	$bottom_illustration_class = 'bottom-'.$bottom_illustration.'-'.$button_color;

	// Generate HTML for the statement_1 block
	$statement_1_html = '<section class="full-width-section landing-section '.$top_illustration_class.' ibme-statement-1 '.$bottom_illustration_class.'"><div class="inner-wrap"><div class="landing-section-content">';
	$statement_1_html .= '<h3 class="title">'.$title.'</h3>';
	$statement_1_html .= '<p>'.$text.'</p>';
	$statement_1_html .= do_shortcode('[ibme-button link="'.$button_link.'" text="'.$button_text.'" color="'.$button_color.'" style="'.$button_style.'" type="'.$button_type.'" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-color="'.$button_2_color.'" button-2-style="'.$button_2_style.'"]');
	$statement_1_html .= '</div>';
	$statement_1_html .= '</div>';
	$statement_1_html .= '</section>';

	return $statement_1_html;
}

// Register the shortcode for the "cta_2" block

add_shortcode('ibme_cta_2', 'ibme_cta_2_handler');

function ibme_cta_2_handler($atts) {
	$class = 'cta-items-4';
	$width = '';

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'items'      				=> '4', // 3 or 4
			'cta_item_1_color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'cta_item_2_color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'cta_item_3_color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'cta_item_4_color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'cta_item_1_illustration'    => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'cta_item_2_illustration'    => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'cta_item_3_illustration'    => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'cta_item_4_illustration'    => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'cta_item_1_title'          => '', 
			'cta_item_2_title'          => '', 
			'cta_item_3_title'          => '', 
			'cta_item_4_title'          => '', 
			'cta_item_1_button_text'    => '', 
			'cta_item_2_button_text'    => '', 
			'cta_item_3_button_text'    => '', 
			'cta_item_4_button_text'    => '', 
			'cta_item_1_button_link'    => '', 
			'cta_item_2_button_link'    => '', 
			'cta_item_3_button_link'    => '', 
			'cta_item_4_button_link'    => '', 
		),

		$atts,
		'ibme_cta_2'
	);

	// Sanitize attributes

	$items = (int) esc_attr($atts['items']);
	$cta_item_1_color = esc_attr($atts['cta_item_1_color']);
	$cta_item_2_color = esc_attr($atts['cta_item_2_color']);
	$cta_item_3_color = esc_attr($atts['cta_item_3_color']);
	$cta_item_4_color = esc_attr($atts['cta_item_4_color']);
	$cta_item_1_illustration = esc_attr($atts['cta_item_1_illustration']);
	$cta_item_2_illustration = esc_attr($atts['cta_item_2_illustration']);
	$cta_item_3_illustration = esc_attr($atts['cta_item_3_illustration']);
	$cta_item_4_illustration = esc_attr($atts['cta_item_4_illustration']);
	$cta_item_1_title = esc_html($atts['cta_item_1_title']);
	$cta_item_2_title = esc_html($atts['cta_item_2_title']);
	$cta_item_3_title = esc_html($atts['cta_item_3_title']);
	$cta_item_4_title = esc_html($atts['cta_item_4_title']);
	$cta_item_1_button_text = esc_html($atts['cta_item_1_button_text']);
	$cta_item_2_button_text = esc_html($atts['cta_item_2_button_text']);
	$cta_item_3_button_text = esc_html($atts['cta_item_3_button_text']);
	$cta_item_4_button_text = esc_html($atts['cta_item_4_button_text']);
	$cta_item_1_button_link = esc_url($atts['cta_item_1_button_link']);
	$cta_item_2_button_link = esc_url($atts['cta_item_2_button_link']);
	$cta_item_3_button_link = esc_url($atts['cta_item_3_button_link']);
	$cta_item_4_button_link = esc_url($atts['cta_item_4_button_link']);

	if($items == 3) {
		$class = "cta-items-3";
	}

	// Generate HTML for the cta_2 block

	$cta_2_html = '<section class="full-width-section landing-section cta_2_section"><div class="inner-wrap"><div class="landing-section-content"><div class="cta_2-items '.$class.'">';
	for($i=1; $i<=$items; $i++) {
		// Form the variable names dynamically
		$cta_item_title = 'cta_item_'.$i.'_title';
		$cta_item_illustration = 'cta_item_'.$i.'_illustration';
		$cta_item_color = 'cta_item_'.$i.'_color';
		$cta_item_button_text = 'cta_item_'.$i.'_button_text';
		$cta_item_button_link = 'cta_item_'.$i.'_button_link';

		if(in_array($$cta_item_illustration, array('fire', 'talking', 'yoga', 'smiles', 'music', 'cabin', 'heart-hug'))) {
			$width = '195';
		} else {
			$width = '175';
		}

		$cta_2_html .= '<div class="cta_2-item '.$$cta_item_color.'-bg-color">';
		$cta_2_html .= '<p><img src="'.get_stylesheet_directory_uri() . '/assets/img/cta2-illustrations/' . $$cta_item_illustration . '.svg" alt="'.$$cta_item_title.'" width="'.$width.'" height="155" /></p>';
		$cta_2_html .= '<h3 class="header-3">'.$$cta_item_title.'</h3>';
		$cta_2_html .= do_shortcode('[ibme-button link="'.$$cta_item_button_link.'" text="'.$$cta_item_button_text.'" style="style-5"]');
		$cta_2_html .= '</div>';
	}

	$cta_2_html .= '</div>';
	$cta_2_html .= '</div>';
	$cta_2_html .= '</div>';
	$cta_2_html .= '</section>';

	return $cta_2_html;

}