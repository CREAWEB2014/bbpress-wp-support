<?php
/**
 * Created by PhpStorm.
 * User: treen
 * Date: 03/09/2016
 * Time: 18:08
 *
 * @package bbpress-wp-support
 */

global $wp_version, $required_php_version, $required_mysql_version;
?>
<div class="bbpcs__summary" <?php if ( ! bbp_is_edit() ) : ?>style="display: none"<?php endif ?>>
	<div class="bbpcs__summary__heading">
		<div class="bbpcs__summary__heading__title">
			<?php _e( 'Summary', PLUGIN_TEXT_DOMAIN ) ?>
		</div>
	</div>
	<div class="bbpcs__summary__content">
		<ul class="bbpcs__summary__list">
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--wp_version">
		<span class="bbpcs__summary__list__item__title">
			<?php esc_attr_e( 'WordPress Version', PLUGIN_TEXT_DOMAIN ) ?> :
		</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_wp_version', true ) ?></span>
				<?php if ( get_post_meta( get_the_ID(), 'bbpcs_support_wp_version', true ) && version_compare( get_post_meta( get_the_ID(), 'bbpcs_support_wp_version', true ), $wp_version, '<' ) ) : ?>
					<span class="bbpcs__summary__list__item__latest">
					<?php printf( __( 'Latest %s' ), $wp_version ) ?>
				</span>
				<?php endif ?>
			</li>
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--php_version">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'PHP Version', PLUGIN_TEXT_DOMAIN ) ?> :
						</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_php_version', true ) ?></span>
				<?php if ( get_post_meta( get_the_ID(), 'bbpcs_support_php_version', true ) && version_compare( get_post_meta( get_the_ID(), 'bbpcs_support_php_version', true ), $required_php_version, '<' ) ) : ?>
					<span class="bbpcs__summary__list__item__latest">
					<?php printf( __( 'Required %s' ), $required_php_version ) ?>
				</span>
				<?php endif ?>
			</li>
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--theme_name">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Theme name', PLUGIN_TEXT_DOMAIN ) ?> :
					</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_theme_name', true ) ?></span>
			</li>
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--theme_uri">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Theme URL', PLUGIN_TEXT_DOMAIN ) ?> :
						</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_theme_uri', true ) ?></span>
			</li>
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--plugins">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Installed Plugins', PLUGIN_TEXT_DOMAIN ) ?> :
					</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_plugins', true ) ?></span>
			</li>
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--host">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Host', PLUGIN_TEXT_DOMAIN ) ?> :
					</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_host', true ) ?></span>
			</li>
			<li class="bbpcs__summary__list__item bbpcs__summary__list__item--uri">
					<span class="bbpcs__summary__list__item__title">
						<?php esc_attr_e( 'Site URL', PLUGIN_TEXT_DOMAIN ) ?> :
					</span>
				<span
					class="bbpcs__summary__list__item__version"><?php echo get_post_meta( get_the_ID(), 'bbpcs_support_uri', true ) ?></span>
			</li>
		</ul>
	</div>
</div>

