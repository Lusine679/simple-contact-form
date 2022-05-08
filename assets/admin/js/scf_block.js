 ( function ( blocks, element ) {
    registerAllPluginBlocks();

    function registerAllPluginBlocks() {
        var scfPluginsData = window['scf_gb'];
        if ( !scfPluginsData ) {
            return;
        }

        for ( var pluginId in scfPluginsData ) {
            if ( !scfPluginsData.hasOwnProperty( pluginId ) ) {
                continue;
            }

            if ( !scfPluginsData[pluginId].inited ) {
                scfPluginsData[pluginId].inited = true;
                registerPluginBlock( blocks, element, pluginId, scfPluginsData[pluginId] );
            }
        }
    }

    function registerPluginBlock( blocks, element, pluginId, pluginData ) {
        var el = element.createElement;

        var isPopup = pluginData.isPopup;

        var iconEl = el( 'img', {
            width: pluginData.iconSvg.width,
            height: pluginData.iconSvg.height,
            src: pluginData.iconSvg.src
        } );

        blocks.registerBlockType( pluginId, {
            title: pluginData.title,
            icon: iconEl,
            category: 'common',
            attributes: {
                shortcode: {
                    type: 'string'
                },
                popupOpened: {
                    type: 'boolean',
                    value: true
                },
                notInitial: {
                    type: 'boolean'
                },
                shortcode_id: {
                    type: 'string'
                }
            },

            edit: function ( props ) {
                if ( !props.attributes.notInitial ) {
                    props.setAttributes( {
                        notInitial: true,
                        popupOpened: true
                    } );

                    return el( 'p' );
                }

                if ( props.attributes.popupOpened ) {
                    if ( !isPopup ) {
                        return showShortcodeList( props.attributes.shortcode );
                    }
                }

                function showShortcodeList( shortcode ) {
                    props.setAttributes( { popupOpened: true } );
                    
                    return el( 'form', {  }, el( 'div', {}, pluginData.titleSelect ), el( 'img', {
                        src: pluginData.iconSvg.src,
                        alt: pluginData.title,
                        style: {
                            'height': "36px",
                            'width': "36px"
                        },
                        
                    } ) );
                }
            },

            save: function (props) {
                return '[scf]';
            }
        } );
    }
} )(
    window.wp.blocks,
    window.wp.element
);