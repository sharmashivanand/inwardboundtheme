<?php
/**
 * View: List View - Single Event Featured Image
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/featured-image.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( ! $event->thumbnail->exists ) {
	return;
}

$event_page_url = esc_url( $event->permalink );
$event_url = '';

if(tribe_get_event_website_url( $event )) {
    $event_url = esc_url(tribe_get_event_website_url( $event ));
} else {
    $event_url = $event_page_url;
}

?>
<div class="tribe-events-calendar-list__event-featured-image-wrapper tribe-common-g-col">
	<a
		href="<?php echo $event_url; ?>"
		title="<?php echo esc_attr( $event->title ); ?>"
		rel="bookmark"
		class="tribe-events-calendar-list__event-featured-image-link"
		tabindex="-1"
	>
		<img
			src="<?php echo esc_url( $event->thumbnail->full->url ); ?>"
			<?php if ( ! empty( $event->thumbnail->srcset ) ) : ?>
				srcset="<?php echo esc_attr( $event->thumbnail->srcset ); ?>"
			<?php endif; ?>
			<?php if ( ! empty( $event->thumbnail->alt ) ) : ?>
				alt="<?php echo esc_attr( $event->thumbnail->alt ); ?>"
			<?php else : // We need to ensure we have an empty alt tag for accessibility reasons if the user doesn't set one for the featured image ?>
				alt=""
			<?php endif; ?>
			<?php if ( ! empty( $event->thumbnail->title ) ) : ?>
				title="<?php echo esc_attr( $event->thumbnail->title ); ?>"
			<?php endif; ?>
			class="tribe-events-calendar-list__event-featured-image"
		/>
	</a>
</div>
