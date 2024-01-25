<?php
/**
 * View: Photo View - Single Event Title [Theme Override]
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/photo/event/title.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

$event_page_url = esc_url( $event->permalink );
$event_url = '';

if(tribe_get_event_website_url( $event )) {
    $event_url = esc_url(tribe_get_event_website_url( $event ));
} else {
    $event_url = $event_page_url;
}

?>
<h3 class="tribe-events-pro-photo__event-title tribe-common-h6">
	<a
		href="<?php echo $event_url; ?>"
		title="<?php the_title_attribute( $event->ID ); ?>"
		rel="bookmark"
		class="tribe-events-pro-photo__event-title-link tribe-common-anchor-thin"
	>
		<?php echo wp_kses_post( get_the_title( $event->ID ) ); ?>
	</a>
</h3>
