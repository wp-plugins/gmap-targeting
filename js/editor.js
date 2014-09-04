jQuery(function() {

    tinymce.create("tinymce.plugins.pn_tiny_gmap_targeting",
            {
                _self: null,
                init: function(ed, url)
                {
                    _self = this;


                    ed.addButton('gmap_targeting', {
                        title: gmt_lang_made_by,
                        icon: 'icon gmap_targeting_icon',
                        onclick: function() {
                            ed.execCommand("pn_gmap_targeting_tiny_popup", false, {
                                title: gmt_lang_popup_title,
                                identifier: 'gmap_targeting'
                            });
                        }
                    });

                    ed.addCommand("pn_gmap_targeting_tiny_popup", function(a, params)
                    {
                        var mode = 'new';
                        var shortcode_text = '';


                        //***
                        jQuery('body').append('<div id="pn_gmap_targeting_tiny_popup"></div>');
                        pn_ext_shortcodes3.show_static_info_popup(pn_lang_loading);
                        //***
                        var data = {
                            action: "gmap_targeting_get_shortcode_template",
                            shortcode_name: params.identifier,
                            mode: mode,
                            shortcode_text: shortcode_text
                        };
                        jQuery.post(ajaxurl, data, function(html) {
                            pn_ext_shortcodes3.hide_static_info_popup();

                            var popup_params = {
                                content: html,
                                title: params.title,
                                overlay: true,
                                open: function() {
                                    //***
                                },
                                buttons: {
                                    0: {
                                        name: gmt_lang_apply,
                                        action: function(__self) {
                                            var shortcode = pn_ext_shortcodes3.get_html_from_buffer();
                                            var editor = _self.get_active_editor();
                                            //***
                                            if (tinymce) {
                                                ed.execCommand('mceInsertContent', false, jQuery.trim(shortcode));
                                                ed.execCommand('mceSetContent', false, tinymce.EditorManager.activeEditor.getContent());
                                            }
                                        },
                                        close: true
                                    },
                                    1: {
                                        name: gmt_lang_close,
                                        action: 'close'
                                    }
                                }
                            };
                            pn_advanced_wp_popup3.popup(popup_params);
                        });

                    });



                },
                get_active_editor: function() {
                    return tinymce.EditorManager.activeEditor.editorId;
                },
                createControl: function(btn, e)
                {


                    return null;
                },
                getInfo: function() {
                    return {
                        longname: 'Shortcodes pack by realmag777',
                        version: "1.1.2"
                    };
                }
            });

    tinymce.PluginManager.add("pn_tiny_gmap_targeting", tinymce.plugins.pn_tiny_gmap_targeting);

});
