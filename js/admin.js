var PN_APP_SHORTCODES3 = function() {
    var self = {
        html_buffer: null,
        init: function() {
            jQuery.fn.life = function(types, data, fn) {
                jQuery(this.context).on(types, this.selector, data, fn);
                return this;
            };
            //***
            if (!jQuery("#pn_shortcodes_html_buffer3").size()) {
                jQuery('body').append('<div id="pn_shortcodes_html_buffer3" style="display: none;"></div>');
            }
            self.html_buffer = jQuery("#pn_shortcodes_html_buffer3");
            //***
            jQuery(".js_shortcode_checkbox_self_update").life('click', function() {
                if (jQuery(this).is(':checked')) {
                    jQuery(this).val(1);
                } else {
                    jQuery(this).val(0);
                }
            });
            //***
            jQuery(".js_shortcode_radio_self_update").life('click', function() {
                jQuery("input[data-shortcode-field=" + jQuery(this).attr('name') + "]").val(jQuery(this).val()).trigger('change');
            });

            jQuery(".gmap_targeting_checkbox_selfupdated").click(function() {
                if (jQuery(this).is(':checked')) {
                    jQuery(this).next('input[type=hidden]').val(1);
                } else {
                    jQuery(this).next('input[type=hidden]').val(0);
                }

                return true;
            });

        },
        insert_html_in_buffer: function(html) {
            jQuery(self.html_buffer).html(html);
        },
        get_html_from_buffer: function() {
            return jQuery(self.html_buffer).html();
        },
        changer: function(shortcode) {
            var items = jQuery("#pn_shortcode_template3 .js_shortcode_template_changer");
            var begin_string = "[" + shortcode;
            var end_string = "[/" + shortcode + "]";
            var content = "";

            jQuery.each(items, function(key, value) {
                var shortcode_field = jQuery(value).data('shortcode-field');

                if (shortcode_field !== undefined) {
                    if (shortcode_field == 'content') {
                        content = jQuery(value).val();
                    } else {
                        //save_as_one for dynamic lists
                        var vals = jQuery(value).val();
                        vals = vals.replace(/\"/gi, "\'");
                        begin_string = begin_string + " " + shortcode_field + '="' + vals + '"';
                    }
                }

            });

            var shortcode_text = begin_string + ']' + content + end_string;
            self.insert_html_in_buffer(shortcode_text);
        },
        show_static_info_popup: function(text) {
            if (!jQuery(".pn_shortcode_info_popup").length) {
                jQuery('body').prepend('<div class="pn_shortcode_info_popup"></div>');
            }
            jQuery(".pn_shortcode_info_popup").text(text);
            jQuery(".pn_shortcode_info_popup").fadeTo(400, 0.9);
        },
        hide_static_info_popup: function() {
            window.setTimeout(function() {
                jQuery(".pn_shortcode_info_popup").fadeOut(400);
            }, 777);
        },
        get_time_miliseconds: function() {
            var d = new Date();
            return d.getTime();
        }
    };
    return self;
};
//*****
var pn_ext_shortcodes3 = null;
jQuery(document).ready(function() {
    pn_ext_shortcodes3 = new PN_APP_SHORTCODES3();
    pn_ext_shortcodes3.init();
});

