<?php
/*
Plugin Name: Wordpress BB Press Support
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Add support system for Wordpress BBpress support
Version: 1.0
Author: Treenity
Author URI: http://www.treenit-web.fr
License: GNU
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
 * @param string $content HTML content.
 */
function add_support_form( $content ) {
	wp_enqueue_style( 'bbpress-wp-support', plugin_dir_url( __FILE__ ) . 'assets/css/global.css' );
	wp_enqueue_script( 'bbpress-wp-support', plugin_dir_url( __FILE__ ) . 'assets/js/global.js', array( 'jquery' ), false, true );
	global $wp_version, $required_php_version, $required_mysql_version;
	?>
	<div id="bbpcs">
		<div class="bbpcs__container">
			<div class="bbpcs__header">
				<div class="bbpcs__header__title">
					Support system
				</div>
			</div>
			<div class="bbpcs__panel">
				<div class="bbpcs__panel__headers">
					<div class="bbpcs__panel__headers__title active"
					     data-panel="automatic"><?php esc_attr_e( 'Automatic System', PLUGIN_TEXT_DOMAIN ) ?></div>
					<div class="bbpcs__panel__headers__title"
					     data-panel="manuel"><?php esc_attr_e( 'Manuel System', PLUGIN_TEXT_DOMAIN ) ?></div>
				</div>
				<div class="bbpcs__panel__container">
					<div class="bbpcs__panel__content" id="bbpcs_panel_automatic"
					     <?php if ( bbp_is_edit() ): ?>style="display: none"<?php endif ?>>
						<p class="bbpcs__panel__content__description">
							<?php printf( __( 'You can download the support plugin <a href="%s">here</a>, install it and after activation, go back to your dashboard to find the "wordpress-fr.net/support" panel, PASTE content here... ', PLUGIN_TEXT_DOMAIN ), 'https://wordpress.org/plugins/forum-wordpress-fr/' ) ?>
						</p>
						<textarea name="support[parser]" id="support_parser" cols="30" rows="7"></textarea>
						<button type="submit"
						        id="scanparser"><?php esc_attr_e( 'Parse', PLUGIN_TEXT_DOMAIN ) ?></button>
					</div>
					<div class="bbpcs__panel__content" id="bbpcs_panel_manuel" style="display: none">
						<label for="support[wp_version]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'WordPress Version', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_wp_version" name="support[wp_version]"
						       class="bbpcs__panel__content__input"
						       pattern="[.\d]{1}[.\d]{1}(?:[.\d])?"
						       placeholder="<?php esc_attr_e( 'Your WordPress version number (ex: 4.6)', PLUGIN_TEXT_DOMAIN ) ?>"
						       data-id="wp_version"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_wp_version', true ) ?>"
						       required>

						<label for="support[php_version]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'PHP Version', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_php_version" name="support[php_version]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'Your PHP version number (ex: 5.6)', PLUGIN_TEXT_DOMAIN ) ?>"
						       data-id="php_version"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_php_version', true ) ?>"
						       required>

						<label for="support[php_mysql]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'PHP Version', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_mysql_version" name="support[mysql_version]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'Your Mysql version number (ex: 5.7)', PLUGIN_TEXT_DOMAIN ) ?>"
						       data-id="mysql_version"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_mysql_version', true ) ?>"
						       required>

						<label for="support[theme_name]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'Theme name', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_theme_name" name="support[theme_name]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'Your actual theme name (ex: Twenty Sixteen)', PLUGIN_TEXT_DOMAIN ) ?>"
						       data-id="theme_name"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_theme_name', true ) ?>"
						       required>

						<label for="support[theme_uri]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'Theme URL', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_theme_uri" name="support[theme_uri]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'Your actual theme URL (ex: https://wordpress.org/themes/twentysixteen/)', PLUGIN_TEXT_DOMAIN ) ?>"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_theme_uri', true ) ?>"
						       data-id="theme_uri">

						<label for="support[plugins]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'Installed Plugins', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_plugins" name="support[plugins]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'List of installed plugins(comma spaced)', PLUGIN_TEXT_DOMAIN ) ?>"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_plugins', true ) ?>"
						       data-id="plugins" required>

						<label for="support[host]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'Host', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="text" id="support_host" name="support[host]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'Your Wordpress provider(host) (ex: OVH, Gandi...)', PLUGIN_TEXT_DOMAIN ) ?>"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_host', true ) ?>"
						       data-id="host">

						<label for="support[url]" class="bbpcs__panel__content__label">
							<?php esc_attr_e( 'Site URL', PLUGIN_TEXT_DOMAIN ) ?>
						</label>
						<input type="url" id="support_url" name="support[uri]"
						       class="bbpcs__panel__content__input"
						       placeholder="<?php esc_attr_e( 'Your WordPress site URL', PLUGIN_TEXT_DOMAIN ) ?>"
						       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_uri', true ) ?>"
						       data-id="uri" required>
					</div>
				</div>
			</div>
			<div class="bbpcs__summary" <?php if ( ! bbp_is_edit() ) : ?>style="display: none"<?php endif ?>>
				<ul class="bbpcs__summary__list">
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--wp_version">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'WordPress Version', PLUGIN_TEXT_DOMAIN ) ?>
					</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_wp_version', true ) ?></span>
						<span
							class="bbpcs__summary__list__item__latest"><?php printf( __( 'Latest %s' ), $wp_version ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--php_version">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'PHP Version', PLUGIN_TEXT_DOMAIN ) ?>
						</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_php_version', true ) ?></span>
						<span
							class="bbpcs__summary__list__item__latest"><?php printf( __( 'Required %s' ), $required_php_version ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--mysql_version">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Mysql Version', PLUGIN_TEXT_DOMAIN ) ?>
						</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_mysql_version', true ) ?></span>
						<span
							class="bbpcs__summary__list__item__latest"><?php printf( __( 'Required %s' ), $required_mysql_version ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--theme_name">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Theme name', PLUGIN_TEXT_DOMAIN ) ?>
					</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_theme_name', true ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--theme_uri">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Theme URL', PLUGIN_TEXT_DOMAIN ) ?>
						</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_theme_uri', true ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--plugins">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Installed Plugins', PLUGIN_TEXT_DOMAIN ) ?>
					</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_plugins', true ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--host">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Host', PLUGIN_TEXT_DOMAIN ) ?>
					</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_host', true ) ?></span>
					</li>
					<li class="bbpcs__summary__list__item bbpcs__summary__list__item--uri">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Site URL', PLUGIN_TEXT_DOMAIN ) ?>
					</span>
						: <span
							class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_uri', true ) ?></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'bbp_theme_before_topic_form', __NAMESPACE__ . '\\add_support_form' );

function save_support_params( $post_id ) {
	if ( ! isset( $_POST['support'] ) ) {
		return $post_id;
	}
	// Remove Parser field, we don't need to save it
	unset( $_POST['support']['parser'] );
	foreach ( $_POST['support'] as $support_field_key => $support_field_value ) {
		if ( ! empty( $support_field_value ) ) {
			switch ( $support_field_key ) {
				case 'wp_version':
					$parent  = wp_insert_term( 'Wordpress', 'topic-tag' );
					$term_id = wp_set_object_terms( $post_id, 'WP ' . $support_field_value, 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent['term_id'] ) );
					break;
				case 'php_version':
					$parent  = wp_insert_term( 'PHP', 'topic-tag' );
					$term_id = wp_set_object_terms( $post_id, 'PHP ' . substr( $support_field_value, 0, 3 ), 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent['term_id'] ) );
					break;
				case 'mysql_version':
					$parent  = wp_insert_term( 'Mysql', 'topic-tag' );
					$term_id = wp_set_object_terms( $post_id, 'Mysql ' . substr( $support_field_value, 0, 3 ), 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent['term_id'] ) );
					break;
				case 'theme_name':
					$parent  = wp_insert_term( 'Themes', 'topic-tag' );
					$term_id = wp_set_object_terms( $post_id, $support_field_value, 'topic-tag', true );
					wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent['term_id'] ) );
					break;
				case 'plugins':
					$parent  = wp_insert_term( 'Plugins', 'topic-tag' );
					$plugins = explode( ',', $support_field_value );
					foreach ( $plugins as $plugin ) {
						$term_id = wp_set_object_terms( $post_id, $plugin, 'topic-tag', true );
						wp_update_term( $term_id[0], 'topic-tag', array( 'parent' => $parent['term_id'] ) );
					}
					break;
			}
			update_post_meta( $post_id, 'bbpcs_support_' . $support_field_key, $support_field_value );
		} else {
			delete_post_meta( $post_id, 'bbpcs_support_' . $support_field_key );
		}
	}
}

add_action( 'save_post', __NAMESPACE__ . '\\save_support_params' );

function add_taxonomy_childs( $taxonomy ) {
	$taxonomy['hierarchical'] = true;

	return $taxonomy;
}

add_filter( 'bbp_register_topic_taxonomy', __NAMESPACE__ . '\\add_taxonomy_childs' );

function add_js_variables() { ?>
	<script type="text/javascript">
		var bbpcs_alert_empty_form = '<?php _ex( 'You have to give us some Support informations before we can help you.<br/>Please fill the support form as much as you can.', 'alert', PLUGIN_TEXT_DOMAIN ) ?>';
	</script><?php
}

add_action( 'wp_head', __NAMESPACE__ . '\\add_js_variables' );
