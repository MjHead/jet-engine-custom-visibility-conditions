<?php
namespace Jet_Engine_CVC;

class Post_Date extends \Jet_Engine\Modules\Dynamic_Visibility\Conditions\Base {

	/**
	 * Returns condition ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'jet-ecvc-post-date';
	}

	/**
	 * Returns condition name
	 *
	 * @return string
	 */
	public function get_name() {
		return __( 'Post date less than', 'jet-engine' );
	}

	/**
	 * Returns group for current operator
	 *
	 * @return [type] [description]
	 */
	public function get_group() {
		return 'posts';
	}

	/**
	 * Check condition by passed arguments
	 *
	 * @param  array $args
	 * @return bool
	 */
	public function check( $args = array() ) {

		$type        = ! empty( $args['type'] ) ? $args['type'] : 'show';
		$days_to_end = $this->explode_string( $args['value'] );
		$post_time   = get_post_datetime( get_the_ID() );
		$now         = new \DateTime();

		$interval = $now->diff( $post_time );
		$day      = $interval->format( '%a' ) + 0;

		if ( 'hide' === $type ) {
			return ! ( $day < $days_to_end[0] );
		} else {
			return ( $day < $days_to_end[0] );
		}
	}

	/**
	 * Check if is condition available for meta fields control
	 *
	 * @return boolean
	 */
	public function is_for_fields() {
		return false;
	}

	/**
	 * Check if is condition available for meta value control
	 *
	 * @return boolean
	 */
	public function need_value_detect() {
		return true;
	}

}
