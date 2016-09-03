/**
 * Created by treen on 03/09/2016.
 */
jQuery(document).ready(function ($) {

    // Onsubmit, parse datas and populate fields
    $('#bbpcs').on('click', 'button#scanparser', function (e) {
        e.preventDefault();
        var currentVal = $('#support_parser').val();
        var items = parse_item(currentVal);
        $.each(items, function (key, value) {
            $('[data-id="' + key + '"]').val(value);
            $('.bbpcs__summary__list__item--' + key + '> .bbpcs__summary__list__item__desc').text(value)
        });
        $('.bbpcs__panel__content').hide();
        $('.bbpcs__summary').show();
    });

    // When chaings inputs content, update summary
    $('.bbpcs__panel__content__input').on('input', function () {
        var inputId = $('.bbpcs__summary__list__item--' + $(this).data('id'));
        inputId.find('.bbpcs__summary__list__item__desc').text($(this).val())
    });

    // Panel management
    $('.bbpcs__panel__headers__title').click(function () {
        var panel_prefix = '#bbpcs_panel_';
        var panel = panel_prefix + $(this).data('panel');
        $('.bbpcs__panel__content').hide();
        $('.bbpcs__panel__headers__title').removeClass('active');
        $(panel).fadeIn();
        $(this).addClass('active');
    });

    /*
     * Function to parse and transform textarea string to object
     * todo: Change plugin to return normalized keys
     * */
    function parse_item(datas) {
        var matches;
        var output = {};
        var pattern = '^- (.*) : (.*)$';
        var regex = new RegExp(pattern);
        datas = datas.split('\n');
        datas.forEach(function (item) {
            if (regex.test(item)) {
                matches = item.match(pattern);
                switch (matches[1]) {
                    case 'Version de WordPress':
                        output['wp_version'] = matches[2];
                        break;
                    case 'Version de PHP/MySQL':
                        var php_mysql = matches[2].split(' / ');
                        output['php_version'] = php_mysql[0];
                        output['mysql_version'] = php_mysql[1];
                        break;
                    case 'Thème utilisé':
                        output['theme_name'] = matches[2];
                        break;
                    case 'Thème URI':
                        output['theme_uri'] = matches[2];
                        break;
                    case 'Extensions en place':
                        output['plugins'] = matches[2];
                        break;
                    case 'Adresse du site':
                        output['uri'] = matches[2];
                        break;
                    case 'Nom de l\'hébergeur':
                        output['host'] = matches[2];
                        break;
                }
            }
        });
        console.log(output);

        return output;

    }

});