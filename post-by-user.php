<?php
namespace Jet_Engine_CVC;

class Post_By_User extends \Jet_Engine\Modules\Dynamic_Visibility\Conditions\Base {

	/**
	 * Returns condition ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'jet-ecvc-post-by-user';
	}

	/**
	 * Returns condition name
	 *
	 * @return string
	 */
	public function get_name() {
		return __( 'Is post by current user', 'jet-engine' );
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

		$type    = ! empty( $args['type'] ) ? $args['type'] : 'show';
		$by_user = false;

		if ( is_user_logged_in() ) {
			$post = get_post( get_the_ID() );

			if ( $post ) {
				$author_id = absint( $post->post_author );
				$by_user   = $author_id === absint( get_current_user_id() );
			}
		}

		if ( 'hide' === $type ) {
			return ! $by_user;
		} else {
			return $by_user;
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

}
