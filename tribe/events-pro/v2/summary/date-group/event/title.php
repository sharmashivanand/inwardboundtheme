<?php
/**
 * View: Summary View - Single Event Title (Theme Override)
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/summary/date-group/event/title.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.7.0
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
<h3 class="tribe-common-h8 tribe-common-h7--min-medium tribe-events-pro-summary__event-title">
	<?php $this->template( 'summary/date-group/event/title/featured' ); ?>
	<a
		href="<?php echo $event_url; ?>"
		title="<?php echo esc_attr( $event->title ); ?>"
		rel="bookmark"
		class="tribe-events-pro-summary__event-title-link tribe-common-anchor-thin"
	>
		<?php
		// phpcs:ignore
		echo $event->title;
		?>
	</a>
	<?php $this->template( 'summary/date-group/event/cost', [ 'event' => $event ] ); ?>
</h3>
