<?php
namespace Jet_Engine_CVC;

class Post_Status extends \Jet_Engine\Modules\Dynamic_Visibility\Conditions\Base {

	/**
	 * Returns condition ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'jet-ecvc-post-status';
	}

	/**
	 * Returns condition name
	 *
	 * @return string
	 */
	public function get_name() {
		return __( 'Post Status is', 'jet-engine' );
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

		$type           = ! empty( $args['type'] ) ? $args['type'] : 'show';
		$post_statuses  = $this->explode_string( $args['value'] );
		$current_status = get_post_status( get_the_ID() );

		if ( 'hide' === $type ) {
			return ! in_array( $current_status, $post_statuses );
		} else {
			return in_array( $current_status, $post_statuses );
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
