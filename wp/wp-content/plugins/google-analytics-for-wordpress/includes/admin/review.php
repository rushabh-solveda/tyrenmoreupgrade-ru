<?php
/**
 * Ask for some love.
 *
 * @package    MonsterInsights
 * @author     MonsterInsights
 * @since      7.0.7
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018, MonsterInsights LLC
 */
class MonsterInsights_Review {
	/**
	 * Primary class constructor.
	 *
	 * @since 7.0.7
	 */
	public function __construct() {
		// Admin notice requesting review.
		add_action( 'admin_notices', array( $this, 'review_request' ) );
		add_action( 'wp_ajax_monsterinsights_review_dismiss', array( $this, 'review_dismiss' ) );
	}
	/**
	 * Add admin notices as needed for reviews.
	 *
	 * @since 7.0.7
	 */
	public function review_request() {
		// Only consider showing the review request to admin users.
		if ( ! is_super_admin() ) {
			return;
		}

		// Don't show to lite users
		if ( ! monsterinsights_is_pro_version() ) {
			return;
		}

		// If the user has opted out of product annoucement notifications, don't
		// display the review request.
		if ( monsterinsights_get_option( 'hide_am_notices', false ) || monsterinsights_get_option( 'network_hide_am_notices', false ) ) {
			return;
		}
		// Verify that we can do a check for reviews.
		$review = get_option( 'monsterinsights_review' );
		$time   = time();
		$load   = false;

		if ( ! $review ) {
			$review = array(
				'time'      => $time,
				'dismissed' => false,
			);
			update_option( 'monsterinsights_review', $review );
		} else {
			// Check if it has been dismissed or not.
			if ( ( isset( $review['dismissed'] ) && ! $review['dismissed'] ) && ( isset( $review['time'] ) && ( ( $review['time'] + DAY_IN_SECONDS ) <= $time ) ) ) {
				$load = true;
			}
		}

		// If we cannot load, return early.
		if ( ! $load ) {
			return;
		}

		$this->review();
	}

	/**
	 * Maybe show review request.
	 *
	 * @since 7.0.7
	 */
	public function review() {
		// Fetch when plugin was initially installed.
		$activated = get_option( 'monsterinsights_over_time', array() );
		if ( ! empty( $activated['installed_date'] ) ) {
			// Only continue if plugin has been installed for at least 14 days.
			if ( ( $activated['installed_date'] + ( DAY_IN_SECONDS * 14 ) ) > time() ) {
				return;
			}
		} else {
			$data = array(
				'installed_version' => MONSTERINSIGHTS_VERSION,
				'installed_date'    => time(),
				'installed_pro'     => monsterinsights_is_pro_version(),
			);

			update_option( 'monsterinsights_over_time', $data );
			return;
		}
		// Only proceed with displaying if the user is tracking.
		$ua_code = monsterinsights_get_ua_to_output();
		if ( empty( $ua_code ) ) {
			return;
		}
		// We have a candidate! Output a review message.
		?>
		<div class="notice notice-info is-dismissible monsterinsights-review-notice">
			<p><?php esc_html_e( 'Hey, I noticed you\'ve been using MonsterInsights for a while - that???s awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?', 'google-analytics-for-wordpress' ); ?></p>
			<p><strong><?php echo wp_kses( __( '~ Syed Balkhi<br>Co-Founder of MonsterInsights', 'google-analytics-for-wordpress' ), array( 'br' => array() ) ); ?></strong></p>
			<p>
				<a href="https://wordpress.org/support/plugin/google-analytics-for-wordpress/reviews/?filter=5#new-post" class="monsterinsights-dismiss-review-notice monsterinsights-review-out" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Ok, you deserve it', 'google-analytics-for-wordpress' ); ?></a><br>
				<a href="#" class="monsterinsights-dismiss-review-notice" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Nope, maybe later', 'google-analytics-for-wordpress' ); ?></a><br>
				<a href="#" class="monsterinsights-dismiss-review-notice" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'I already did', 'google-analytics-for-wordpress' ); ?></a>
			</p>
		</div>
		<script type="text/javascript">
			jQuery( document ).ready( function ( $ ) {
				$( document ).on( 'click', '.monsterinsights-dismiss-review-notice, .monsterinsights-review-notice button', function ( event ) {
					if ( ! $( this ).hasClass( 'monsterinsights-review-out' ) ) {
						event.preventDefault();
					}
					$.post( ajaxurl, {
						action: 'monsterinsights_review_dismiss'
					} );
					$( '.monsterinsights-review-notice' ).remove();
				} );
			} );
		</script>
		<?php
	}
	/**
	 * Dismiss the review admin notice
	 *
	 * @since 7.0.7
	 */
	public function review_dismiss() {
		$review              = get_option( 'monsterinsights_review', array() );
		$review['time']      = time();
		$review['dismissed'] = true;
		update_option( 'monsterinsights_review', $review );
		die;
	}
}
new MonsterInsights_Review;