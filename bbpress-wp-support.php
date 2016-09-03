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
				     data-panel="automatic"><?php esc_attr_e( 'Automatic System', 'bbpress-wp-support' ) ?></div>
				<div class="bbpcs__panel__headers__title"
				     data-panel="manuel"><?php esc_attr_e( 'Manuel System', 'bbpress-wp-support' ) ?></div>
			</div>
			<div class="bbpcs__panel__container">
				<div class="bbpcs__panel__content" id="bbpcs_panel_automatic">
					<p class="bbpcs__panel__content__description">
						<?php printf( __( 'You can download the support plugin <a href="%s">here</a>, install it and after activation, go back to your dashboard to find the "wordpress-fr.net/support" panel, PASTE content here... ', 'bbpress-wp-support' ), 'https://wordpress.org/plugins/forum-wordpress-fr/' ) ?>
					</p>
					<textarea name="support[parser]" id="support_parser" cols="30" rows="5"></textarea>
					<button type="submit"
					        id="scanparser"><?php esc_attr_e( 'Submit', 'bbpress-wp-support' ) ?></button>
				</div>
				<div class="bbpcs__panel__content" id="bbpcs_panel_manuel" style="display: none">
					<label for="support[wp_version]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'WordPress Version', 'bbpress-wp-support' ) ?>
					</label>
					<input type="text" id="support_wp_version" name="support[wp_version]"
					       class="bbpcs__panel__content__input"
					       pattern="[.\d]{1}[.\d]{1}(?:[.\d])?"
					       placeholder="<?php esc_attr_e( 'Your WordPress version number (ex: 4.6)', 'bbpress-wp-support' ) ?>"
					       data-id="wp_version" required>
					<label for="support[php_mysql]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'PHP Version', 'bbpress-wp-support' ) ?>
					</label>
					<input type="text" id="support_php_mysql" name="support[php_mysql]"
					       class="bbpcs__panel__content__input"
					       placeholder="<?php esc_attr_e( 'Your PHP version number', 'bbpress-wp-support' ) ?>"
					       data-id="php_mysql" required>
					<label for="support[theme_name]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'Theme name', 'bbpress-wp-support' ) ?>
					</label>
					<input type="text" id="support_theme_name" name="support[theme_name]"
					       class="bbpcs__panel__content__input"
					       placeholder="<?php esc_attr_e( 'Your actual theme name', 'bbpress-wp-support' ) ?>"
					       data-id="theme_name" required>
					<label for="support[theme_uri]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'Theme URL', 'bbpress-wp-support' ) ?>
					</label>
					<input type="text" id="support_theme_uri" name="support[theme_uri]"
					       class="bbpcs__panel__content__input"
					       placeholder="<?php esc_attr_e( 'Your actual theme URL', 'bbpress-wp-support' ) ?>"
					       data-id="theme_uri">
					<label for="support[plugins]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'Installed Plugins', 'bbpress-wp-support' ) ?>
					</label>
					<input type="text" id="support_plugins" name="support[plugins]"
					       class="bbpcs__panel__content__input"
					       placeholder="<?php esc_attr_e( 'List of installed plugins', 'bbpress-wp-support' ) ?>"
					       data-id="plugins" required>
					<label for="support[host]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'Host', 'bbpress-wp-support' ) ?>
					</label>
					<input type="text" id="support_host" name="support[host]"
					       class="bbpcs__panel__content__input"
					       placeholder="<?php esc_attr_e( 'Your Wordpress provider(host)', 'bbpress-wp-support' ) ?>"
					       data-id="host">
					<label for="support[url]" class="bbpcs__panel__content__label">
						<?php esc_attr_e( 'Site URL', 'bbpress-wp-support' ) ?>
					</label>
					<input type="url" id="support_url" name="support[uri]"
					       class="bbpcs__panel__content__input"
					       placeholder="<?php esc_attr_e( 'Your WordPress site URL', 'bbpress-wp-support' ) ?>"
					       data-id="uri" required>
				</div>
			</div>
		</div>
		<div class="bbpcs__summary" style="display: none">
			<ul class="bbpcs__summary__list">
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--wp_version">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'WordPress Version', 'bbpress-wp-support' ) ?>
					</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--php_mysql">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'PHP Version', 'bbpress-wp-support' ) ?>
						</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--theme_name">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Theme name', 'bbpress-wp-support' ) ?>
					</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--theme_uri">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Theme URL', 'bbpress-wp-support' ) ?>
						</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--plugins">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Installed Plugins', 'bbpress-wp-support' ) ?>
					</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--host">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Host', 'bbpress-wp-support' ) ?>
					</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
				<li class="bbpcs__summary__list__item bbpcs__summary__list__item--uri">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Site URL', 'bbpress-wp-support' ) ?>
					</span>
					: <span class="bbpcs__summary__list__item__desc"></span>
				</li>
			</ul>
		</div>
	</div>
	<?php
}

add_action( 'bbp_theme_before_topic_form_content', __NAMESPACE__ . '\\add_support_form' );
