<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'ibme_remove_lander_theme_support' );

function ibme_remove_lander_theme_support() {
	// Remove Theme Support
	remove_theme_support( 'lander-silo-menus' );
	remove_theme_support( 'lander-landing-sections' );
	// Reposition Primary Nav Menu
	remove_action( 'lander_after_header', 'lander_primary_nav' );
	add_action( 'lander_after_branding_markup', 'lander_primary_nav' );
	add_action( 'lander_after_branding_markup', 'ibme_extended_top_nav' );
	add_action( 'lander_after_branding_markup', 'ibme_mobile_nav' );
	// Remove default footer
	remove_action( 'lander_footer', 'lander_footer_content' );
	add_shortcode( 'ibme_calculator', 'ibme_calculator' );
}

function ibme_calculator( $atts ) {
	$max_limit = '';
	$min_limit = '';
	extract(
		shortcode_atts(
			array(
				'max' => '',
				'min' => '',
				'cap' => '',
			),
			$atts
		)
	);
	if ( empty( $max ) ) {
		$max_limit = 2500;
	} else {
		$max_limit = $max;
	}
	if ( empty( $min ) ) {
		$min_limit = 250;
	} else {
		$min_limit = $min;
	}
	if ( empty( $cap ) ) {
		$cap = 1500;
	} else {
		$cap = $cap;
	}
	ob_start();
	?>
	<form class="ibme_calc_form">
		<fieldset class="ibme_calc_form_container">
			<div class="ibme_calc_form_container_title header-3">Annual Household Income</div>
			<div class="ibme_calc_form_field">
				<span class="ibme_calc_form_curr_sym">$</span>
				<input type="number" id="annual_family_income" min='0' placeholder="Enter Your Annual Household Income" />
			</div>
		</fieldset>
		<fieldset class="ibme_calc_form_container">
			<div class="ibme_calc_form_container_title"></div>
			<div class="inline-buttons">
				<input type="button" id="tuition_calculate" class="ibme-button style-1 mint-button" value="Calculate" />
				<input type="reset" class="ibme-button style-4 mint-button" id="reset">
			</div>
		</fieldset>
		<fieldset class="ibme_calc_form_container ibme_calc_output">
			<div class="ibme_calc_form_container_title header-3">Your Tuition</div>	
			<div class="ibme_calc_form_field">
				<span class="ibme_calc_form_curr_sym">$</span>
				<input type="text" readonly="" id="tuition_fees" placeholder="Your Tuition" />
			</div>
		</fieldset>
	</form>
	<script type="text/javascript">

			jQuery(document).ready(function($) {
				console.dir('ready');

				$('#tuition_calculate').click(function(e){
					e.preventDefault();
					$('.ibme_calc_output').css({
						"visibility": "visible",
						"height": "auto",
						"opacity": "1",
						"transition": "all 0.25s ease-in-out" 
					});
					var annual_income =  $('#annual_family_income').val();
					if(!annual_income){
						$('#annual_family_income').toggleClass('ibmecalcError');
						setTimeout(() => {
							$('#annual_family_income').toggleClass('ibmecalcError');
						}, 2000);
						$('.ibme_calc_output').css({
							"visibility": "hidden",
							"opacity": "0",
							"height": "0",
						});
						return;
					}
					/*
					if( annual_income < 50000 ) {
						tuition_fees = 250;
					} else if ( annual_income < 100000 ) {
						tuition_fees = 750;
					} else if ( annual_income < 200000 ) {
						tuition_fees = 1350;
					} else if ( annual_income < 250000 ) {
						tuition_fees = 2000;
					} else {
						tuition_fees = '<?php echo $max_limit; ?>';
					}*/

					tuition_fees = Math.round(annual_income * .01);

					if (tuition_fees >= '<?php echo $cap; ?>') {
						tuition_fees = '<?php echo $max_limit; ?>';
					} else if (tuition_fees > '<?php echo $max_limit; ?>') {
						tuition_fees = '<?php echo $max_limit; ?>';
					} else if (tuition_fees < '<?php echo $min_limit; ?>') {
						tuition_fees = '<?php echo $min_limit; ?>';
					} else {
						tuition_fees = Math.round(annual_income * .01);
					}
					
					$('#tuition_fees').val(tuition_fees);

				});

				$('#reset').click(function(e){
					$('.ibme_calc_output').css({
						"visibility": "hidden",
						"opacity": "0",
						"height": "0",
					});
				});

			});
		
		
	</script>
	<?php
	return ob_get_clean();
}

// Include forms.php file
require_once get_stylesheet_directory() . '/includes/forms.php';
require_once get_stylesheet_directory() . '/includes/forms2.php';

add_action( 'lander_before', 'ibme_page_content' );

function ibme_page_content() {
	if ( is_page() ) {
		remove_action( 'lander_entry_footer', 'lander_post_footer', 10, 2 );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_google_fonts' );

function enqueue_google_fonts() {
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">', array(), null );
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

function ibme_mobile_nav() {
	wp_nav_menu(
		array(
			'menu'      => 21,
			'menu_id'      => 'menu-primary-items',
			'menu_class'      => 'menu-items mobile-menu-items',
			'container' => 'nav',
			'container_class' => 'menu menu-primary mobile-menu',
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
	<div class="footer-credits">
		<?php
		if ( is_active_sidebar( 'footer-widget-credits' ) ) {
			dynamic_sidebar( 'footer-widget-credits' );  }
		?>
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
	$footer_widget_four  = array(
		'name'          => __( 'Footer Widget Four', 'textdomain' ),
		'id'            => 'footer-widget-four',
		'description'   => __( 'Footer Widget Area (Bottom Left)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_five  = array(
		'name'          => __( 'Footer Widget Five', 'textdomain' ),
		'id'            => 'footer-widget-five',
		'description'   => __( 'Footer Widget Area (Bottom Middle)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_six   = array(
		'name'          => __( 'Footer Widget Six', 'textdomain' ),
		'id'            => 'footer-widget-six',
		'description'   => __( 'Footer Widget Area (Bottom Right)', 'textdomain' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle widget-title">',
		'after_title'   => '</h4>',
	);
	$footer_widget_credits   = array(
		'name'          => __( 'Footer Widget Credits', 'textdomain' ),
		'id'            => 'footer-widget-credits',
		'description'   => __( 'Footer Widget Area (Bottom Credits)', 'textdomain' ),
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
	register_sidebar( $footer_widget_credits );
}

/* Redirect all the pages to homepage; for first review */

// add_action( 'template_redirect', 'ibme_redirect_home' );

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
add_shortcode( 'ibme_current_year', 'ibme_current_year_shortcode' );

function ibme_current_year_shortcode() {
	// Get the current year
	$current_year = date( 'Y' );

	// Return the current year
	return $current_year;
}

// Register the shortcode for button
add_shortcode( 'ibme_button', 'ibme_button_handler' );

// Define the shortcode function
function ibme_button_handler( $atts ) {

	$color_class          = '';
	$button_2_color_class = '';
	$button_html ='';
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'link'                => '',
			'text'                => '',
			'color'               => '',
			'style'               => 'style-1', // style-1, style-3, style-4, style-5
			'type'                => 'single',
			'button-2-link'       => '', // Link for the second button
			'button-2-text'       => '', // Text for the second button
			'button-2-color'      => '', // BG color for the second button
			'button-2-style'      => '', // Style for the second button
			'text-color'          => 'black',
			'button-2-text-color' => 'black',
			'new-tab'             => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no
		),
		$atts,
		'ibme_button'
	);

	// Sanitize attributes
	$link       = esc_url( $atts['link'] );
	$text       = esc_html( $atts['text'] );
	$color      = esc_attr( $atts['color'] ); // possible values: 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavender', 'black', 'white', default set as 'mint'
	$style      = esc_attr( $atts['style'] ); // possible values: 'style-1', 'style-3', 'style-4' and 'style-5', default set as 'style-1'
	$type       = esc_attr( $atts['type'] ); // possible values: 'dual' or 'single', default set as single
	$text_color = esc_attr( $atts['text-color'] ); // possible values: 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavender', 'black', 'white', default set as 'mint'
	$new_tab    = esc_attr( $atts['new-tab'] ); // possible values: 'yes' or 'no', default set as 'no'

	if ( $color == '' ) {
		$color_class = '';
	} else {
		$color_class = $color . '-button ';
	}

	// Check if the link is external
	//$is_external = ( strpos( $link, home_url() ) === false );

	if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {
		// It's not a full URL, treat as internal link
		$is_external = false;
	} else {
		// It's a full URL, now check if it's external
		$is_external = (strpos($link, home_url()) === false);
	}

	// Add the target attribute based on whether it's internal or external
	$target_attribute = $is_external ? 'target="_blank"' : '';

	if ( $new_tab === 'yes' ) {
		$target_attribute = 'target="_blank"';
	}

	if ( ! empty( $link ) ) {
		// Handle "dual" type
		if ( $type === 'dual' ) {
			// Sanitize attributes for the second button
			$button_2_link       = esc_url( $atts['button-2-link'] );
			$button_2_text       = esc_html( $atts['button-2-text'] );
			$button_2_color      = esc_attr( $atts['button-2-color'] );
			$button_2_style      = esc_attr( $atts['button-2-style'] );
			$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
			$button_2_new_tab    = esc_attr( $atts['button-2-new-tab'] );

			if ( $button_2_color == '' ) {
				$button_2_color_class = '';
			} else {
				$button_2_color_class = $button_2_color . '-button ';
			}

			// Check if the button_2_link is external
			//$is_external_2 = ( strpos( $button_2_link, home_url() ) === false );

			if (filter_var($button_2_link, FILTER_VALIDATE_URL) === FALSE) {
				// It's not a full URL, treat as internal link
				$is_external = false;
			} else {
				// It's a full URL, now check if it's external
				$is_external = (strpos($button_2_link, home_url()) === false);
			}

			// Add the target attribute based on whether it's internal or external
			$target_attribute_2 = $is_external_2 ? 'target="_blank"' : '';

			if ( $button_2_new_tab === 'yes' ) {
				$target_attribute_2 = 'target="_blank"';
			}

			// Generate HTML for the dual buttons
			$button_html  = '<div class="inline-buttons">';
			if (!empty($link) && !empty($text)) {
				$button_html .= '<a href="' . $link . '" class="ibme-button ' . $color_class . $style . ' ' . $text_color . '-text" ' . $target_attribute . '>' . $text . '</a>';
			}
			if (!empty($button_2_link) && !empty($button_2_text)) {
				$button_html .= '<a href="' . $button_2_link . '" class="ibme-button ' . $button_2_color_class . $button_2_style . ' ' . $button_2_text_color . '-text" ' . $target_attribute_2 . '>' . $button_2_text . '</a>';
			}
			$button_html .= '</div>';
		} else {
			// Generate HTML for a single button
			if (!empty($link) && !empty($text)) {
				$button_html = '<a href="' . $link . '" class="ibme-button ' . $color_class . $style . ' ' . $text_color . '-text" ' . $target_attribute . '>' . $text . '</a>';
			}
		}
	}

	return $button_html;
}

/**
 * Registering shortcodes for various content blocks
 */


// Register the shortcode for the "statement_1" block

add_shortcode( 'ibme_statement_1', 'ibme_statement_1_handler' );

function ibme_statement_1_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'               => '',
			'text'                => '',
			'text-color'          => 'black', // black, white
			'button-type'         => 'single',
			'button-link'         => '',
			'button-text'         => '',
			'button-color'        => '',
			'button-style'        => 'style-3',
			'button-text-color'   => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
			'button-2-link'       => '',
			'button-2-text'       => '',
			'button-2-color'      => '',
			'button-2-style'      => 'style-4',
			'button-2-text-color' => 'barbie', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, white
			'top-illustration'    => 'none',
			'bottom-illustration' => 'none',
			'large-illustration'  => 'none',
			'new-tab'             => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no
		),
		$atts,
		'ibme_statement_1'
	);

	// Sanitize attributes
	$title               = esc_html( $atts['title'] );
	$text                = esc_html( $atts['text'] );
	$text_color          = esc_attr( $atts['text-color'] );
	$button_type         = esc_attr( $atts['button-type'] );
	$button_link         = esc_url( $atts['button-link'] );
	$button_2_link       = esc_url( $atts['button-2-link'] );
	$button_text         = esc_html( $atts['button-text'] );
	$button_2_text       = esc_html( $atts['button-2-text'] );
	$button_color        = esc_attr( $atts['button-color'] );
	$button_text_color   = esc_attr( $atts['button-text-color'] );
	$button_2_color      = esc_attr( $atts['button-2-color'] );
	$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
	$button_2_style      = esc_attr( $atts['button-2-style'] );
	$button_style        = esc_attr( $atts['button-style'] );
	$top_illustration    = esc_attr( $atts['top-illustration'] );
	$bottom_illustration = esc_attr( $atts['bottom-illustration'] );
	$large_illustration = esc_attr( $atts['large-illustration'] );

	$top_illustration_class    = 'top-illustration ' . $top_illustration;
	$bottom_illustration_class = 'bottom-illustration ' . $bottom_illustration;
	$large_illustration_class = 'large-illustration ' . $large_illustration;

	$new_tab          = esc_attr( $atts['new-tab'] );
	$button_2_new_tab = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the statement_1 block
	$statement_1_html  = '<section class="full-width-section landing-section ' . $text_color . '-text ibme-statement-1 '. $large_illustration_class .'"><div class="inner-wrap ' . $top_illustration_class . '"><div class="landing-section-content ' . $bottom_illustration_class . '">';
	$statement_1_html .= '<h3 class="title">' . $title . '</h3>';
	$statement_1_html .= '<p>' . $text . '</p>';
	$statement_1_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" style="' . $button_style . '" text-color="' . $button_text_color . '" type="' . $button_type . '" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-color="' . $button_2_color . '" button-2-text-color="' . $button_2_text_color . '" button-2-style="' . $button_2_style . '"]' );
	$statement_1_html .= '</div>';
	$statement_1_html .= '</div>';
	$statement_1_html .= '</section>';

	return $statement_1_html;
}

// Register the shortcode for the "cta_1" block

function ibme_cta_1_content_block_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'            => '',
			'text'             => '',
			'image-url'        => '',
			'color'            => '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'button-link'      => '',
			'button-text'      => '',
			'button-2-link'    => '',
			'button-2-text'    => '',
			'new-tab'          => 'no', // yes, no
			'button-2-new-tab' => 'no', // yes, no
		),
		$atts,
		'ibme_cta_1_content_block'
	);

	// Sanitize attributes
	$title            = esc_html( $atts['title'] );
	$text             = esc_html( $atts['text'] );
	$image_url        = esc_url( $atts['image-url'] );
	$color            = esc_attr( $atts['color'] );
	$button_link      = esc_url( $atts['button-link'] );
	$button_2_link    = esc_url( $atts['button-2-link'] );
	$button_text      = esc_html( $atts['button-text'] );
	$button_2_text    = esc_html( $atts['button-2-text'] );
	$new_tab          = esc_attr( $atts['new-tab'] );
	$button_2_new_tab = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the ibme_cta_1_content_block
	$cta_1_content_block_html  = '<div class="ibme-cta_1-content-block ' . $color . '-bg-color">';
	$cta_1_content_block_html .= '<div class="ibme-cta_1-content-block-container">';
	$cta_1_content_block_html .= '<div class="ibme-cta_1-image-content"><img src="' . $image_url . '" alt="' . $title . '" /></div>';
	$cta_1_content_block_html .= '<div class="ibme-cta_1-textual-content-wrap"><div class="ibme-cta_1-textual-content">';
	$cta_1_content_block_html .= '<h2 class="title">' . $title . '</h2>';
	$cta_1_content_block_html .= '<p class="ibme-cta_1-content-description">' . $text . '</p>';
	$cta_1_content_block_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" type="dual" link="' . $button_link . '" text="' . $button_text . '" color="' . $color . '" style="style-1" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-color="' . $color . '" button-2-style="style-4"]' );
	$cta_1_content_block_html .= '</div></div></div></div>';

	return $cta_1_content_block_html;
}

function ibme_cta_1_container_handler( $atts, $content = null ) {
	// Generate HTML for the ibme_cta_1_container
	$cta_1_container_html = '<section class="full-width-section landing-section cta_1-section"><div class="inner-wrap"><div class="landing-section-content"><div class="ibme-cta_1-content-blocks">';

	// Use a regular expression to match [ibme_cta_1_content_block] shortcodes
	preg_match_all( '/\[ibme_cta_1_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER );

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[ibme_cta_1_content_block' . $match[1] . ']' ); // Process content within [ibme_cta_1_content_block]

		// Process and use $params and $content_block_content as needed
		$cta_1_container_html .= $content_block_content;
	}

	$cta_1_container_html .= '</div></div></div></section>';

	return $cta_1_container_html;
}

// Register the container shortcode
add_shortcode( 'ibme_cta_1_container', 'ibme_cta_1_container_handler' );

// Content block shortcode registration as a nested shortcode within the container
add_shortcode( 'ibme_cta_1_content_block', 'ibme_cta_1_content_block_handler' );


// Register the shortcode for the "cta_2" block

function ibme_cta_2_content_block_handler( $atts ) {
	$width                    = '';
	$path                     = '';
	$cta_2_content_block_html = '';
	$title_line_break_markup = '';
	$no_button_class = '';
	$title_formatting_class = '';

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'             => '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar', 'none'
			'illustration'      => '', // cabin, cloud, embrace, eye, face, fire, flower, heart-hug, heart, journal, music, plant, smiles, sun, sunglasses, talking, two-teens, walking, workshop, yoga
			'title'             => '',
			'button-text'       => '',
			'button-link'       => '',
			'button-color'      => '',
			'new-tab'           => 'no', // yes, no
			'button-style'      => 'style-5', // style-1, style-5
			'text-color'        => 'black', // black, white
			'button-text-color' => 'black', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar', 'black'
			'title-line-break'        => 'no',
			'title-formatting'        => 'yes',
		),
		$atts,
		'ibme_cta_2_content_block'
	);

	// Sanitize attributes

	$color             = esc_attr( $atts['color'] );
	$illustration      = esc_attr( $atts['illustration'] );
	$title             = esc_html( $atts['title'] );
	$button_text       = esc_html( $atts['button-text'] );
	$button_link       = esc_url( $atts['button-link'] );
	$button_style      = esc_attr( $atts['button-style'] );
	$text_color        = esc_attr( $atts['text-color'] );
	$button_text_color = esc_attr( $atts['button-text-color'] );
	$button_color      = esc_attr( $atts['button-color'] );
	$title_line_break        = esc_attr( $atts['title-line-break'] );
	$title_formatting        = esc_attr( $atts['title-formatting'] );

	$new_tab = esc_attr( $atts['new-tab'] );

	if ( $text_color == 'black' ) {
		$path = '/assets/img/cta2-illustrations/';
	} else {
		$path = '/assets/img/cta2-illustrations/white/';
	}

	if(empty($button_link)) {
		$no_button_class = 'no-button';
	} else {
		$no_button_class = 'with-button';
	}

	/* Set width for illustration */

	if ( in_array( $illustration, array( 'fire', 'talking', 'yoga', 'smiles', 'music', 'cabin', 'heart-hug' ) ) ) {
		$width = '195';
	} else {
		$width = '175';
	}

	if($title_line_break == 'yes') {
		$title_line_break_markup = '<br>';
	} else {
		$title_line_break_markup = '';
	}

	if($title_formatting == 'no') {
		$title_formatting_class = 'no-lowercase';
	} else {
		$title_formatting_class = 'lowercase';
	}

	// Generate HTML for the cta_2 block

	$cta_2_content_block_html .= '<div class="cta_2-item ' . $color . '-bg-color ' . $text_color . '-text '.$no_button_class.'">';
	$cta_2_content_block_html .= '<p><img class="aligncenter" src="' . get_stylesheet_directory_uri() . $path . $illustration . '.svg" alt="' . $title . '" width="' . $width . '" height="155" /></p>';
	$cta_2_content_block_html .= '<h3 class="header-3 '.$title_formatting_class.'">' . $title . '</h3>' .$title_line_break_markup;
	$cta_2_content_block_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" color="' . $button_color . '" link="' . $button_link . '" text="' . $button_text . '" style="' . $button_style . '" text-color="' . $button_text_color . '"]' );
	$cta_2_content_block_html .= '</div>';

	return $cta_2_content_block_html;

}

function ibme_cta_2_container_handler( $atts, $content = null ) {
	// Use a regular expression to match [ibme_cta_2_content_block] shortcodes
	preg_match_all( '/\[ibme_cta_2_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER );

	$class = 'cta-items-' . count( $matches );

	// Generate HTML for the ibme_cta_2_container
	$cta_2_container_html = '<section class="full-width-section landing-section cta_2_section"><div class="inner-wrap"><div class="landing-section-content"><div class="cta_2-items ' . $class . '">';

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[ibme_cta_2_content_block' . $match[1] . ']' ); // Process content within [ibme_cta_2_content_block]

		// Process and use $params and $content_block_content as needed
		$cta_2_container_html .= $content_block_content;
	}

	$cta_2_container_html .= '</div></div></div></section>';

	return $cta_2_container_html;
}

// Register the container shortcode
add_shortcode( 'ibme_cta_2_container', 'ibme_cta_2_container_handler' );

// Content block shortcode registration as a nested shortcode within the container
add_shortcode( 'ibme_cta_2_content_block', 'ibme_cta_2_content_block_handler' );

// Register the shortcode for the "testimonial" block

function ibme_testimonial_block_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'                => '', // ocean, forest, teal, white
			'image-url'            => '',
			'testimonial'          => '',
			'testimonial-by'       => '',
			'testimonial-by-color' => 'black', // black, white
		),
		$atts,
		'ibme_testimonial_block_handler'
	);

	// Sanitize attributes
	$color                = esc_attr( $atts['color'] );
	$image_url            = esc_url( $atts['image-url'] );
	$testimonial          = esc_html( $atts['testimonial'] );
	$testimonial_by       = esc_html( $atts['testimonial-by'] );
	$testimonial_by_color = esc_attr( $atts['testimonial-by-color'] );

	// Generate HTML for the ibme_testimonial_block

	$testimonial_block_html  = '<div class="ibme-testimonial-wrap ' . $color . '-testimonial">';
	$testimonial_block_html .= '<div class="ibme-testimonial-image-wrap"><img src="' . $image_url . '" alt="Testimonial by ' . $testimonial_by . '" width="556" height="550" /></div>';
	$testimonial_block_html .= '<div class="testimonial-content-wrap"><p class="header-2">' . $testimonial . '</p>';
	$testimonial_block_html .= '<p class="testimonial-by ' . $testimonial_by_color . '-text">' . $testimonial_by . '</p>';
	$testimonial_block_html .= '</div></div>';

	return $testimonial_block_html;

}

function ibme_testimonials_container_handler( $atts, $content = null ) {
	// Generate HTML for the ibme_testimonials_container
	$testimonials_container_html = '<section class="full-width-section landing-section ibme-testimonial-section"><div class="inner-wrap"><div class="landing-section-content"><div class="ibme-testimonials-slider">';

	// Use a regular expression to match [ibme_testimonial_block] shortcodes
	preg_match_all( '/\[ibme_testimonial_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER );

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[ibme_testimonial_block' . $match[1] . ']' ); // Process content within [ibme_testimonial_block]

		// Process and use $params and $content_block_content as needed
		$testimonials_container_html .= $content_block_content;
	}

	$testimonials_container_html .= '</div></div></div></section>';

	return $testimonials_container_html;
}

// Register the container shortcode for testimonials
add_shortcode( 'ibme_testimonials_container', 'ibme_testimonials_container_handler' );

// Testimonial block shortcode registration as a nested shortcode within the container
add_shortcode( 'ibme_testimonial_block', 'ibme_testimonial_block_handler' );


// Register the shortcode for the "ibme_upcoming_events" block (parent block) and "ibme_upcoming_event" block (child block)

add_shortcode( 'ibme_upcoming_events', 'ibme_upcoming_events_handler' );

function ibme_upcoming_events_handler( $atts, $content = null ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'         => '',
			'title'             => '',
			'new-tab'           => 'no', // yes, no
			'button-text'       => '',
			'button-link'       => '',
			'button-color'      => 'white',
			'button-text-color' => 'black', // black, cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender
		),
		$atts,
		'ibme_upcoming_events'
	);

	// Sanitize attributes
	$image_url         = esc_url( $atts['image-url'] );
	$title             = esc_html( $atts['title'] );
	$button_text       = esc_html( $atts['button-text'] );
	$button_link       = esc_url( $atts['button-link'] );
	$button_text_color = esc_attr( $atts['button-text-color'] );
	$button_color      = esc_attr( $atts['button-color'] );
	$new_tab           = esc_attr( $atts['new-tab'] );

	// Generate HTML for the ibme_upcoming_events block
	$upcoming_events_html  = '<section class="full-width-section landing-section upcoming-events-section" style="background-image: url(\'' . $image_url . '\')"><div class="inner-wrap"><div class="landing-section-content">';
	$upcoming_events_html .= '<div class="headline-column content-column"><h2 class="headline-title title">' . $title . '</h2>';
	$upcoming_events_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" color="' . $button_color . '" text-color="' . $button_text_color . '" link="' . $button_link . '" text="' . $button_text . '" style="style-1"]' );
	$upcoming_events_html .= '</div>';
	$upcoming_events_html .= '<div class="upcoming-events-list content-column">';

	preg_match_all( '/\[ibme_upcoming_event(.*?)\]/s', $content, $matches, PREG_SET_ORDER );

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                    = shortcode_parse_atts( $match[1] ); // Parse parameters
		$ibme_upcoming_event_block = do_shortcode( '[ibme_upcoming_event' . $match[1] . ']' ); // Process content within [ibme_upcoming_event]

		// Process and use $params and $content_block_content as needed
		$upcoming_events_html .= $ibme_upcoming_event_block;
	}

	$upcoming_events_html .= '</div></div></div></section>';

	return $upcoming_events_html;
}

add_shortcode( 'ibme_upcoming_event', 'ibme_upcoming_event_handler' );

function ibme_upcoming_event_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'            => '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'date-time'        => '',
			'event-name'       => '',
			'event-location'   => '',
			'button-link'      => '',
			'button-text'      => '',
			'button-2-link'    => '',
			'button-2-text'    => '',
			'new-tab'          => 'no', // yes, no
			'button-2-new-tab' => 'no', // yes, no
		),
		$atts,
		'ibme_upcoming_event'
	);

	// Sanitize attributes
	$color          = esc_attr( $atts['color'] );
	$date_time      = wp_kses_post( $atts['date-time'] );
	$event_name     = esc_html( $atts['event-name'] );
	$event_location = esc_html( $atts['event-location'] );
	$button_link    = esc_url( $atts['button-link'] );
	$button_text    = esc_html( $atts['button-text'] );
	$button_2_link  = esc_url( $atts['button-2-link'] );
	$button_2_text  = esc_html( $atts['button-2-text'] );

	$new_tab          = esc_attr( $atts['new-tab'] );
	$button_2_new_tab = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the ibme_upcoming_event block

	$upcoming_event_html  = '<div class="upcoming-event-item ' . $color . '-color">';
	$upcoming_event_html .= '<div class="upcoming-event-date">';
	$upcoming_event_html .= '<p class="header-4">' . $date_time . '</p>';
	$upcoming_event_html .= '</div>';
	$upcoming_event_html .= '<div class="upcoming-event-title-location">';
	$upcoming_event_html .= '<h4 class="header-3">' . $event_name . '</h4>';
	$upcoming_event_html .= '<p class="upcoming-event-location">' . $event_location . '</p>';
	$upcoming_event_html .= '</div><div class="upcoming-event-links">';
	$upcoming_event_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" color="' . $color . '" link="' . $button_link . '" text="' . $button_text . '" style="style-1"]' );
	$upcoming_event_html .= do_shortcode( '[ibme_button new-tab="' . $button_2_new_tab . '" color="' . $color . '" link="' . $button_2_link . '" text="' . $button_2_text . '" style="style-4"]' );
	$upcoming_event_html .= '</div></div>';

	return $upcoming_event_html;

}


// Register the shortcode for the "cta_3" block

function ibme_cta_3_content_block_handler( $atts ) {

	$text_line_break_markup = '';
	$title_line_break_markup = '';
	$title_formatting_class = '';
	$text_formatting_class = '';

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'color'             => '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar', 'none'
			'title'             => '',
			'text'              => '',
			'image-url'         => '',
			'button-text'       => '',
			'button-link'       => '',
			'button-color'      => '',
			'button-style'      => 'style-5', // style-5, style-1
			'text-color'        => 'black', // black, white
			'button-text-color' => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
			'new-tab'           => 'no', // yes, no
			'text-line-break'        => 'no',
			'title-line-break'        => 'no',
			'title-formatting'        => 'yes',
			'text-formatting'        => 'yes',
		),
		$atts,
		'ibme_cta_3_content_block'
	);

	$allowed_tags = array(
		'br' => array() // Allow <br> tags without any attributes
	);

	// Sanitize attributes

	$color             = esc_attr( $atts['color'] );
	$title			   = wp_kses($atts['title'], $allowed_tags);
	$text              = esc_html( $atts['text'] );
	$image_url         = esc_url( $atts['image-url'] );
	$button_text       = esc_html( $atts['button-text'] );
	$button_link       = esc_url( $atts['button-link'] );
	$button_style      = esc_attr( $atts['button-style'] );
	$text_color        = esc_attr( $atts['text-color'] );
	$button_text_color = esc_attr( $atts['button-text-color'] );
	$button_color      = esc_attr( $atts['button-color'] );
	$new_tab           = esc_attr( $atts['new-tab'] );
	$text_line_break        = esc_attr( $atts['text-line-break'] );
	$title_line_break        = esc_attr( $atts['title-line-break'] );
	$title_formatting        = esc_attr( $atts['title-formatting'] );
	$text_formatting        = esc_attr( $atts['text-formatting'] );

	if($title_formatting == 'no') {
		$title_formatting_class = 'no-lowercase';
	} else {
		$title_formatting_class = 'lowercase';
	}

	if($text_formatting == 'no') {
		$text_formatting_class = 'no-lowercase';
	} else {
		$text_formatting_class = 'lowercase';
	}


	if($text_line_break == 'yes') {
		$text_line_break_markup = '<br>';
	} else {
		$text_line_break_markup = '';
	}

	if($title_line_break == 'yes') {
		$title_line_break_markup = '<br>';
	} else {
		$title_line_break_markup = '';
	}

	// Generate HTML for the cta_3 block

	$cta_3_content_block_html  = '<div class="cta-3_column ' . $color . '-bg-color"><img class="aligncenter" src="' . $image_url . '" alt="' . $title . '" />';
	$cta_3_content_block_html .= '<div class="cta-3_column-content">';
	$cta_3_content_block_html .= '<h3 class="header-3 ' . $title_formatting_class . ' ' . $text_color . '-text">' . $title . '</h3>' .$title_line_break_markup;
	$cta_3_content_block_html .= '<p class="cta-3_column-text ' . $text_formatting_class . ' ' . $text_color . '-text">' . $text . '</p>' . $text_line_break_markup;
	$cta_3_content_block_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" color="' . $button_color . '" text-color="' . $button_text_color . '" link="' . $button_link . '" text="' . $button_text . '" style="' . $button_style . '"]' );
	$cta_3_content_block_html .= '</div></div>';

	return $cta_3_content_block_html;
}

function ibme_cta_3_content_blocks_handler( $atts, $content = null ) {

	$atts = shortcode_atts(
		array(
			'display-as'             => 'default', //default, fourths, thirds
		),
		$atts,
		'ibme_cta_3_content_blocks'
	);

	$display_as = esc_attr( $atts['display-as'] );


	// Use a regular expression to match [ibme_cta_3_content_block] shortcodes
	preg_match_all( '/\[ibme_cta_3_content_block(.*?)\]/s', $content, $matches, PREG_SET_ORDER );
	$class = 'cta-items-' . count( $matches );

	// Generate HTML for the ibme_cta_3_content_blocks
	$cta_3_content_blocks_html = '<div class="cta-3_columns content-column ' . $class . ' '.$display_as.'-display">';

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[ibme_cta_3_content_block' . $match[1] . ']' ); // Process content within [ibme_cta_3_content_block]

		// Process and use $params and $content_block_content as needed
		$cta_3_content_blocks_html .= $content_block_content;
	}

	$cta_3_content_blocks_html .= '</div>';

	return $cta_3_content_blocks_html;
}

// Register the container shortcode
add_shortcode( 'ibme_cta_3_content_blocks', 'ibme_cta_3_content_blocks_handler' );

// Content block shortcode registration as a nested shortcode within the container
add_shortcode( 'ibme_cta_3_content_block', 'ibme_cta_3_content_block_handler' );

// Register the shortcode for the "ibme_subscribe_block" block

add_shortcode( 'ibme_subscribe_block', 'ibme_subscribe_block_handler' );

function ibme_subscribe_block_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title' => '',
			'title-color' => 'black', //black, white
			'field-color' => 'black', //black, white
			'line-color' => 'sunflower', 
			'link' => 'https://inwardboundmind.org/confirmation/mailing-list/'
		),
		$atts,
		'ibme_subscribe_block'
	);

	// Sanitize attributes
	$title = esc_html( $atts['title'] );
	$title_color = esc_attr( $atts['title-color'] );
	$link = $atts['link'];
	$field_color = $atts['field-color'];
	$line_color = $atts['line-color'];

	// Generate HTML for the ibme_subscribe_block block

	$subscribe_block_html  = '<div class="subscribe-block content-column">';
	$subscribe_block_html .= '<h2 class="title '.$title_color.'-title">' . $title . '</h2>';
	$subscribe_block_html .= do_shortcode( '[subscribe-form field-color="'.$field_color.'" line-color="'.$line_color.'" link="'.$link.'"]' );
	$subscribe_block_html .= '</div>';

	return $subscribe_block_html;

}

// Register the shortcode for the "ibme_cta_3_subscribe_container" container

add_shortcode( 'ibme_cta_3_subscribe_container', 'ibme_cta_3_subscribe_container_handler' );

function ibme_cta_3_subscribe_container_handler( $atts, $content = null ) {

	// Use output buffering to capture the content within the shortcode
	ob_start();
	?>
	<section class="full-width-section landing-section ibme_cta-3_subscribe_block">
		<div class="inner-wrap">
			<div class="landing-section-content">
				<?php echo do_shortcode( $content ); // Output the content within the shortcode ?>
			</div>
		</div>
	</section>
	<?php

	// Return the buffered content
	return ob_get_clean();
}

// Register the shortcode for the "hero_1_photo" block

add_shortcode( 'hero_1_photo', 'hero_1_photo_handler' );

function hero_1_photo_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'           => '', // jpg, png, gif
			'title'               => '',
			'title-color'         => '', // white, black
			'button-color'        => '',
			'button-text'         => '',
			'button-2-text'       => '',
			'button-link'         => '',
			'button-2-link'       => '',
			'new-tab'             => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no
			'button-2-text-color' => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
		),
		$atts,
		'hero_1_photo'
	);

	// Sanitize attributes
	$image_url           = esc_url( $atts['image-url'] );
	$title               = esc_html( $atts['title'] );
	$title_color         = esc_attr( $atts['title-color'] );
	$button_color        = esc_attr( $atts['button-color'] );
	$button_text         = esc_html( $atts['button-text'] );
	$button_2_text       = esc_html( $atts['button-2-text'] );
	$button_link         = esc_url( $atts['button-link'] );
	$button_2_link       = esc_url( $atts['button-2-link'] );
	$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
	$new_tab             = esc_attr( $atts['new-tab'] );
	$button_2_new_tab    = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the hero_1_photo block

	$hero_1_photo_html  = '<section class="full-width-section landing-section hero_1_photo-section" style="background-image: url(\'' . $image_url . '\')"><div class="inner-wrap"><div class="landing-section-content">';
	$hero_1_photo_html .= '<h2 class="title ' . $title_color . '-title">' . $title . '</h2>';
	$hero_1_photo_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" type="dual" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" style="style-1" button-2-color="white" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-style="style-1" button-2-text-color="' . $button_2_text_color . '"]' );
	$hero_1_photo_html .= '</div></div></section>';

	return $hero_1_photo_html;
}

add_action( 'wp_footer', 'hero_1_slider_script' );

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
			}, 4000);

			// Pause on hover
			document.querySelector('.hero_1-slider').addEventListener('mouseover', function() {
				clearInterval(slideInterval);
			});

			// Resume on mouse leave
			document.querySelector('.hero_1-slider').addEventListener('mouseout', function() {
				slideInterval = setInterval(function() {
					plusSlides(1);
				}, 4000);
			});
		}
	</script>
	<?php
}


// Register the shortcode for the "hero_1_slider" block

add_shortcode( 'hero_1_slider', 'hero_1_slider_handler' );

function hero_1_slider_handler( $atts, $content = null ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'               => '',
			'title-color'         => '', // white, black
			'button-color'        => '',
			'button-2-color'      => 'white',
			'button-text'         => '',
			'button-2-text'       => '',
			'button-link'         => '',
			'button-2-link'       => '',
			'button-2-text-color' => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
			'new-tab'             => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no
		),
		$atts,
		'hero_1_slider'
	);

	// Sanitize attributes
	$title               = esc_html( $atts['title'] );
	$title_color         = esc_attr( $atts['title-color'] );
	$button_color        = esc_attr( $atts['button-color'] );
	$button_text         = esc_html( $atts['button-text'] );
	$button_2_text       = esc_html( $atts['button-2-text'] );
	$button_link         = esc_url( $atts['button-link'] );
	$button_2_link       = esc_url( $atts['button-2-link'] );
	$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
	$button_2_color      = esc_attr( $atts['button-2-color'] );
	$new_tab             = esc_attr( $atts['new-tab'] );
	$button_2_new_tab    = esc_attr( $atts['button-2-new-tab'] );

	// Use a regular expression to match [hero_1_slide] shortcodes
	preg_match_all( '/\[hero_1_slide(.*?)\]/s', $content, $matches, PREG_SET_ORDER );
	$slide_count = count( $matches );

	// Generate HTML for the hero_1_slider block

	$hero_1_slider_html = '<section class="full-width-section landing-section hero_1-slider-section"><div class="hero_1-slider"><div class="hero_1-slides">';

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[hero_1_slide' . $match[1] . ']' ); // Process content within [hero_1_slide]

		// Process and use $params and $content_block_content as needed
		$hero_1_slider_html .= $content_block_content;
	}

	$hero_1_slider_html .= '</div>';
	$hero_1_slider_html .= '<div class="inner-wrap">';
	$hero_1_slider_html .= '<div class="landing-section-content">';
	$hero_1_slider_html .= '<div class="hero_1-slider-content">';
	$hero_1_slider_html .= '<h2 class="title ' . $title_color . '-title">' . $title . '</h2>';
	$hero_1_slider_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" type="dual" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" style="style-1" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-style="style-1" button-2-color="' . $button_2_color . '" button-2-text-color="' . $button_2_text_color . '"]' );
	$hero_1_slider_html .= '</div>';
	$hero_1_slider_html .= '<div class="hero_1-navigation-dots ' . $button_color . '-dots">';

	// Loop for generating navigation dots
	for ( $i = 1; $i <= $slide_count; $i++ ) {
		$hero_1_slider_html .= '<span class="hero_1-dot" onclick="currentSlide(' . $i . ')"></span>';
	}

	$hero_1_slider_html .= '</div></div></div></div></section>';

	return $hero_1_slider_html;
}

// Register the shortcode for the "hero_1_slide" block

add_shortcode( 'hero_1_slide', 'hero_1_slide_handler' );

function hero_1_slide_handler( $atts ) {

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url' => '',
		),
		$atts,
		'hero_1_slide'
	);

	// Sanitize attributes

	$image_url = esc_url( $atts['image-url'] );

	// Generate HTML for the hero_1_slide block

	$hero_1_slide_html = '<div class="hero_1-slide" style="background-image: url(\'' . $image_url . '\')"></div>';

	return $hero_1_slide_html;
}

// Register the shortcode for the "impact_1_slider" block

add_shortcode( 'impact_1_slider', 'impact_1_slider_handler' );

function impact_1_slider_handler( $atts, $content = null ) {

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'slide-color'  => '',
			'dot-color'    => 'black', // black, white
			'top-illustration'    => 'none',
			'bottom-illustration' => 'none',
			'large-illustration'  => 'none',
		),
		$atts,
		'impact_1_slider'
	);

	// Sanitize attributes

	$slide_color  = esc_attr( $atts['slide-color'] );
	$dot_color    = esc_attr( $atts['dot-color'] );
	$top_illustration    = esc_attr( $atts['top-illustration'] );
	$bottom_illustration = esc_attr( $atts['bottom-illustration'] );
	$large_illustration = esc_attr( $atts['large-illustration'] );

	$top_illustration_class    = 'top-illustration ' . $top_illustration;
	$bottom_illustration_class = 'bottom-illustration ' . $bottom_illustration;
	$large_illustration_class = 'large-illustration ' . $large_illustration;


	// Generate HTML for the impact_1_slider
	$impact_1_slider_html = '<section class="full-width-section landing-section impact-section impact_1-section ' . $large_illustration_class . '"><div class="inner-wrap ' . $top_illustration_class . '"><div class="landing-section-content ' . $bottom_illustration_class . '"><div class="impact_1-slider ' . $slide_color . '-slider"><div class="impact_1-slides">';

	// Use a regular expression to match [impact_1_slide] shortcodes
	preg_match_all( '/\[impact_1_slide(.*?)\]/s', $content, $matches, PREG_SET_ORDER );
	$slide_count = count( $matches );

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[impact_1_slide' . $match[1] . ']' ); // Process content within [impact_1_slide]

		// Process and use $params and $content_block_content as needed
		$impact_1_slider_html .= $content_block_content;
	}

	$impact_1_slider_html .= '</div>';
	$impact_1_slider_html .= '<div class="impact_1-navigation-dots ' . $dot_color . '-dots">';

	// Loop for generating navigation dots
	for ( $i = 1; $i <= $slide_count; $i++ ) {
		$impact_1_slider_html .= '<span class="impact_1-dot impact-dot" onclick="currentImpactSlide(' . $i . ')"></span>';
	}

	$impact_1_slider_html .= '</div></div></div></div></section>';

	return $impact_1_slider_html;
}

add_shortcode( 'impact_1_slide', 'impact_1_slide_handler' );

function impact_1_slide_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'title'               => '',
			'title-color'         => 'black', // black, white
			'headline'            => '',
			'headline-color'      => 'slider-color', // black, white
			'text'                => '',
			'text-color'          => 'black', // black, white
			'button-type'         => '',
			'button-text'         => '',
			'button-color'        => '',
			'button-text-color'   => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
			'button-link'         => '',
			'button-2-text'       => '',
			'button-2-color'      => '',
			'button-2-link'       => '',
			'button-2-text-color' => 'barbie', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, white
			'button-style'        => 'style-3', // style-3, style-1
			'button-2-style'      => 'style-4',
			'new-tab'             => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no

		),
		$atts,
		'impact_1_slide'
	);

	// Sanitize attributes
	$title               = esc_html( $atts['title'] );
	$title_color         = esc_attr( $atts['title-color'] );
	$headline            = esc_html( $atts['headline'] );
	$headline_color      = esc_attr( $atts['headline-color'] );
	$text                = esc_html( $atts['text'] );
	$text_color          = esc_attr( $atts['text-color'] );
	$button_type         = esc_attr( $atts['button-type'] );
	$button_text         = esc_html( $atts['button-text'] );
	$button_color        = esc_attr( $atts['button-color'] );
	$button_link         = esc_url( $atts['button-link'] );
	$button_2_text       = esc_html( $atts['button-2-text'] );
	$button_2_color      = esc_attr( $atts['button-2-color'] );
	$button_2_link       = esc_url( $atts['button-2-link'] );
	$button_style        = esc_attr( $atts['button-style'] );
	$button_2_style      = esc_attr( $atts['button-2-style'] );
	$button_text_color   = esc_attr( $atts['button-text-color'] );
	$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
	$new_tab             = esc_attr( $atts['new-tab'] );
	$button_2_new_tab    = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the impact_1_slide block

	$impact_1_slide_html  = '<div class="impact_1-slide">';
	$impact_1_slide_html .= '<div class="left-column content-column">';
	$impact_1_slide_html .= '<h2 class="title ' . $title_color . '-title">' . $title . '</h2>';
	$impact_1_slide_html .= '</div>';
	$impact_1_slide_html .= '<div class="right-column content-column"><h3 class="' . $headline_color . ' header-1">' . $headline . '</h3>';
	$impact_1_slide_html .= '<p class="' . $text_color . '-text">' . $text . '</p>';
	$impact_1_slide_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" type="' . $button_type . '" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" text-color="' . $button_text_color . '" style="' . $button_style . '" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-color="' . $button_2_color . '" button-2-text-color="' . $button_2_text_color . '" button-2-style="' . $button_2_style . '"]' );
	$impact_1_slide_html .= '</div></div>';

	return $impact_1_slide_html;

}

/** Script for impact_1_slider */

add_action( 'wp_footer', 'impact_1_slider_script' );

/*
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
} */

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

			// Clone the first slide
			const firstSlide = slides[0];
			const cloneFirstSlide = firstSlide.cloneNode(true);
			sliderContainer.appendChild(cloneFirstSlide);

			function updateSlidePosition() {
				if (currentIndex > totalSlides) { // If we are on the cloned slide
					currentIndex = 0; // Reset to actual first slide
					sliderContainer.style.transition = 'none'; // Disable transition for instant reset
					sliderContainer.style.transform = 'translateX(0%)'; // Reset position instantly
					setTimeout(() => {
						sliderContainer.style.transition = 'transform 0.5s ease'; // Re-enable transitions
					});
				} else {
					sliderContainer.style.transform = 'translateX(' + (-100 * currentIndex) + '%)';
				}
				dots.forEach((dot, index) => {
					dot.classList.remove('active');
					const effectiveIndex = currentIndex % totalSlides;
					if (index === effectiveIndex) {
						dot.classList.add('active');
					}
				});
			}

			function nextSlide() {
				currentIndex++;
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

			// Pause slider on hover
			sliderElement.addEventListener('mouseenter', function() {
				clearInterval(slideInterval);
			});

			// Resume slider on mouse leave
			sliderElement.addEventListener('mouseleave', function() {
				resetInterval();
			});

			window.currentImpactSlide = currentImpactSlide;
		});
	</script>	
	<?php
}


// Register the shortcode for the "hero_2" block

add_shortcode( 'hero_2', 'hero_2_handler' );

function hero_2_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'        => '', // jpg, png, gif
			'title'            => '',
			'text'             => '',
			'text-color'       => '', // white, black
			'button-color'     => '',
			'button-2-color'   => '',
			'button-text'      => '',
			'button-2-text'    => '',
			'button-link'      => '',
			'button-2-link'    => '',
			'new-tab'          => 'no', // yes, no
			'button-2-new-tab' => 'no', // yes, no
			'orientation'      => 'left-image', // left-image, right-image
			'button-style'        => 'style-3', 
			'button-2-style'      => 'style-4',
		),
		$atts,
		'hero_2'
	);

	// Sanitize attributes
	$image_url        = esc_url( $atts['image-url'] );
	$title            = esc_html( $atts['title'] );
	$text             = esc_html( $atts['text'] );
	$text_color       = esc_attr( $atts['text-color'] );
	$button_color     = esc_attr( $atts['button-color'] );
	$button_2_color   = esc_attr( $atts['button-2-color'] );
	$button_text      = esc_html( $atts['button-text'] );
	$button_2_text    = esc_html( $atts['button-2-text'] );
	$button_link      = esc_url( $atts['button-link'] );
	$button_2_link    = esc_url( $atts['button-2-link'] );
	$new_tab          = esc_attr( $atts['new-tab'] );
	$button_2_new_tab = esc_attr( $atts['button-2-new-tab'] );
	$orientation      = esc_attr( $atts['orientation'] );
	$button_style        = esc_attr( $atts['button-style'] );
	$button_2_style      = esc_attr( $atts['button-2-style'] );

	// Generate HTML for the hero_2 block

	$hero_2_html  = '<section class="full-width-section landing-section hero_2-section"><div class="inner-wrap"><div class="landing-section-content ' . $orientation . '">';
	$hero_2_html .= '<div class="textual-content">';
	$hero_2_html .= '<h2 class="title ' . $button_color . '-title">' . $title . '</h2>';
	$hero_2_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" type="dual" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" style="' . $button_style . '" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-style="' . $button_2_style . '" button-2-color="' . $button_2_color . '"]' );
	$hero_2_html .= '<p class="description ' . $text_color . '-text">' . $text . '</p></div>';
	$hero_2_html .= '<div class="image-content"><img src="' . $image_url . '" alt="' . $title . '" /></div>';
	$hero_2_html .= '</div></div></section>';

	return $hero_2_html;
}

/* Shortcode for Collapsible Content (carried forward from old site) */

add_shortcode( 'collapsible-content', 'collapsible_content' );

function collapsible_content( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'caption'    => 'Parent Collapsible Block',
			'state'      => 'close',
			'id'         => '',
			'class'      => '',
			'text-color' => 'black', // black, white
			'sign-color' => 'black', // black, white
			'outline'    => 'blush', // all the colors in the palette except black
		),
		$atts
	);

	// Sanitize input
	$caption    = esc_html( $atts['caption'] );
	$id         = ( $atts['id'] != '' ) ? ' id="' . esc_attr( $atts['id'] ) . '"' : '';
	$class      = ( $atts['class'] != '' ) ? esc_attr( $atts['class'] ) : '';
	$text_color = esc_attr( $atts['text-color'] );
	$sign_color = esc_attr( $atts['sign-color'] );
	$outline    = esc_attr( $atts['outline'] );

	// Determine classes based on the state
	$divClass = ( $atts['state'] == 'close' ) ? 'collapsible-content' : 'collapsible-content open';
	$hClass   = ( $atts['state'] == 'close' ) ? 'collapsible-heading' : 'collapsible-heading open';

	// Generate output
	$output = '<div class="collapsible-content-wrapper ' . $outline . '-outline ' . $text_color . '-text ' . $sign_color . '-sign"><h3 class="' . $hClass . '"><a>' . $caption . '</a></h3><div' . $id . ' class="' . $divClass . ' ' . $class . '" style="display: none;"><div class="collapsed-content">' . do_shortcode( $content ) . '</div></div></div>';

	return $output;
}

add_action( 'wp_head', 'ibme_jquery' );

function ibme_jquery() {
	?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<?php
}

/* Script for Collapsible Content */

add_action( 'wp_footer', 'ibme_collapsible_content' );

function ibme_collapsible_content() {
	?>

	<script type="text/javascript">
		var $j = jQuery.noConflict();
		
		// Collapsible Content
		$j(document).ready(function() {
			
			/* Collasible divs */
			$j('.collapsible-heading.open').addClass('opened');
			$j('.collapsible-content.open').css('display','block');
				
			$j('.collapsible-heading').on('click',function(event){
				var cc = $j(this).next();
				// If the title is clicked and the collapsible content is not currently animated,
				// start an animation with the slideToggle() method.				
				$j('.collapsible-heading.opened').next().slideToggle();	//show/hide  collapsible content inside collapsible-heading.opened
				$j('.collapsible-heading.opened').toggleClass('opened');	//remove class opened

				if(!cc.is(':animated')){
					cc.slideToggle();
					$j(this).toggleClass('opened');	 
				}
			});
		});
	</script>
	<?php
}

// Register shortcode for statement_2 block

add_shortcode( 'ibme_statement_2', 'ibme_statement_2_handler' );

function ibme_statement_2_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'orientation'       => '', // 'center', 'left', 'right
			'title'             => '',
			'title-color'       => '', // black, white
			'text'              => '',
			'text-color'        => '', // black, white
			'button-type'         => 'single',
			'bg-color'          => '', // 'cherry', 'poppy', 'blush', 'barbie', 'peony', 'violet', 'tangerine', 'marigold', 'sunflower', 'forest', 'teal', 'mint', 'ocean', 'sky', 'bluejay', 'lavendar'
			'button-text'       => '',
			'button-link'       => '',
			'button-color'      => 'white',
			'button-style'      => '', // style-5, style-1
			'button-text-color' => '', // black, cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender
			'button-2-link'       => '',
			'button-2-text'       => '',
			'button-2-color'      => '',
			'button-2-style'      => '',
			'button-2-text-color' => '',
			'new-tab'           => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no
		),
		$atts,
		'ibme_statement_2'
	);

	$allowed_tags = array(
		'br' => array() // Allow <br> tags without any attributes
	);

	// Sanitize attributes
	$orientation       = esc_attr( $atts['orientation'] );
	$title             = esc_html( $atts['title'] );
	$title_color       = esc_attr( $atts['title-color'] );
	$text 			   = wp_kses($atts['text'], $allowed_tags);
	$text_color        = esc_attr( $atts['text-color'] );
	$bg_color          = esc_attr( $atts['bg-color'] );
	$button_type         = esc_attr( $atts['button-type'] );
	$button_text       = esc_html( $atts['button-text'] );
	$button_link       = esc_url( $atts['button-link'] );
	$button_style      = esc_attr( $atts['button-style'] );
	$button_text_color = esc_attr( $atts['button-text-color'] );
	$button_color      = esc_attr( $atts['button-color'] );
	$button_2_link       = esc_html( $atts['button-2-link'] );
	$button_2_text       = esc_html( $atts['button-2-text'] );
	$button_2_color      = esc_attr( $atts['button-2-color'] );
	$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
	$button_2_style      = esc_attr( $atts['button-2-style'] );
	$new_tab           = esc_attr( $atts['new-tab'] );
	$button_2_new_tab = esc_attr( $atts['button-2-new-tab'] );

	/*if ( $button_text ) {
		$button_html = do_shortcode( '[ibme_button new-tab="' . $new_tab . '" color="' . $button_color . '" link="' . $button_link . '" text="' . $button_text . '" style="' . $button_style . '" text-color="' . $button_text_color . '"]' );
	} else {
		$button_html = '';
	}*/

	// Generate HTML for the ibme_statement_2 block

	$statement_2_html  = '<section class="full-width-section landing-section ' . $bg_color . '-background ibme-statement-2 ' . $orientation . '-layout"><div class="inner-wrap"><div class="landing-section-content">';
	$statement_2_html .= '<div class="ibme-statement-2-column title-column"><h3 class="header-2 ' . $title_color . '-title">' . $title . '</h3></div>';
	$statement_2_html .= '<div class="ibme-statement-2-column text-column"><p class="ibme-statement-2-text ' . $text_color . '-text">' . $text . '</p>';
	$statement_2_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" style="' . $button_style . '" text-color="' . $button_text_color . '" type="' . $button_type . '" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-color="' . $button_2_color . '" button-2-text-color="' . $button_2_text_color . '" button-2-style="' . $button_2_style . '"]' );
	$statement_2_html .= '</div>';
	$statement_2_html .= '</div>';
	$statement_2_html .= '</div>';
	$statement_2_html .= '</section>';

	return $statement_2_html;

}

// Register the shortcode for the "impact_2_slider" block

add_shortcode( 'impact_2_slider', 'impact_2_slider_handler' );

function impact_2_slider_handler( $atts, $content = null ) {

	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'slide-color'  => '',
			'dot-color'    => 'black', // black, white
			'illustration' => 'no-illustration',
			'title'        => '',
			'title-color'  => 'black', // black, white
		),
		$atts,
		'impact_2_slider'
	);

	// Sanitize attributes

	$slide_color  = esc_attr( $atts['slide-color'] );
	$dot_color    = esc_attr( $atts['dot-color'] );
	$illustration = esc_attr( $atts['illustration'] );
	$title        = esc_html( $atts['title'] );
	$title_color  = esc_attr( $atts['title-color'] );

	// Generate HTML for the impact_2_slider
	$impact_2_slider_html = '<section class="full-width-section landing-section impact-section impact_2-section ' . $illustration . '"><div class="inner-wrap"><div class="landing-section-content"><div class="impact_2-content"><div class="left-column content-column"><h2 class="title ' . $title_color . '-title">' . $title . '</h2></div><div class="right-column content-column"><div class="impact_2-slider ' . $slide_color . '-slider"><div class="impact_2-slides">';

	// Use a regular expression to match [impact_2_slide] shortcodes
	preg_match_all( '/\[impact_2_slide(.*?)\]/s', $content, $matches, PREG_SET_ORDER );
	$slide_count = count( $matches );

	// Process and return the content
	foreach ( $matches as $match ) {
		$params                = shortcode_parse_atts( $match[1] ); // Parse parameters
		$content_block_content = do_shortcode( '[impact_2_slide' . $match[1] . ']' ); // Process content within [impact_2_slide]

		// Process and use $params and $content_block_content as needed
		$impact_2_slider_html .= $content_block_content;
	}

	$impact_2_slider_html .= '</div>';
	$impact_2_slider_html .= '<div class="impact_2-navigation-dots ' . $dot_color . '-dots">';

	// Loop for generating navigation dots
	for ( $i = 1; $i <= $slide_count; $i++ ) {
		$impact_2_slider_html .= '<span class="impact_2-dot impact-dot" onclick="currentImpact2Slide(' . $i . ')"></span>';
	}

	$impact_2_slider_html .= '</div></div></div></div></div></section>';

	return $impact_2_slider_html;
}

add_shortcode( 'impact_2_slide', 'impact_2_slide_handler' );

function impact_2_slide_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'headline'            => '',
			'headline-color'      => 'slider-color', // black, white
			'text'                => '',
			'text-color'          => 'black', // black, white
			'button-type'         => '',
			'button-text'         => '',
			'button-color'        => '',
			'button-text-color'   => 'black', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, black
			'button-link'         => '',
			'button-2-text'       => '',
			'button-2-color'      => '',
			'button-2-link'       => '',
			'button-2-text-color' => 'barbie', // cherry, poppy, blush, barbie, peony, violet, tangerine, marigold, sunflower, forest, teal, mint, ocean, sky, bluejay, lavender, white
			'button-style'        => 'style-3', // style-3, style-1
			'button-2-style'      => 'style-4',
			'new-tab'             => 'no', // yes, no
			'button-2-new-tab'    => 'no', // yes, no
		),
		$atts,
		'impact_2_slide'
	);

	// Sanitize attributes
	$headline            = esc_html( $atts['headline'] );
	$headline_color      = esc_attr( $atts['headline-color'] );
	$text                = esc_html( $atts['text'] );
	$text_color          = esc_attr( $atts['text-color'] );
	$button_type         = esc_attr( $atts['button-type'] );
	$button_text         = esc_html( $atts['button-text'] );
	$button_color        = esc_attr( $atts['button-color'] );
	$button_link         = esc_url( $atts['button-link'] );
	$button_2_text       = esc_html( $atts['button-2-text'] );
	$button_2_color      = esc_attr( $atts['button-2-color'] );
	$button_2_link       = esc_url( $atts['button-2-link'] );
	$button_style        = esc_attr( $atts['button-style'] );
	$button_2_style      = esc_attr( $atts['button-2-style'] );
	$button_text_color   = esc_attr( $atts['button-text-color'] );
	$button_2_text_color = esc_attr( $atts['button-2-text-color'] );
	$new_tab             = esc_attr( $atts['new-tab'] );
	$button_2_new_tab    = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the impact_2_slide block

	$impact_2_slide_html  = '<div class="impact_2-slide">';
	$impact_2_slide_html .= '<h3 class="' . $headline_color . ' header-1">' . $headline . '</h3>';
	$impact_2_slide_html .= '<p class="' . $text_color . '-text">' . $text . '</p>';
	$impact_2_slide_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" type="' . $button_type . '" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" text-color="' . $button_text_color . '" style="' . $button_style . '" button-2-link="' . $button_2_link . '" button-2-text="' . $button_2_text . '" button-2-color="' . $button_2_color . '" button-2-text-color="' . $button_2_text_color . '" button-2-style="' . $button_2_style . '"]' );
	$impact_2_slide_html .= '</div>';

	return $impact_2_slide_html;

}

/** Script for impact_2_slider */

add_action( 'wp_footer', 'impact_2_slider_script' );

function impact_2_slider_script() {
	?>
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function () {
    var slidesContainer = document.querySelector('.impact_2-slides');
    if (!slidesContainer) {
        return;
    }

    // Clone the first slide and append it to the end
    var firstSlide = document.querySelector('.impact_2-slide');
    var clonedFirstSlide = firstSlide.cloneNode(true);
    slidesContainer.appendChild(clonedFirstSlide);

    var totalSlides = document.querySelectorAll('.impact_2-slide').length;
    var currentSlide = 1;
    var transitioning = false;
    var autoScrollInterval;

    // Set up initial state
    updateSlider();

    // Function to update the slider based on currentSlide
    function updateSlider() {
        slidesContainer.style.transition = 'transform 0.5s ease-in-out';
        slidesContainer.style.transform = 'translateY(' + -100 * (currentSlide - 1) + '%)';
        updateDots();
    }

    // Function to update navigation dots
    function updateDots() {
        var dots = document.querySelectorAll('.impact_2-dot');
        dots.forEach(function (dot, index) {
            dot.classList.toggle('active', index === (currentSlide - 1) % (totalSlides - 1));
        });
    }

    // Automatic scrolling
    function startAutoScroll() {
        autoScrollInterval = setInterval(function () {
            if (!transitioning) {
                transitioning = true;
                currentSlide++;
                updateSlider();

                // Reset to first slide smoothly
                if (currentSlide === totalSlides) {
                    setTimeout(function () {
                        slidesContainer.style.transition = 'none'; // Disable transition
                        slidesContainer.style.transform = 'translateY(0)';
                        currentSlide = 1;
                        setTimeout(() => {
                            slidesContainer.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
                            transitioning = false;
                        }, 50);
                    }, 500); // Wait for the previous transition to complete
                } else {
                    transitioning = false;
                }
            }
        }, 4000);
    }

    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    // Start auto-scroll on page load
    startAutoScroll();

    // Pause auto-scroll on hover
    var sliderContainer = document.querySelector('.impact_2-slider');
    sliderContainer.addEventListener('mouseover', stopAutoScroll);
    sliderContainer.addEventListener('mouseout', startAutoScroll);
});


	</script>    
	<?php
}

// Register the shortcode for the "hero_3" block

add_shortcode( 'hero_3', 'hero_3_handler' );

function hero_3_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'image-url'         => '', // jpg, png, gif
			'bg-color'          => '', // all the colors from palette
			'title'             => '',
			'title-color'       => 'black', // black, white
			'text'              => '',
			'text-color'        => 'black', // white, black
			'button-text'       => '',
			'button-style'      => 'style-5', // style-5, style-1
			'button-link'       => '',
			'button-text-color' => 'black',
			'button-color'      => '', // if style-1 is set
			'new-tab'           => 'no', // yes, no
			'button-2-new-tab'  => 'no', // yes, no
		),
		$atts,
		'hero_3'
	);

	// Sanitize attributes
	$image_url         = esc_url( $atts['image-url'] );
	$bg_color          = esc_attr( $atts['bg-color'] );
	$title             = esc_html( $atts['title'] );
	$title_color       = esc_attr( $atts['title-color'] );
	$text              = esc_html( $atts['text'] );
	$text_color        = esc_attr( $atts['text-color'] );
	$button_text       = esc_html( $atts['button-text'] );
	$button_style      = esc_attr( $atts['button-style'] );
	$button_link       = esc_url( $atts['button-link'] );
	$button_text_color = esc_attr( $atts['button-text-color'] );
	$button_color      = esc_attr( $atts['button-color'] );
	$new_tab           = esc_attr( $atts['new-tab'] );
	$button_2_new_tab  = esc_attr( $atts['button-2-new-tab'] );

	// Generate HTML for the hero_3 block

	$hero_3_html  = '<section class="full-width-section landing-section hero_3-section" style="background-image: url(\'' . $image_url . '\')"><div class="inner-wrap"><div class="landing-section-content">';
	$hero_3_html .= '<div class="content-area ' . $bg_color . '-bg">';
	$hero_3_html .= '<h2 class="title ' . $title_color . '-title">' . $title . '</h2>';
	$hero_3_html .= '<p class="description ' . $text_color . '-body-text">' . $text . '</p>';
	$hero_3_html .= do_shortcode( '[ibme_button new-tab="' . $new_tab . '" button-2-new-tab="' . $button_2_new_tab . '" link="' . $button_link . '" text="' . $button_text . '" color="' . $button_color . '" style="' . $button_style . '" text-color="' . $button_text_color . '"]' );
	$hero_3_html .= '</div></div></div></section>';

	return $hero_3_html;
}

add_shortcode( 'padding_box', 'padding_box_handler' );

function padding_box_handler( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'desktop' => '40',
			'mobile'  => '20',

		),
		$atts,
		'padding_box'
	);

	// Sanitize attributes
	$desktop = esc_attr( $atts['desktop'] );
	$mobile  = esc_attr( $atts['mobile'] );

	// Generate HTML for the padding_box block

	$padding_box_html  = '<div class="padding-box display-desktop" style="padding-top: ' . $desktop . 'px"></div>';
	$padding_box_html .= '<div class="padding-box display-mobile" style="padding-top: ' . $mobile . 'px"></div>';

	return $padding_box_html;
}

// Previous next post is redundant and also unintentionally creates internal links (copied from iBme.com)

add_action( 'lander_entry_header', 'ibme_post_byline', 11, 2 );

function ibme_post_byline( $type, $format ) {
	if ( is_front_page() || is_page() ) {
		return edit_post_link();
	}
	global $post;
	$pub_date = get_the_date( DATE_W3C );
	$mod_date = get_the_modified_date( DATE_W3C );
	$image    = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'medium' );
	?>
	<meta itemprop="author" content="iBme" />
	<meta itemprop="datePublished" content="<?php echo $pub_date; ?>" />
	<meta itemprop="dateModified" content="<?php echo $mod_date; ?>" />
	
	<meta itemprop="mainEntityOfPage" content="<?php echo get_permalink(); ?>" />
	<span itemprop="image" itemscope itemtype="https://www.schema.org/ImageObject">
			<meta itemprop="url" content="<?php echo $image[0]; ?>" />
	</span>
	<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
		<meta itemprop="name" content="Inward Bound Mindfulness Education" />
		<span itemprop="logo" itemscope itemtype="https://www.schema.org/ImageObject">
			<meta itemprop="url" content="" />
		</span>
	</span>
   
	<p class="entry-byline">
		<span class="entry-date"><?php echo get_the_date(); ?></span>
		<?php
		hybrid_post_terms(
			array(
				'taxonomy' => 'category',
				'text'     => esc_html__( 'Posted in %s', 'lander' ),
			)
		);
		?>
	<?php
	edit_post_link();
	?>
	</p>
	<?php
}


/* Responsive Menu Button */

add_action('wp_head', 'ibme_resp_button');

function ibme_resp_button() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $( '.mobile-menu').before( '<button class="menu-toggle menu-toggle-primary" role="button" aria-pressed="false">Menu</button>' ); // Add toggles to menus

            $( '.mobile-menu .sub-menu').before( '<button class="sub-menu-toggle" role="button" aria-pressed="false"></button>' ); // Add toggles to sub menus

            // Show/hide the navigation and add 'active' class to the menu and submenu
            
            $( '.menu-toggle' ).on( 'click', function() {
                var $this = $( this );
                $this.attr( 'aria-pressed', function( index, value ) {
                    return 'false' === value ? 'true' : 'false';
                });

                $this.toggleClass( 'activated' ); // Toggle 'activated' class for visual cue
                $this.next( '.mobile-menu' ).slideToggle( 'fast' ).toggleClass('active'); // Toggle 'active' class on the menu
            });

            $( '.sub-menu-toggle' ).on( 'click', function() {
                var $this = $( this );
                $this.attr( 'aria-pressed', function( index, value ) {
                    return 'false' === value ? 'true' : 'false';
                });

                $this.toggleClass( 'activated' ); // Toggle 'activated' class for visual cue
                $this.next( '.sub-menu' ).slideToggle( 'fast' ).toggleClass('active'); // Toggle 'active' class on the submenu
            });
        });
    </script>
    <?php
}


/** 404 Page Set-up */

add_action('lander_before','ibme_404_loop');

function ibme_404_loop() {
	if(is_404()) {
		remove_action('lander_loop','lander_do_loop');
		add_action( 'lander_loop','ibme_404_content' );
	}
}

function ibme_404_content() {
	echo do_shortcode('[hero_3 image-url="https://inwardboundmind.org/wp-content/uploads/2024/01/calendar-section-bg.jpg" bg-color="mint" title="page not found" text="Error 404 - looks like this page does not exist! Please check the URL again or explore the resources below for more options." button-text="back to homepage" button-link="https://inwardboundmind.org/"]');

	echo do_shortcode('[ibme_statement_2 orientation="left" title="welcome to our new inward bound mindfulness website" title-color="black" text="We apologize that you\'ve landed on a lost page. Please visit the pages below, explore our website using the menu above, or contact us if you need more support. Thank you!" text-color="black" bg-color="none" button-text="contact us" button-link="https://inwardboundmind.org/contact/" button-style="style-5"]');

	echo do_shortcode('[ibme_cta_3_content_blocks]
	[ibme_cta_3_content_block color="violet" title="teen retreat experience" text="Explore what happens on retreat, why teens love them, and the overall benefits of our mindfulness retreats." image-url="https://inwardboundmind.org/wp-content/uploads/2024/02/cta-teen-xp.jpg" button-link="https://inwardboundmind.org/teen-retreats/retreat-experience/" button-text="explore"][ibme_cta_3_content_block color="bluejay" title="teacher training" text-line-break="yes" text="Become certified to teach mindfulness to young people." image-url="https://inwardboundmind.org/wp-content/uploads/2024/02/cta-mtt.jpg" button-link="https://inwardboundmind.org/teacher-training/overview/" button-text="learn more"][ibme_cta_3_content_block color="marigold" title="custom programs" text-line-break="yes" text="Let us customize our programs to meet the needs of your community." image-url="https://inwardboundmind.org/wp-content/uploads/2024/02/cta-custom.jpg" button-link="https://inwardboundmind.org/custom-programs/overview/" button-text="learn more"][/ibme_cta_3_content_blocks]');

	echo do_shortcode('[padding_box desktop="160" mobile="40"]'); 
}