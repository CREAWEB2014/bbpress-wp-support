/**
 * Created by treen on 03/09/2016.
 *
 * @package bbpress-wp-supporr
 */
jQuery(document).ready(function ($) {
    // Panel management
    $('.bbpcs__panel__headers__title').click(function () {
        var panel_prefix = '#bbpcs_panel_';
        var panel = panel_prefix + $(this).data('panel');
        $('.bbpcs__panel__content').hide();
        $('.bbpcs__panel__headers__title').removeClass('active');
        $(panel).fadeIn();
        $(this).addClass('active');
    });


});