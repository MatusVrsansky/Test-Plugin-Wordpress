<?php
/**
 * Meta box generator for WordPress
 * Compatible with custom post types
 *
 * Support input types: text, textarea, checkbox, select, radio
 *
 * @package Qusq_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IshYoMetaBox' ) ) {
	/**
	 * Meta box generator for WordPress
	 */
	class IshYoMetaBox {

		/**
		 * The metabox.
		 *
		 * @var array
		 */
		protected $meta_box;

		/**
		 * The inner id.
		 *
		 * @var string
		 */
		protected $id;

		/**
		 * The inner prefix
		 *
		 * @var string
		 */
		static $prefix = '_ishmb_';

		/**
		 * Create meta box based on given data.
		 *
		 * @param string $id the metabox id.
		 * @param array  $opts the metabox options.
		 */
		public function __construct( $id, $opts ) {

			// Continue only in Admin section.
			if ( ! is_admin() ) {
				return;
			}

			$this->meta_box = $opts;
			$this->id = $id;
			add_action( 'add_meta_boxes', array( &$this, 'add' ) );
			add_action( 'save_post', array( &$this, 'save' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'scripts' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_css' ) );

		}

		/**
		 * Add meta box for multiple post types.
		 */
		public function add() {

			foreach ( $this->meta_box['pages'] as $bpage ) {
				add_meta_box(
					$this->id,
					$this->meta_box['title'],
					array( &$this, 'show' ),
					$bpage, $this->meta_box['context'],
					$this->meta_box['priority']
				);
			}
		}

		/**
		 * Callback function to show fields in meta box.
		 *
		 * @param object $post the post.
		 */
		public function show( $post ) {

			// Use nonce for verification.
			echo '<input type="hidden" name="' . esc_attr( $this->id ) . '_meta_box_nonce" value="', esc_attr( wp_create_nonce( 'ishyometabox' . esc_attr( $this->id ) ) ), '" />';

			if ( 'side' === $this->meta_box['context'] ) {

				echo '<div class="' . esc_attr( self::$prefix ) . 'container">';
				foreach ( $this->meta_box['fields'] as $field ) {

					if ( 'wp_editor' === $field['type'] ) {
						$wp_editor_id = str_replace( '_', '', $field['id'] );
					}
					$id = self::$prefix . $field['id'];

					$value = self::get( $field['id'] );
					if ( empty( $value ) && ! count( self::get( $field['id'], false ) ) ) {
						$value = isset( $field['default'] ) ? $field['default'] : '';
					}

					do_action( 'qusq_lite_before_metabox_field', $field );

					echo '<div id="' . esc_attr( $id ) . '_boxitem">';
					echo '<p class="box_name">', '<strong>', esc_html( $field['name'] ), '</strong></p>';
					echo '<label class="screen-reader-text" for="', esc_attr( $id ), '">', esc_html( $field['name'] ), '</label>';

					include get_parent_theme_file_path( '/inc/modules/metabox-enabler/field-types/' . str_replace( '_', '-', $field['type'] ) . '.php' );

					if ( isset( $field['desc'] ) ) {

						if ( 'checkbox' !== $field['type'] ) {
							echo '<br />';
						}

						echo '<p class="howto">' . esc_html( $field['desc'] ) . '</p>';
					}
					echo '</div>';
				}
				echo '</div>';

			} else {

				echo '<table class="form-table">';
				foreach ( $this->meta_box['fields'] as $field ) {

					if ( 'wp_editor' === $field['type'] ) {
						$wp_editor_id = str_replace( '_', '', $field['id'] );
					}
					$id = self::$prefix . $field['id'];

					do_action( 'qusq_lite_before_metabox_field', $field );

					$value = self::get( $field['id'] );
					if ( empty( $value ) && ! count( self::get( $field['id'], false ) ) ) {
						$value = isset( $field['default'] ) ? $field['default'] : '';
					}
					echo '<tr>', '<th style="width:20%"><label for="', esc_attr( $id ), '">', esc_html( $field['name'] ), '</label></th>', '<td>';

					include get_parent_theme_file_path( '/inc/modules/metabox-enabler/field-types/' . str_replace( '_', '-', $field['type'] ) . '.php' );

					if ( isset( $field['desc'] ) ) {

						if ( 'checkbox' !== $field['type'] ) {
							echo '<br />';
						}

						echo '<span class="description">' . esc_html( $field['desc'] ) . '</span>';
					}
					echo '</td></tr>';

				}
				echo '</table>';

			} // End if().

		}

		/**
		 * Save data from meta box.
		 *
		 * @param int $post_id the post id.
		 *
		 * @return int
		 */
		public function save( $post_id ) {

			// verify nonce.
			if ( ! isset( $_POST[ $this->id . '_meta_box_nonce' ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $this->id . '_meta_box_nonce' ] ) ), 'ishyometabox' . $this->id ) ) {
				return $post_id;
			}

			// check autosave.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			// check permissions.
			if ( isset( $_POST['post_type'] ) && 'post' === $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}
			} elseif ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
			foreach ( $this->meta_box['fields'] as $field ) {
				$name = self::$prefix . $field['id'];
				$sanitize_callback = ( isset( $field['sanitize_callback'] ) ) ? $field['sanitize_callback'] : '';
				if ( isset( $_POST[ $name ] ) || isset( $_FILES[ $name ] ) ) {
					$old = self::get( $field['id'], true, $post_id );
					$new = ( isset( $_POST[ $name ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) : '';
					if ( $new !== $old ) {
						self::set( $field['id'], $new, $post_id, $sanitize_callback );
					}
				} elseif ( 'checkbox' === $field['type'] ) {
					self::set( $field['id'], 'false', $post_id, $sanitize_callback );
				} else {
					self::delete( $field['id'], $name );
				}
			}
		}

		/**
		 * Enqueue the necessary scripts.
		 */
		function scripts() {
			wp_enqueue_style( 'qusq-lite-metabox-enabler-admin-css', get_template_directory_uri() . '/inc/modules/metabox-enabler/css/metabox-enabler.css', array(), '20151215' );
			wp_enqueue_script( 'qusq-lite-metabox-enabler-admin-js', get_template_directory_uri() . '/inc/modules/metabox-enabler/js/metabox-enabler.js', array( 'jquery' ), '20151215' );
		}

		/**
		 * Output Admin CSS necessary for custom metaboxes styling.
		 */
		function admin_css() {

			$colors = qusq_lite_get_theme_colors_array();
			$output = '';

			foreach ( $colors as $key => $value ) {
				$output .= '.ish_meta_param.ish_color_selector_item .color' . $key . ', .ish_meta_param.ish_color_selector_container [data-ish-value="color' . $key . '"] { background-color: ' . $value . '; color: ' . qusq_lite_get_color_contrast( $value ) . "; }\n";
			}

			wp_add_inline_style( 'qusq-lite-metabox-enabler-admin-css', $output );
		}

		/**
		 * The Getter function
		 *
		 * @param string $name    The name of the box.
		 * @param bool   $single  Whether to return a single value. Default false.
		 * @param int    $post_id Post ID.
		 *
		 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
		 */
		static function get( $name, $single = true, $post_id = null ) {
			global $post;
			return get_post_meta( isset( $post_id ) ? $post_id : ( ( isset( $post ) && '' !== $post ) ? $post->ID : null ), self::$prefix . $name, $single );
		}

		/**
		 * The Setter function
		 *
		 * @param string $name The name of the box.
		 * @param array  $new The new data to be saved.
		 * @param int    $post_id Post ID.
		 * @param string $sanitize_callback Callback function.
		 *
		 * @return mixed
		 */
		static function set( $name, $new, $post_id = null, $sanitize_callback = '' ) {
			global $post;

			$id = ( isset( $post_id ) ) ? $post_id : $post->ID;
			$meta_key = self::$prefix . $name;
			$new = ( '' !== $sanitize_callback && is_callable( $sanitize_callback ) ) ? call_user_func( $sanitize_callback, $new, $meta_key, $id ) : $new;
			return update_post_meta( $id, $meta_key, $new );
		}

		/**
		 * Delete function
		 *
		 * @param string $name The name of the box.
		 * @param int    $post_id Post ID.
		 *
		 * @return mixed
		 */
		static function delete( $name, $post_id = null ) {
			global $post;
			return delete_post_meta( isset( $post_id ) ? $post_id : $post->ID, self::$prefix . $name );
		}
	};
} // End if().

if ( ! function_exists( 'add_ishyo_meta_box' ) ) {
	/**
	 * Crete new instance and apply filters
	 *
	 * @param string $id The metabox id.
	 * @param array  $opts the options.
	 */
	function add_ishyo_meta_box( $id, $opts ) {

		do_action( 'qusq_lite_before_metabox', $opts );

		new IshYoMetaBox( $id, $opts );
	}
}
