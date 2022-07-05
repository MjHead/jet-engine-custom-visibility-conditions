<?php
namespace Jet_Engine_CVC;

class User_Has_Fields extends \Jet_Engine\Modules\Dynamic_Visibility\Conditions\Base {

	/**
	 * Returns condition ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'jet-ecvc-user-has-fields';
	}

	/**
	 * Returns condition name
	 *
	 * @return string
	 */
	public function get_name() {
		return __( 'User has required fields', 'jet-engine' );
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

		$type        = ! empty( $args['type'] ) ? $args['type'] : 'show';
		$res         = false;
		$fields_list = ! empty( $args['condition_settings']['fields_list'] ) ? $args['condition_settings']['fields_list'] : '';
		$fields_list = explode( ',', str_replace( ', ', ',', $fields_list ) );

		if ( empty( $fields_list ) ) {
			return $this->get_result( $type, $res );
		}

		$user = $this->get_user_by_settings( $args['condition_settings'] );

		if ( ! $user || is_wp_error( $user ) ) {
			return $this->get_result( $type, $res );
		}

		$object_fields = array( 'user_nicename', 'user_url' );

		$res = true;

		foreach ( $fields_list as $field ) {

			if ( in_array( $field, $object_fields ) ) {
				if ( empty( $user->data->$field ) ) {
					$res = false;
				}
			} else {

				$meta = get_user_meta( $user->ID, $field, true );

				if ( empty( $meta ) && '0' !== $meta ) {
					$res = false;
				}

			}
		}

		return $this->get_result( $type, $res );

	}

	/**
	 * Tries to get required user object by given arguments array
	 *
	 * @return [type] [description]
	 */
	public function get_user_by_settings( $settings ) {

		$user_context = ! empty( $settings['user_context'] ) ? $settings['user_context'] : 'current_user';
		$user         = false;

		switch ( $user_context ) {
			case 'queried_user':
				$user = jet_engine()->listings->data->get_queried_user_object();
				break;

			case 'current_post_author':

				global $post;

				if ( $post && $post->post_author ) {
					$user = get_user_by( 'id', $post->post_author );
				}

				break;

			default:
				if ( is_user_logged_in() ) {
					$user = wp_get_current_user();
				}
				break;
		}

		return $user;
	}

	/**
	 * Return condition check status depends on condition type
	 *
	 * @param  [type] $type   [description]
	 * @param  [type] $result [description]
	 * @return [type]         [description]
	 */
	public function get_result( $type, $result ) {

		if ( 'hide' === $type ) {
			return ! $result;
		} else {
			return $result;
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
		return false;
	}

	/**
	 * Returns condition specific repeater controls
	 */
	public function get_custom_controls() {

		return array(
			'fields_list' => array(
				'label'       => __( 'Fields list', 'jet-engine' ),
				'type'        => 'textarea',
				'default'     => '',
				'description' => __( 'Comma-separated user fields list to check. Allowed fields: first_name, last_name, description, user_nicename, user_url or any custom user meta field key. Condition will be passed if user has filled all of the given fields', 'jet-engine' )
			),
			'user_context' => array(
				'label'       => __( 'User context', 'jet-engine' ),
				'type'        => 'select',
				'default'     => 'current_user',
				'options'     => array(
					'current_user'        => __( 'Current user', 'jet-engine' ),
					'queried_user'        => __( 'Queried user', 'jet-engine' ),
					'current_post_author' => __( 'Current post author', 'jet-engine' ),
				),
			),
		);
	}

}
