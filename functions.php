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

	$color_class = '';
	$button_2_color_class = '';
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

	if($color == '') {
		$color_class = '';
	} else {
		$color_class = $color.'-button ';
	}

    // Handle "dual" type
    if ($type === 'dual') {
        // Sanitize attributes for the second button
        $button_2_link = esc_url($atts['button-2-link']);
        $button_2_text = esc_html($atts['button-2-text']);
        $button_2_color = esc_attr($atts['button-2-color']);
        $button_2_style = esc_attr($atts['button-2-style']);

		if($button_2_color == '') {
			$button_2_color_class = '';
		} else {
			$button_2_color_class = $button_2_color.'-button ';
		}

        // Generate HTML for the dual buttons
        $button_html = '<div class="inline-buttons">';
        $button_html .= '<a href="' . $link . '" class="ibme-button ' . $color_class . $style . '">' . $text . '</a>';
        $button_html .= '<a href="' . $button_2_link . '" class="ibme-button ' . $button_2_color_class . $button_2_style . '">' . $button_2_text . '</a>';
        $button_html .= '</div>';
    } else {
        // Generate HTML for a single button
        $button_html = '<a href="' . $link . '" class="ibme-button ' .  $color_class . $style . '">' . $text . '</a>';
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

// Register the shortcode for the "cta_1" block

function ibme_cta_1_content_block_handler($atts) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'      				=> '',
			'text'      				=> '',
			'image-url'      			=> '',
			'color'      				=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'button-link'      			=> '#',
			'button-text'      			=> 'Click Here',
			'button-2-link'      		=> '#',
			'button-2-text'      		=> 'Click Here',
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
	$cta_1_content_block_html .= do_shortcode('[ibme-button type="dual" link="'.$button_link.'" text="'.$button_text.'" color="'.$color.'" style="style-1" button-2-link="'.$button_2_link.'" button-2-text="'.$button_2_text.'" button-2-color="'.$color.'" button-2-style="style-4"]');
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

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'illustration'  => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'title'         => '', 
			'button_text'   => '', 
			'button_link'   => '', 			
		),
		$atts,
		'ibme_cta_2_content_block'
	);

	// Sanitize attributes

	$color = esc_attr($atts['color']);
	$illustration = esc_attr($atts['illustration']);
	$title = esc_html($atts['title']);
	$button_text = esc_html($atts['button_text']);
	$button_link = esc_url($atts['button_link']);

	/* Set width for illustration */

	if(in_array($illustration, array('fire', 'talking', 'yoga', 'smiles', 'music', 'cabin', 'heart-hug'))) {
		$width = '195';
	} else {
		$width = '175';
	}

	// Generate HTML for the cta_2 block

	$cta_2_content_block_html .= '<div class="cta_2-item '.$color.'-bg-color">';
	$cta_2_content_block_html .= '<p><img src="'.get_stylesheet_directory_uri() . '/assets/img/cta2-illustrations/' . $illustration . '.svg" alt="'.$title.'" width="'.$width.'" height="155" /></p>';
	$cta_2_content_block_html .= '<h3 class="header-3">'.$title.'</h3>';
	$cta_2_content_block_html .= do_shortcode('[ibme-button link="'.$button_link.'" text="'.$button_text.'" style="style-5"]');
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
			'color'      				=> '', // ocean, forest, teal
			'image-url'      			=> '',
			'testimonial'      			=> '',
			'testimonial-by'      		=> '', 
		),

		$atts,
		'ibme_testimonial_block_handler'
	);

	// Sanitize attributes
	$color = esc_attr($atts['color']);
	$image_url = esc_url($atts['image-url']);
	$testimonial = esc_html($atts['testimonial']);
	$testimonial_by = esc_html($atts['testimonial-by']);

	// Generate HTML for the ibme_testimonial_block

	$testimonial_block_html = '<div class="ibme-testimonial-wrap '.$color.'-testimonial">';
	$testimonial_block_html .= '<div class="ibme-testimonial-image-wrap"><img src="'.$image_url.'" alt="Testimonial by '.$testimonial_by.'" width="556" height="550" /></div>';
	$testimonial_block_html .= '<div class="testimonial-content-wrap"><p class="header-2">'.$testimonial.'</p>';
	$testimonial_block_html .= '<p class="testimonial-by">'.$testimonial_by.'</p>';
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
			'image-url'      			=> '',
			'title'      			=> '',
			'button-text'      		=> '', 
			'button-link'      		=> '', 
		),

		$atts,
		'ibme_upcoming_events'
	);	

	// Sanitize attributes
	$image_url = esc_url($atts['image-url']);
	$title = esc_html($atts['title']);
	$button_text = esc_html($atts['button-text']);
	$button_link = esc_url($atts['button-link']);

	// Generate HTML for the ibme_upcoming_events block
	$upcoming_events_html = '<section class="full-width-section landing-section upcoming-events-section" style="background-image: url(\'' . $image_url . '\')"><div class="inner-wrap"><div class="landing-section-content">';
	$upcoming_events_html .= '<div class="headline-column content-column"><h2 class="headline-title title">'.$title.'</h2>';
	$upcoming_events_html .= do_shortcode('[ibme-button link="'.$button_link.'" text="'.$button_text.'" style="style-2"]');
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

	$upcoming_events_html .= '</div></div></div></div></section>';

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
			'button-link'      		=> '', 
			'button-text'      		=> '', 
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
	$upcoming_event_html .= do_shortcode('[ibme-button color="'.$color.'" link="'.$button_link.'" text="'.$button_text.'" style="style-1"]');
	$upcoming_event_html .= do_shortcode('[ibme-button color="'.$color.'" link="'.$button_2_link.'" text="'.$button_2_text.'" style="style-4"]');
	$upcoming_event_html .= '</div></div>';

	return $upcoming_event_html;

}


// Register the shortcode for the "cta_3" block

function ibme_cta_3_content_block_handler($atts) {
	
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'      	=> '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'title'         => '', 
			'text'          => '', 
			'image-url'     => '', 
			'button-text'   => '', 
			'button-link'   => '', 			
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

	// Generate HTML for the cta_2 block

	$cta_3_content_block_html = '<div class="cta-3_column '.$color.'-bg-color"><img src="'.$image_url.'" alt="'.$title.'" width="280" />';
	$cta_3_content_block_html .= '<div class="cta-3_column-content">'; 
	$cta_3_content_block_html .= '<h3 class="header-3">'.$title.'</h3>'; 
	$cta_3_content_block_html .= '<p class="cta-3_column-text">'.$text.'</p>'; 
	$cta_3_content_block_html .= do_shortcode('[ibme-button link="'.$button_link.'" text="'.$button_text.'" style="style-5"]');
	$cta_3_content_block_html .= '</div></div>';

	return $cta_3_content_block_html;
}

function ibme_cta_3_content_blocks_handler($atts, $content = null) {
	// Use a regular expression to match [ibme_cta_3_content_block] shortcodes
	preg_match_all('/\[ibme_cta_3_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER);
	
	// Generate HTML for the ibme_cta_3_content_blocks
	$cta_3_content_blocks_html = '<div class="cta-3_columns content-column">';
    
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
	$subscribe_block_html .= do_shortcode('[ibme-button link="https://example.com/" text="Subscribe" color="tangerine" style="style-3"]');
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