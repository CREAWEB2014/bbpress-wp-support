/**
 * Created by treen on 03/09/2016.
 */
jQuery(document).ready(function ($) {
    var supportBlock = $('#bbpcs');

    supportBlock.on('click', 'button#scanparser', function (e) {
        var items, matches, id = 0;

        items = [
            'wp_version',
            'php_mysql',
            'theme_name',
            'theme_uri',
            'plugins',
            'uri',
            'host'
        ];

        e.preventDefault();
        var find = /- (.*) : (.*)/m;
        var regex = new RegExp(find);
        var currentVal = $('#support_parser').val();
        currentVal = currentVal.split('\n');
        currentVal.forEach(function (item) {
            if (regex.test(item)) {
                matches = item.match(find);
                $('[data-id="' + items[id] + '"]').val(matches[2]);
                console.log(items[id]);
                $('.bbpcs__summary__list__item--' + items[id] + '> .bbpcs__summary__list__item__desc').text(matches[2])
            }
            id++;
        });
        $('.bbpcs__panel__content').hide();
        $('.bbpcs__summary').show();
    });

    $('.bbpcs__panel__content__input').on('input', function () {
        $('.bbpcs__summary__list__item--' + $(this).data('id') + '> .bbpcs__summary__list__item__desc').text($(this).val())
    });

    $('.bbpcs__panel__headers__title').click(function () {
        var panel_prefix = '#bbpcs_panel_';
        var panel = panel_prefix + $(this).data('panel');
        $('.bbpcs__panel__content').hide();
        $('.bbpcs__panel__headers__title').removeClass('active');
        $(panel).fadeIn();
        $(this).addClass('active');
    })

});