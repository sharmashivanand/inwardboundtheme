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
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap">', array(), null);
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

//add_action( 'template_redirect', 'ibme_redirect_home' );

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
add_shortcode('ibme_current_year', 'ibme_current_year_shortcode');

function ibme_current_year_shortcode() {
    // Get the current year
    $current_year = date('Y');

    // Return the current year
    return $current_year;
}

// Register the shortcode for button
add_shortcode('ibme_button', 'ibme_button_handler');

// Define the shortcode function
function ibme_button_handler($atts) {

	$color_class = '';
	$button_2_color_class = '';
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'link'      				=> '',
            'text'      				=> '',
            'color'  					=> '',
            'style'     				=> 'style-1', // style-1, style-2, style-3, style-4, style-5, style-6
            'type'      				=> 'single',
            'button-2-link'    			=> '', // Link for the second button
            'button-2-text'     		=> '', // Text for the second button
            'button-2-color' 			=> '', // BG color for the second button
            'button-2-style' 			=> '', // Style for the second button
            'text-color' 				=> 'black', 
            'button-2-text-color' 		=> 'black', 
        ),

        $atts,
        'ibme_button'
    );

    // Sanitize attributes
    $link = esc_url($atts['link']);
    $text = esc_html($atts['text']);
    $color = esc_attr($atts['color']); // possible values: 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavender', 'black', 'white', default set as 'mint'
    $style = esc_attr($atts['style']); // possible values: 'style-1', 'style-2', 'style-3', 'style-4', 'style-5' and 'style-6', default set as 'style-1'
    $type = esc_attr($atts['type']); // possible values: 'dual' or 'single', default set as single
	$text_color = esc_attr($atts['text-color']); // possible values: 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavender', 'black', 'white', default set as 'mint'

	if($color == '') {
		$color_class = '';
	} else {
		$color_class = $color.'-button ';
	}

	// Check if the link is external
    $is_external = (strpos($link, home_url()) === false);
	// Add the target attribute based on whether it's internal or external
    $target_attribute = $is_external ? 'target="_blank"' : '';

	if(!empty($link)) {
    // Handle "dual" type
		if ($type === 'dual') {
			// Sanitize attributes for the second button
			$button_2_link = esc_url($atts['button-2-link']);
			$button_2_text = esc_html($atts['button-2-text']);
			$button_2_color = esc_attr($atts['button-2-color']);
			$button_2_style = esc_attr($atts['button-2-style']);
			$button_2_text_color = esc_attr($atts['button-2-text-color']);

			if($button_2_color == '') {
				$button_2_color_class = '';
			} else {
				$button_2_color_class = $button_2_color.'-button ';
			}

			// Check if the button_2_link is external
			$is_external_2 = (strpos($button_2_link, home_url()) === false);
			// Add the target attribute based on whether it's internal or external
			$target_attribute_2 = $is_external_2 ? 'target="_blank"' : '';

			// Generate HTML for the dual buttons
			$button_html = '<div class="inline-buttons">';
			$button_html .= '<a href="' . $link . '" class="ibme-button ' . $color_class . $style . ' '.$text_color.'-text" '. $target_attribute.'>' . $text . '</a>';
			$button_html .= '<a href="' . $button_2_link . '" class="ibme-button ' . $button_2_color_class . $button_2_style . ' '.$button_2_text_color.'-text" '. $target_attribute_2.'>' . $button_2_text . '</a>';
			$button_html .= '</div>';
		} else {
			// Generate HTML for a single button
			$button_html = '<a href="' . $link . '" class="ibme-button ' .  $color_class . $style . ' '.$text_color.'-text" '. $target_attribute.'>' . $text . '</a>';
		}
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
			'text-color'      			=> 'black', // black, white
			'button-type'      			=> 'single',
			'button-link'      			=> '',
			'button-text'      			=> '',
			'button-color'  			=> '',
			'button-style'     			=> 'style-3',
			'button-text-color'     	=> 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
			'button-2-link'      		=> '',
			'button-2-text'      		=> '',
			'button-2-color'  			=> '',
			'button-2-style'     		=> 'style-4',
			'button-2-text-color'     		=> 'barbie', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, white
			'top-illustration'     		=> 'face-blush',
			'bottom-illustration'     	=> 'plant-blush'
		),

		$atts,
		'ibme_statement_1'
	);

	// Sanitize attributes
	$title = esc_html($atts['title']);
	$text = esc_html($atts['text']);
	$text_color = esc_attr($atts['text-color']);
	$button_type = esc_attr($atts['button-type']);
	$button_link = esc_url($atts['button-link']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_text = esc_html($atts['button-text']);
	$button_2_text = esc_html($atts['button-2-text']);
	$button_color = esc_attr($atts['button-color']);
	$button_text_color = esc_attr($atts['button-text-color']);
	$button_2_color = esc_attr($atts['button-2-color']);
	$button_2_text_color = esc_attr($atts['button-2-text-color']);
	$button_style = esc_attr($atts['button-style']);
	$button_2_style = esc_attr($atts['button-2-style']);
	$top_illustration = esc_attr($atts['top-illustration']);
	$bottom_illustration = esc_attr($atts['bottom-illustration']);

	$top_illustration_class = 'top-illustration '.$top_illustration;
	$bottom_illustration_class = 'bottom-illustration '.$bottom_illustration;

	// Generate HTML for the statement_1 block
	$statement_1_html = '<section class="full-width-section landing-section '.$text_color.'-text ibme-statement-1"><div class="inner-wrap '.$top_illustration_class.'"><div class="landing-section-content '.$bottom_illustration_class.'">';
	$statement_1_html .= '<h3 class="title">'.$title.'</h3>';
	$statement_1_html .= '<p>'.$text.'</p>';
	$statement_1_html .= do_shortcode('[ibme_button link="'.$button_link.'" text="'.$button_text.'" color="'.$button_color.'" style="'.$button_style.'" text-color="'.$button_text_color.'" type="'.$button_type.'" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-color="'.$button_2_color.'" button-2-text-color="'.$button_2_text_color.'" button-2-style="'.$button_2_style.'"]');
	$statement_1_html .= '</div>';
	$statement_1_html .= '</div>';
	$statement_1_html .= '</section>';

	return $statement_1_html;
}

// Register the shortcode for the "cta_1" block

function ibme_cta_1_content_block_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'      				=> '',
			'text'      				=> '',
			'image-url'      			=> '',
			'color'      				=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'button-link'      			=> '',
			'button-text'      			=> '',
			'button-2-link'      		=> '',
			'button-2-text'      		=> '',
		),

		$atts,
		'ibme_cta_1_content_block'
	);

	// Sanitize attributes
	$title = esc_html($atts['title']);
	$text = esc_html($atts['text']);
	$image_url = esc_url($atts['image-url']);
	$color = esc_attr($atts['color']);
	$button_link = esc_url($atts['button-link']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_text = esc_html($atts['button-text']);
	$button_2_text = esc_html($atts['button-2-text']);

	// Generate HTML for the ibme_cta_1_content_block
	$cta_1_content_block_html = '<div class="ibme-cta_1-content-block '.$color.'-bg-color">';
	$cta_1_content_block_html .= '<div class="ibme-cta_1-content-block-container">';
	$cta_1_content_block_html .= '<div class="ibme-cta_1-image-content"><img src="'.$image_url.'" alt="'.$title.'" /></div>';
	$cta_1_content_block_html .= '<div class="ibme-cta_1-textual-content-wrap"><div class="ibme-cta_1-textual-content">';
	$cta_1_content_block_html .= '<h2 class="title">'.$title.'</h2>';
	$cta_1_content_block_html .= '<p class="ibme-cta_1-content-description">'.$text.'</p>';
	$cta_1_content_block_html .= do_shortcode('[ibme_button type="dual" link="'.$button_link.'" text="'.$button_text.'" color="'.$color.'" style="style-1" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-color="'.$color.'" button-2-style="style-4"]');
	$cta_1_content_block_html .= '</div></div></div></div>';

	return $cta_1_content_block_html;
}

function ibme_cta_1_container_handler($atts, $content = null) {
	// Generate HTML for the ibme_cta_1_container
	$cta_1_container_html = '<section class="full-width-section landing-section cta_1-section"><div class="inner-wrap"><div class="landing-section-content"><div class="ibme-cta_1-content-blocks">';
    
	// Use a regular expression to match [ibme_cta_1_content_block] shortcodes
	preg_match_all('/\[ibme_cta_1_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER);

	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$content_block_content = do_shortcode('[ibme_cta_1_content_block' . $match[1] . ']'); // Process content within [ibme_cta_1_content_block]

		// Process and use $params and $content_block_content as needed
		$cta_1_container_html .= $content_block_content;
	}

	$cta_1_container_html .= '</div></div></div></section>';

	return $cta_1_container_html;
}

// Register the container shortcode
add_shortcode('ibme_cta_1_container', 'ibme_cta_1_container_handler');

// Content block shortcode registration as a nested shortcode within the container
add_shortcode('ibme_cta_1_content_block', 'ibme_cta_1_content_block_handler');


// Register the shortcode for the "cta_2" block

function ibme_cta_2_content_block_handler($atts) {
	$width = '';
	$path = '';

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar', 'none'
			'illustration'  => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'title'         => '', 
			'button-text'   => '', 
			'button-link'   => '', 					
			'button-style'   => 'style-5', 			
			'text-color'   => 'black', //black, white			
			'button-text-color'   => 'black', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar', 'black'			
		),
		$atts,
		'ibme_cta_2_content_block'
	);

	// Sanitize attributes

	$color = esc_attr($atts['color']);
	$illustration = esc_attr($atts['illustration']);
	$title = esc_html($atts['title']);
	$button_text = esc_html($atts['button-text']);
	$button_link = esc_url($atts['button-link']);
	$button_style = esc_attr($atts['button-style']);
	$text_color = esc_attr($atts['text-color']);
	$button_text_color = esc_attr($atts['button-text-color']);

	if($text_color == 'black') {
		$path = '/assets/img/cta2-illustrations/';
	} else {
		$path = '/assets/img/cta2-illustrations/white/';
	}

	/* Set width for illustration */

	if(in_array($illustration, array('fire', 'talking', 'yoga', 'smiles', 'music', 'cabin', 'heart-hug'))) {
		$width = '195';
	} else {
		$width = '175';
	}

	// Generate HTML for the cta_2 block

	$cta_2_content_block_html .= '<div class="cta_2-item '.$color.'-bg-color '.$text_color.'-text">';
	$cta_2_content_block_html .= '<p><img src="'.get_stylesheet_directory_uri() . $path . $illustration . '.svg" alt="'.$title.'" width="'.$width.'" height="155" /></p>';
	$cta_2_content_block_html .= '<h3 class="header-3">'.$title.'</h3>';
	$cta_2_content_block_html .= do_shortcode('[ibme_button link="'.$button_link.'" text="'.$button_text.'" style="'.$button_style.'" text-color="'.$button_text_color.'"]');
	$cta_2_content_block_html .= '</div>';
	
	return $cta_2_content_block_html;

}

function ibme_cta_2_container_handler($atts, $content = null) {
	// Use a regular expression to match [ibme_cta_2_content_block] shortcodes
	preg_match_all('/\[ibme_cta_2_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER);

	$class = 'cta-items-'.count($matches);
	
	// Generate HTML for the ibme_cta_2_container
	$cta_2_container_html = '<section class="full-width-section landing-section cta_2_section"><div class="inner-wrap"><div class="landing-section-content"><div class="cta_2-items '.$class.'">';
    
	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$content_block_content = do_shortcode('[ibme_cta_2_content_block' . $match[1] . ']'); // Process content within [ibme_cta_2_content_block]

		// Process and use $params and $content_block_content as needed
		$cta_2_container_html .= $content_block_content;
	}

	$cta_2_container_html .= '</div></div></div></section>';

	return $cta_2_container_html;
}

// Register the container shortcode
add_shortcode('ibme_cta_2_container', 'ibme_cta_2_container_handler');

// Content block shortcode registration as a nested shortcode within the container
add_shortcode('ibme_cta_2_content_block', 'ibme_cta_2_content_block_handler');

// Register the shortcode for the "testimonial" block

function ibme_testimonial_block_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'      				=> '', // ocean, forest, teal, white
			'image-url'      			=> '',
			'testimonial'      			=> '',
			'testimonial-by'      		=> '', 
			'testimonial-by-color'      => 'black', // black, white
		),

		$atts,
		'ibme_testimonial_block_handler'
	);

	// Sanitize attributes
	$color = esc_attr($atts['color']);
	$image_url = esc_url($atts['image-url']);
	$testimonial = esc_html($atts['testimonial']);
	$testimonial_by = esc_html($atts['testimonial-by']);
	$testimonial_by_color = esc_attr($atts['testimonial-by-color']);

	// Generate HTML for the ibme_testimonial_block

	$testimonial_block_html = '<div class="ibme-testimonial-wrap '.$color.'-testimonial">';
	$testimonial_block_html .= '<div class="ibme-testimonial-image-wrap"><img src="'.$image_url.'" alt="Testimonial by '.$testimonial_by.'" width="556" height="550" /></div>';
	$testimonial_block_html .= '<div class="testimonial-content-wrap"><p class="header-2">'.$testimonial.'</p>';
	$testimonial_block_html .= '<p class="testimonial-by '.$testimonial_by_color.'-text">'.$testimonial_by.'</p>';
	$testimonial_block_html .= '</div></div>';

	return $testimonial_block_html;

}

function ibme_testimonials_container_handler($atts, $content = null) {
	// Generate HTML for the ibme_testimonials_container
	$testimonials_container_html = '<section class="full-width-section landing-section ibme-testimonial-section"><div class="inner-wrap"><div class="landing-section-content"><div class="ibme-testimonials-slider">';
    
	// Use a regular expression to match [ibme_testimonial_block] shortcodes
	preg_match_all('/\[ibme_testimonial_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER);

	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$content_block_content = do_shortcode('[ibme_testimonial_block' . $match[1] . ']'); // Process content within [ibme_testimonial_block]

		// Process and use $params and $content_block_content as needed
		$testimonials_container_html .= $content_block_content;
	}

	$testimonials_container_html .= '</div></div></div></section>';

	return $testimonials_container_html;
}

// Register the container shortcode for testimonials
add_shortcode('ibme_testimonials_container', 'ibme_testimonials_container_handler');

// Testimonial block shortcode registration as a nested shortcode within the container
add_shortcode('ibme_testimonial_block', 'ibme_testimonial_block_handler');


// Register the shortcode for the "ibme_upcoming_events" block (parent block) and "ibme_upcoming_event" block (child block)

add_shortcode('ibme_upcoming_events', 'ibme_upcoming_events_handler');

function ibme_upcoming_events_handler($atts, $content = null) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'      		=> '',
			'title'      			=> '',
			'button-text'      		=> '', 
			'button-link'      		=> '', 
			'button-text-color'      		=> 'black', // black, cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender
		),

		$atts,
		'ibme_upcoming_events'
	);	

	// Sanitize attributes
	$image_url = esc_url($atts['image-url']);
	$title = esc_html($atts['title']);
	$button_text = esc_html($atts['button-text']);
	$button_link = esc_url($atts['button-link']);
	$button_text_color = esc_attr($atts['button-text-color']);

	// Generate HTML for the ibme_upcoming_events block
	$upcoming_events_html = '<section class="full-width-section landing-section upcoming-events-section" style="background-image: url(\'' . $image_url . '\')"><div class="inner-wrap"><div class="landing-section-content">';
	$upcoming_events_html .= '<div class="headline-column content-column"><h2 class="headline-title title">'.$title.'</h2>';
	$upcoming_events_html .= do_shortcode('[ibme_button text-color="'.$button_text_color.'" link="'.$button_link.'" text="'.$button_text.'" style="style-2"]');
	$upcoming_events_html .= '</div>';
	$upcoming_events_html .= '<div class="upcoming-events-list content-column">';

	preg_match_all('/\[ibme_upcoming_event(.*?)\]/s', $content, $matches, PREG_SET_ORDER);

	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$ibme_upcoming_event_block = do_shortcode('[ibme_upcoming_event' . $match[1] . ']'); // Process content within [ibme_upcoming_event]

		// Process and use $params and $content_block_content as needed
		$upcoming_events_html .= $ibme_upcoming_event_block;
	}

	$upcoming_events_html .= '</div></div></div></section>';

	return $upcoming_events_html;
}

add_shortcode('ibme_upcoming_event', 'ibme_upcoming_event_handler');

function ibme_upcoming_event_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'      				=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'date-time'      			=> '',
			'event-name'      			=> '',
			'event-location'      		=> '', 
			'button-link'      			=> '', 
			'button-text'      			=> '', 
			'button-2-link'      		=> '', 
			'button-2-text'      		=> '', 
		),

		$atts,
		'ibme_upcoming_event'
	);

	// Sanitize attributes
	$color = esc_attr($atts['color']);
	$date_time = wp_kses_post($atts['date-time']);
	$event_name = esc_html($atts['event-name']);
	$event_location = esc_html($atts['event-location']);
	$button_link = esc_url($atts['button-link']);
	$button_text = esc_html($atts['button-text']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_2_text = esc_html($atts['button-2-text']);

	// Generate HTML for the ibme_upcoming_event block

	$upcoming_event_html = '<div class="upcoming-event-item '.$color.'-color">';
	$upcoming_event_html .= '<div class="upcoming-event-date">';
	$upcoming_event_html .= '<p class="header-4">'.$date_time.'</p>';
	$upcoming_event_html .= '</div>';
	$upcoming_event_html .= '<div class="upcoming-event-title-location">';
	$upcoming_event_html .= '<h4 class="header-3">'.$event_name.'</h4>';
	$upcoming_event_html .= '<p class="upcoming-event-location">'.$event_location.'</p>';
	$upcoming_event_html .= '</div><div class="upcoming-event-links">';
	$upcoming_event_html .= do_shortcode('[ibme_button color="'.$color.'" link="'.$button_link.'" text="'.$button_text.'" style="style-1"]');
	$upcoming_event_html .= do_shortcode('[ibme_button color="'.$color.'" link="'.$button_2_link.'" text="'.$button_2_text.'" style="style-4"]');
	$upcoming_event_html .= '</div></div>';

	return $upcoming_event_html;

}


// Register the shortcode for the "cta_3" block

function ibme_cta_3_content_block_handler($atts) {
	
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'      			=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar', 'none'
			'title'        			=> '', 
			'text'          		=> '', 
			'image-url'     		=> '', 
			'button-text'   		=> '', 
			'button-link'   		=> '', 
			'button-style' 			=> 'style-5', // style-5, style-2
			'text-color'    		=> 'black', // black, white
			'button-text-color'     => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
		),
		$atts,
		'ibme_cta_3_content_block'
	);

	// Sanitize attributes

	$color = esc_attr($atts['color']);
	$title = esc_html($atts['title']);
	$text = esc_html($atts['text']);
	$image_url = esc_url($atts['image-url']);
	$button_text = esc_html($atts['button-text']);
	$button_link = esc_url($atts['button-link']);
	$button_style = esc_attr($atts['button-style']);
	$text_color = esc_attr($atts['text-color']);
	$button_text_color = esc_attr($atts['button-text-color']);

	// Generate HTML for the cta_2 block

	$cta_3_content_block_html = '<div class="cta-3_column '.$color.'-bg-color"><img class="aligncenter" src="'.$image_url.'" alt="'.$title.'" />';
	$cta_3_content_block_html .= '<div class="cta-3_column-content">'; 
	$cta_3_content_block_html .= '<h3 class="header-3 '.$text_color.'-text">'.$title.'</h3>'; 
	$cta_3_content_block_html .= '<p class="cta-3_column-text '.$text_color.'-text">'.$text.'</p>'; 
	$cta_3_content_block_html .= do_shortcode('[ibme_button text-color="'.$button_text_color.'" link="'.$button_link.'" text="'.$button_text.'" style="'.$button_style.'"]');
	$cta_3_content_block_html .= '</div></div>';

	return $cta_3_content_block_html;
}

function ibme_cta_3_content_blocks_handler($atts, $content = null) {
	// Use a regular expression to match [ibme_cta_3_content_block] shortcodes
	preg_match_all('/\[ibme_cta_3_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER);
	$class = 'cta-items-'.count($matches);
	
	// Generate HTML for the ibme_cta_3_content_blocks
	$cta_3_content_blocks_html = '<div class="cta-3_columns content-column '.$class.'">';
    
	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$content_block_content = do_shortcode('[ibme_cta_3_content_block' . $match[1] . ']'); // Process content within [ibme_cta_3_content_block]

		// Process and use $params and $content_block_content as needed
		$cta_3_content_blocks_html .= $content_block_content;
	}

	$cta_3_content_blocks_html .= '</div>';

	return $cta_3_content_blocks_html;
}

// Register the container shortcode
add_shortcode('ibme_cta_3_content_blocks', 'ibme_cta_3_content_blocks_handler');

// Content block shortcode registration as a nested shortcode within the container
add_shortcode('ibme_cta_3_content_block', 'ibme_cta_3_content_block_handler');

// Register the shortcode for the "ibme_subscribe_block" block

add_shortcode('ibme_subscribe_block', 'ibme_subscribe_block_handler');

function ibme_subscribe_block_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'         => '', 
		),
		$atts,
		'ibme_subscribe_block'
	);

	// Sanitize attributes
	$title = esc_html($atts['title']);
	$form_html = wp_kses_post($atts['form-html']);

	// Generate HTML for the ibme_subscribe_block block

	$subscribe_block_html = '<div class="subscribe-block content-column">';
	$subscribe_block_html .= '<h2 class="title">'.$title.'</h2>';
	$subscribe_block_html .= '<div class="ibme-subscribe-form">
	<div class="left-form-field form-field"><input name="first-name" type="text" placeholder="first name" /></div>
	<div class="right-form-field form-field"><input name="last-name" type="last" placeholder="last name" /></div>
	<div class="left-form-field form-field"><input name="email" type="email" placeholder="email" /></div>
	<div class="right-form-field form-field"><select id="state" name="state">
	<option value="blank-option">State</option>
	<option value="state-1">State 1</option>
	<option value="state-2">State 2</option>
	<option value="state-3">State 3</option>
	</select></div>
	<div class="left-form-field form-field"><label for="retreats">Interested in (check all that apply):</label></div>
	<div class="right-form-field form-field"><select id="retreats" name="retreats">
	<option value="teen-retreats">Teen Retreats</option>
	<option value="mindfulness-retreats">Mindfulness Retreats</option>
	<option value="teacher-training">Teacher Training</option>
	<option value="equity-conversation">Equity Conversation</option>
	</select></div>
	<div class="form-submit-button"></div>';
	$subscribe_block_html .= do_shortcode('[ibme_button link="https://example.com/" text="Subscribe" color="tangerine" style="style-1"]');
	$subscribe_block_html .= '</div></div>';

	return $subscribe_block_html;

}

// Register the shortcode for the "ibme_cta_3_subscribe_container" container 

add_shortcode ('ibme_cta_3_subscribe_container','ibme_cta_3_subscribe_container_handler');

function ibme_cta_3_subscribe_container_handler($atts, $content = null) {

	// Use output buffering to capture the content within the shortcode
    ob_start();
    ?>
    <section class="full-width-section landing-section ibme_cta-3_subscribe_block">
		<div class="inner-wrap">
			<div class="landing-section-content">
        		<?php echo do_shortcode($content); // Output the content within the shortcode ?>
			</div>
		</div>
	</section>
    <?php

    // Return the buffered content
    return ob_get_clean();
}

// Register the shortcode for the "hero_1_photo" block

add_shortcode( 'hero_1_photo', 'hero_1_photo_handler' );

function hero_1_photo_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'      	=> '', // jpg, png, gif
			'title'         	=> '', 
			'title-color'       => '', // white, black
			'button-color'   	=> '', 
			'button-text'   	=> '', 
			'button-2-text'   	=> '', 
			'button-link'   	=> '', 			
			'button-2-link'   	=> '', 			
			'button-2-text-color'   	=> 'black', //cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black 			
		),
		$atts,
		'hero_1_photo'
	);

	// Sanitize attributes
	$image_url = esc_url($atts['image-url']);
	$title = esc_html($atts['title']);
	$title_color = esc_attr($atts['title-color']);
	$button_color = esc_attr($atts['button-color']);
	$button_text = esc_html($atts['button-text']);
	$button_2_text = esc_html($atts['button-2-text']);
	$button_link = esc_url($atts['button-link']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_2_text_color = esc_attr($atts['button-2-text-color']);

	// Generate HTML for the hero_1_photo block

	$hero_1_photo_html = '<section class="full-width-section landing-section hero_1_photo-section" style="background-image: url(\'' . $image_url . '\')"><div class="inner-wrap"><div class="landing-section-content">';
	$hero_1_photo_html .= '<h2 class="title '.$title_color.'-title">'.$title.'</h2>';
	$hero_1_photo_html .= do_shortcode('[ibme_button type="dual" link="'.$button_link.'" text="'.$button_text.'" color="'.$button_color.'" style="style-1" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-style="style-2" button-2-text-color="'.$button_2_text_color.'"]');
	$hero_1_photo_html .= '</div></div></section>';

	return $hero_1_photo_html;
}

add_action('wp_footer', 'hero_1_slider_script');

function hero_1_slider_script() {
    ?>
    <script type="text/javascript">
        // Check if the .hero_1-slider element exists
        if (document.querySelector('.hero_1-slider')) {
            var slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("hero_1-slide");
                var dots = document.getElementsByClassName("hero_1-dot");
                if (n > slides.length) {slideIndex = 1}    
                if (n < 1) {slideIndex = slides.length}

                for (i = 0; i < slides.length; i++) {
                    slides[i].style.opacity = 0;  // Hide all slides
                    dots[i].className = dots[i].className.replace(" active", "");
                }

                slides[slideIndex-1].style.opacity = 1;  // Show the current slide
                dots[slideIndex-1].className += " active";
            }

            // Automatic slide
            var slideInterval = setInterval(function() {
                plusSlides(1);
            }, 1500);

            // Pause on hover
            document.querySelector('.hero_1-slider').addEventListener('mouseover', function() {
                clearInterval(slideInterval);
            });

            // Resume on mouse leave
            document.querySelector('.hero_1-slider').addEventListener('mouseout', function() {
                slideInterval = setInterval(function() {
                    plusSlides(1);
                }, 1500);
            });
        }
    </script>
    <?php
}


// Register the shortcode for the "hero_1_slider" block

add_shortcode( 'hero_1_slider', 'hero_1_slider_handler' );

function hero_1_slider_handler($atts, $content = null) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'         	=> '', 
			'title-color'       => '', // white, black
			'button-color'   	=> '', 
			'button-text'   	=> '', 
			'button-2-text'   	=> '', 
			'button-link'   	=> '', 			
			'button-2-link'   	=> '', 			
			'button-2-text-color'   	=> 'black', //cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black 			
		),
		$atts,
		'hero_1_slider'
	);

	// Sanitize attributes
	$title = esc_html($atts['title']);
	$title_color = esc_attr($atts['title-color']);
	$button_color = esc_attr($atts['button-color']);
	$button_text = esc_html($atts['button-text']);
	$button_2_text = esc_html($atts['button-2-text']);
	$button_link = esc_url($atts['button-link']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_2_text_color = esc_attr($atts['button-2-text-color']);

	// Use a regular expression to match [hero_1_slide] shortcodes
	preg_match_all('/\[hero_1_slide(.*?)\]/s', $content, $matches, PREG_SET_ORDER);
	$slide_count = count($matches);

	// Generate HTML for the hero_1_slider block

	$hero_1_slider_html = '<section class="full-width-section landing-section hero_1-slider-section"><div class="hero_1-slider"><div class="hero_1-slides">';

	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$content_block_content = do_shortcode('[hero_1_slide' . $match[1] . ']'); // Process content within [hero_1_slide]

		// Process and use $params and $content_block_content as needed
		$hero_1_slider_html .= $content_block_content;
	}

	$hero_1_slider_html .= '</div>';
	$hero_1_slider_html .= '<div class="inner-wrap">';
	$hero_1_slider_html .= '<div class="landing-section-content">';
	$hero_1_slider_html .= '<div class="hero_1-slider-content">';
	$hero_1_slider_html .= '<h2 class="title '.$title_color.'-title">'.$title.'</h2>';
	$hero_1_slider_html .= do_shortcode('[ibme_button type="dual" link="'.$button_link.'" text="'.$button_text.'" color="'.$button_color.'" style="style-1" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-style="style-2" button-2-text-color="'.$button_2_text_color.'"]');
	$hero_1_slider_html .= '</div>';
	$hero_1_slider_html .= '<div class="hero_1-navigation-dots '.$button_color.'-dots">';

	// Loop for generating navigation dots
	for ($i = 1; $i <= $slide_count; $i++) {
		$hero_1_slider_html .= '<span class="hero_1-dot" onclick="currentSlide('.$i.')"></span>'; 
	}

	$hero_1_slider_html .= '</div></div></div></div></section>';

	return $hero_1_slider_html;
}

// Register the shortcode for the "hero_1_slide" block

add_shortcode( 'hero_1_slide', 'hero_1_slide_handler' );

function hero_1_slide_handler($atts) {

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'         	=> '', 	
		),
		$atts,
		'hero_1_slide'
	);

	// Sanitize attributes

	$image_url = esc_url($atts['image-url']);

	// Generate HTML for the hero_1_slide block

	$hero_1_slide_html = '<div class="hero_1-slide" style="background-image: url(\'' . $image_url . '\')"></div>';

	return $hero_1_slide_html;
}

// Register the shortcode for the "impact_1_slider" block

add_shortcode( 'impact_1_slider', 'impact_1_slider_handler' );

function impact_1_slider_handler($atts, $content = null) {

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'slide-color'         	=> '', 	
			'dot-color'         	=> 'black', // black, white
			'illustration'         	=> 'no-illustration',
		),
		$atts,
		'impact_1_slider'
	);

	// Sanitize attributes

	$slide_color = esc_attr($atts['slide-color']);
	$dot_color = esc_attr($atts['dot-color']);
	$illustration = esc_attr($atts['illustration']);

	// Generate HTML for the impact_1_slider
	$impact_1_slider_html = '<section class="full-width-section landing-section impact_1-section '.$illustration.'"><div class="inner-wrap"><div class="landing-section-content"><div class="impact_1-slider '.$slide_color.'-slider"><div class="impact_1-slides">';
	
	// Use a regular expression to match [impact_1_slide] shortcodes
	preg_match_all('/\[impact_1_slide(.*?)\]/s', $content, $matches, PREG_SET_ORDER);
	$slide_count = count($matches);

	// Process and return the content
	foreach ($matches as $match) {
		$params = shortcode_parse_atts($match[1]); // Parse parameters
		$content_block_content = do_shortcode('[impact_1_slide' . $match[1] . ']'); // Process content within [impact_1_slide]

		// Process and use $params and $content_block_content as needed
		$impact_1_slider_html .= $content_block_content;
	}

	$impact_1_slider_html .= '</div>';
	$impact_1_slider_html .= '<div class="impact_1-navigation-dots '.$dot_color.'-dots">';

	// Loop for generating navigation dots
	for ($i = 1; $i <= $slide_count; $i++) {
		$impact_1_slider_html .= '<span class="impact_1-dot" onclick="currentImpactSlide('.$i.')"></span>'; 
	}

	$impact_1_slider_html .= '</div></div></div></div></section>';

	return $impact_1_slider_html;
}

add_shortcode('impact_1_slide', 'impact_1_slide_handler');

function impact_1_slide_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'         	=> '', 
			'title-color'       => 'black', // black, white 
			'headline'       	=> '',  
			'headline-color'    => 'slider-color', // black, white 
			'text'   			=> '', 
			'text-color'   		=> 'black', // black, white
			'button-type'   	=> '', 
			'button-text'   	=> '', 
			'button-color'   	=> '', 
			'button-text-color'   	=> 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black 
			'button-link'   	=> '', 
			'button-2-text'   	=> '', 
			'button-2-color'   	=> '', 
			'button-2-link'   	=> '', 
			'button-2-text-color'   	=> 'barbie', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, white 
			'button-style'   	=> 'style-3', 
			'button-2-style'   	=> 'style-4', 
				
		),
		$atts,
		'impact_1_slide'
	);

	// Sanitize attributes
	$title = esc_html($atts['title']);
	$title_color = esc_attr($atts['title-color']);
	$headline = esc_html($atts['headline']); 
	$headline_color = esc_attr($atts['headline-color']); 
	$text = esc_html($atts['text']); 
	$text_color = esc_attr($atts['text-color']); 
	$button_type = esc_attr($atts['button-type']);
	$button_text = esc_html($atts['button-text']);
	$button_color = esc_attr($atts['button-color']);
	$button_link = esc_url($atts['button-link']);
	$button_2_text = esc_html($atts['button-2-text']);
	$button_2_color = esc_attr($atts['button-2-color']);
	$button_2_link = esc_url($atts['button-2-link']);
	$button_style = esc_attr($atts['button-style']);
	$button_2_style = esc_attr($atts['button-2-style']);
	$button_text_color = esc_attr($atts['button-text-color']);
	$button_2_text_color = esc_attr($atts['button-2-text-color']);

	// Generate HTML for the impact_1_slide block

	$impact_1_slide_html = '<div class="impact_1-slide">';
	$impact_1_slide_html .= '<div class="left-column content-column">';
	$impact_1_slide_html .= '<h2 class="title '.$title_color.'-title">'.$title.'</h2>';
	$impact_1_slide_html .= '</div>';
	$impact_1_slide_html .= '<div class="right-column content-column"><h3 class="'.$headline_color.' header-1">'.$headline.'</h3>';
	$impact_1_slide_html .= '<p class="'.$text_color.'-text">'.$text.'</p>';
	$impact_1_slide_html .= do_shortcode('[ibme_button type="'.$button_type.'" link="'.$button_link.'" text="'.$button_text.'" color="'.$button_color.'" text-color="'.$button_text_color.'" style="'.$button_style.'" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-color="'.$button_2_color.'" button-2-text-color="'.$button_2_text_color.'" button-2-style="'.$button_2_style.'"]');
	$impact_1_slide_html .= '</div></div>';

	return $impact_1_slide_html;
	
}

/** Script for impact_1_slider */

add_action('wp_footer', 'impact_1_slider_script');

function impact_1_slider_script() {
	?>
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function () {
    const sliderElement = document.querySelector('.impact_1-slider');
    if (!sliderElement) {
        return;
    }

    let currentIndex = 0;
    const slides = document.querySelectorAll('.impact_1-slide');
    const dots = document.querySelectorAll('.impact_1-dot');
    const totalSlides = slides.length;
    const sliderContainer = document.querySelector('.impact_1-slides');

    function updateSlidePosition() {
        sliderContainer.style.transform = 'translateX(' + (-100 * currentIndex) + '%)';
        dots.forEach((dot, index) => {
            dot.classList.remove('active');
            const effectiveIndex = currentIndex % totalSlides;
            if (index === effectiveIndex) {
                dot.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlidePosition();
    }

    let slideInterval = setInterval(nextSlide, 4000);

    function currentImpactSlide(n) {
        currentIndex = n - 1;
        updateSlidePosition();
        resetInterval();
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 4000);
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => currentImpactSlide(index + 1));
    });

    window.currentImpactSlide = currentImpactSlide;
});


	</script>	
	<?php
}
