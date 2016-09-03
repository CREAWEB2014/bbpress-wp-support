<?php
/**
 * Created by PhpStorm.
 * User: treen
 * Date: 03/09/2016
 * Time: 18:08
 *
 * @package bbpress-wp-support
 */

?>
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
				<?php printf( __( 'You can download the support plugin <a href="%s" class="alert-link" target="_blank">here</a>, install it and after activation, go back to your dashboard to find the "wordpress-fr.net/support" panel, PASTE content here... ', PLUGIN_TEXT_DOMAIN ), 'https://wordpress.org/plugins/forum-wordpress-fr/' ) ?>
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
			       pattern="[\d]{1}.[\d]{1}(?:.[\d]+)?"
			       placeholder="<?php esc_attr_e( 'Your WordPress version number (ex: 4.6)', PLUGIN_TEXT_DOMAIN ) ?>"
			       data-id="wp_version"
			       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_wp_version', true ) ?>"
			       required>

			<label for="support[php_version]" class="bbpcs__panel__content__label">
				<?php esc_attr_e( 'PHP Version', PLUGIN_TEXT_DOMAIN ) ?>
			</label>
			<input type="text" id="support_php_version" name="support[php_version]"
			       class="bbpcs__panel__content__input"
			       pattern="[\d]{1}.[\d]{1}(?:.[\d]+)?"
			       placeholder="<?php esc_attr_e( 'Your PHP version number (ex: 5.6)', PLUGIN_TEXT_DOMAIN ) ?>"
			       data-id="php_version"
			       value="<?php echo get_post_meta( get_the_ID(), 'bbpcs_support_php_version', true ) ?>"
			       required>

			<label for="support[php_mysql]" class="bbpcs__panel__content__label">
				<?php esc_attr_e( 'PHP Version', PLUGIN_TEXT_DOMAIN ) ?>
			</label>
			<input type="text" id="support_mysql_version" name="support[mysql_version]"
			       class="bbpcs__panel__content__input"
			       pattern="[\d]{1}.[\d]{1}(?:.[\d]+)?"
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
