jQuery(function() {

    tinymce.create("tinymce.plugins.pn_tiny_gmap_targeting",
            {
                _self: null,
                init: function(ed, url)
                {
                    _self = this;

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
                                        name: 'Apply',
                                        action: function(__self) {
                                            var shortcode = pn_ext_shortcodes3.get_html_from_buffer();
                                            var editor = _self.get_active_editor();
                                            //***
                                            if (window.tinyMCE) {
                                                window.tinyMCE.execInstanceCommand(editor, 'mceInsertContent', false, jQuery.trim(shortcode));
                                                ed.execCommand('mceSetContent', false, tinyMCE.activeEditor.getContent());
                                            }
                                        },
                                        close: true
                                    },
                                    1: {
                                        name: 'Close',
                                        action: 'close'
                                    }
                                }
                            };
                            pn_advanced_wp_popup3.popup(popup_params);
                        });

                    });



                },
                get_active_editor: function() {
                    return tinyMCE.activeEditor.editorId;
                },
                createControl: function(btn, e)
                {
                    if (btn == "gmap-targeting")
                    {
                        var a = this;

                        //tinymce button adding
                        btn = e.createMenuButton("pn_gmap_targeting_tinymce_button",
                                {
                                    title: pn_ext_shortcodes3_lang2,
                                    image: pn_ext_shortcodes3_app_link + "images/shortcode_icon.png",
                                    icons: false,
                                    onclick: function() {
                                        tinyMCE.activeEditor.execCommand("pn_gmap_targeting_tiny_popup", false, {
                                            title: 'Google Map Targeting by PluginUs.Net',
                                            identifier: 'gmap_targeting'
                                        });
                                    }
                                });


                        return btn;
                    }

                    return null;
                },
                getInfo: function() {
                    return {
                        longname: 'Shortcodes pack by realmag777',
                        version: "1.1.1"
                    };
                }
            });

    tinymce.PluginManager.add("pn_tiny_gmap_targeting", tinymce.plugins.pn_tiny_gmap_targeting);

});
