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