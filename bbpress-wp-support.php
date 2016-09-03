<?php
/**
 * Plugin Name: Wordpress BB Press Support
 * Description: Add support system for Wordpress BBpress support
 * Version: 1.0
 * Author: Treenity
 * Author URI: http://www.treenit-web.fr
 * License: GNU
 *
 * @package bbpress-wp-support
 */

namespace treenity\wordpress_bbsupport;

define( 'PLUGIN_TEXT_DOMAIN', 'bbpress-wp-support' );

require_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( ! is_plugin_active( 'bbpress/bbpress.php' ) ) {
	return;
}

/**
 * Add custom templates to BBPress
 *
 * @see bbp_get_template_part()
 *
 * @param array $templates Asked templates.
 *
 * @return mixed
 */
function add_template( $templates ) {
	$template_path = plugin_dir_path( __FILE__ ) . 'templates/';
	$files         = scandir( $template_path );
	if ( $result = array_intersect( $templates, $files ) ) {
		return include_once $template_path . $result[0];
	}

	return $templates;
}

add_filter( 'bbp_get_template_part', __NAMESPACE__ . '\\add_template', 10 );

/**
 * Add our form.
 *
 * @todo: Display only if we are on the support forum
 */
function add_support_form() {
	wp_enqueue_style( 'bbpress-wp-support', plugin_dir_url( __FILE__ ) . 'assets/css/global.css' );
	wp_enqueue_script( 'bbpress-wp-support', plugin_dir_url( __FILE__ ) . 'assets/js/global.js', array( 'jquery' ), false, true );
	?>
	<div id="bbpcs">
		<div class="bbpcs__container">
			<div class="bbpcs__header">
				<div class="bbpcs__header__title">
					Support system
				</div>
			</div>
			<?php include_once( 'parts/bbpcs-form.php' ) ?>
			<?php include_once( 'parts/ppbcs-summary.php' ) ?>
		</div>
	</div>
	<?php
}

add_action( 'bbp_theme_before_topic_form', __NAMESPACE__ . '\\add_support_form' );

/**
 * Save custom fields values
 *
 * @param int $post_id The current post ID.
 *
 * @return int $post_id The post_ID.
 */
function save_support_params( $post_id ) {
	if ( ! isset( $_POST['support'] ) || is_admin() ) {
		return $post_id;
	}
	// Remove Parser field, we don't need to save it
	unset( $_POST['support']['parser'] );
	foreach ( $_POST['support'] as $support_field_key => $support_field_value ) {
		if ( ! empty( $support_field_value ) ) {
			switch ( $support_field_key ) {
				case 'wp_version':
					if ( ! $parent = get_term_by( 'name', 'Wordpress', 'topic-tag' ) ) {
						$parent    = wp_insert_term( 'Wordpress', 'topic-tag' );
						$parent_id = $parent['term_id'];
					} else {
						$parent_id = $parent->term_id;
					}
					$term_id = wp_set_object_terms( $post_id, 'WP ' . $support_field_value, 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent_id ) );
					break;
				case 'php_version':
					if ( ! $parent = get_term_by( 'name', 'PHP', 'topic-tag' ) ) {
						$parent    = wp_insert_term( 'PHP', 'topic-tag' );
						$parent_id = $parent['term_id'];
					} else {
						$parent_id = $parent->term_id;
					}
					$term_id = wp_set_object_terms( $post_id, 'PHP ' . substr( $support_field_value, 0, 3 ), 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent_id ) );
					break;
				case 'mysql_version':
					if ( ! $parent = get_term_by( 'name', 'Mysql', 'topic-tag' ) ) {
						$parent    = wp_insert_term( 'Mysql', 'topic-tag' );
						$parent_id = $parent['term_id'];
					} else {
						$parent_id = $parent->term_id;
					}
					$term_id = wp_set_object_terms( $post_id, 'Mysql ' . substr( $support_field_value, 0, 3 ), 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent_id ) );
					break;
				case 'theme_name':
					if ( ! $parent = get_term_by( 'name', 'Themes', 'topic-tag' ) ) {
						$parent    = wp_insert_term( 'Themes', 'topic-tag' );
						$parent_id = $parent['term_id'];
					} else {
						$parent_id = $parent->term_id;
					}
					$term_id = wp_set_object_terms( $post_id, $support_field_value, 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent_id ) );
					break;
				case 'plugins':
					if ( ! $parent = get_term_by( 'name', 'Plugins', 'topic-tag' ) ) {
						$parent    = wp_insert_term( 'Plugins', 'topic-tag' );
						$parent_id = $parent['term_id'];
					} else {
						$parent_id = $parent->term_id;
					}
					$plugins = explode( ',', $support_field_value );
					foreach ( $plugins as $plugin ) {
						$term_id = wp_set_object_terms( $post_id, $plugin, 'topic-tag', true );
						wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent_id ) );
					}
					break;
			}
			update_post_meta( $post_id, 'bbpcs_support_' . $support_field_key, $support_field_value );
		} else {
			delete_post_meta( $post_id, 'bbpcs_support_' . $support_field_key );
		}
	}

	return $post_id;
}

add_action( 'save_post_topic', __NAMESPACE__ . '\\save_support_params' );

/**
 * Allow BBP topic-tag taxonomy to have childrens
 *
 * @param array $taxonomy The bbp topic-tag taxonomy.
 *
 * @return mixed
 */
function add_taxonomy_childs( $taxonomy ) {
	$taxonomy['hierarchical'] = true;

	return $taxonomy;
}

add_filter( 'bbp_register_topic_taxonomy', __NAMESPACE__ . '\\add_taxonomy_childs' );

/**
 * Add bbpcs_alert_empty_form to global JS variables.
 */
function add_js_variables() {
	?>
	<script type="text/javascript">
		var bbpcs_alert_empty_form = '<?php _ex( 'You have to give us some Support informations before we can help you.<br/>Please fill the support form as much as you can.', 'alert', PLUGIN_TEXT_DOMAIN ) ?>';
	</script>
	<?php
}

add_action( 'wp_head', __NAMESPACE__ . '\\add_js_variables' );
