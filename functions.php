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

add_shortcode('ibme-current-year', 'ibme_current_year_shortcode');

function ibme_current_year_shortcode() {
    // Get the current year
    $current_year = date('Y');

    // Return the current year
    return $current_year;
}

// Register the shortcode
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


