<?php
/**
 * Widget: Events List Event Title
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/widgets/widget-events-list/event/title.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.2.1
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
<h3 class="tribe-events-widget-events-list__event-title tribe-common-h7">
	<a
		href="<?php echo $event_url; ?>"
		title="<?php echo esc_attr( $event->title ); ?>"
		rel="bookmark"
		class="tribe-events-widget-events-list__event-title-link tribe-common-anchor-thin"
	>
		<?php
		// phpcs:ignore
		echo $event->title;
		?>
	</a>
</h3>
