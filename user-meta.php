<?php
namespace Jet_Engine_CVC;

class User_Meta_Is extends \Jet_Engine\Modules\Dynamic_Visibility\Conditions\Base {

	/**
	 * Returns condition ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'jet-ecvc-user-meta-is';
	}

	/**
	 * Returns condition name
	 *
	 * @return string
	 */
	public function get_name() {
		return __( 'User meta is', 'jet-engine' );
	}

	/**
	 * Returns group for current operator
	 *
	 * @return [type] [description]
	 */
	public function get_group() {
		return 'user';
	}

	/**
	 * Check condition by passed arguments
	 *
	 * @param  array $args
	 * @return bool
	 */
	public function check( $args = array() ) {

		$type = ! empty( $args['type'] ) ? $args['type'] : 'show';
		$res  = false;

		if ( is_user_logged_in() || $this->is_users_listings( $args ) ) {
			$current_value = $this->get_current_value( $args );
			$res = $current_value == $args['value'];
		}

		if ( 'hide' === $type ) {
			return ! $res;
		} else {
			return $res;
		}

	}

	/**
	 * Check if is condition use in the users listings.
	 *
	 * @param  array $args
	 * @return bool
	 */
	public function is_users_listings( $args = array() ) {
		$context = ! empty( $args['context'] ) ? $args['context'] : 'default';
		$object  = jet_engine()->listings->data->get_current_object();

		return 'current_listing' === $context && 'WP_User' === get_class( $object );
	}

	/**
	 * Returns current field value by arguments
	 *
	 * @param  array  $args [description]
	 * @return [type]       [description]
	 */
	public function get_current_value( $args = array() ) {

		$current_value = null;

		if ( ! empty( $args['field_raw'] ) ) {

			if ( $this->is_users_listings( $args ) ) {
				$user_id = jet_engine()->listings->data->get_current_object_id();
			} else {
				$user_id = get_current_user_id();
			}

			$current_value = get_user_meta( $user_id, $args['field_raw'], true );
		} else {
			$current_value = $args['field'];
		}

		return $current_value;

	}

	/**
	 * Check if is condition available for meta fields control
	 *
	 * @return boolean
	 */
	public function is_for_fields() {
		return true;
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
