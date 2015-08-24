
<?php
/**
 * Settings Class
 *
 * @author      Kyle Dinh
 * @category    Plugin Settings
 * @package     Utils
 * @since       1
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if ( ! class_exists( 'KD3DatavizSettings' ) ) {
    class D3DatavizSettings {
        protected $tag = 'kd3dataviz';
        protected $name = 'KD3Dataviz';
        protected $version = '1.0.0';        
        protected $settings = array(
            'typeDelay' => array(
                'description' => 'Minimum delay, in ms, between typing characters.',
                'validator' => 'numeric',
                'placeholder' => 100
            ),
            'cursor' => array(
                'description' => 'Character used to represent the cursor.',
                'placeholder' => '|'
            ),
            'humanise' => array(
                'description' => 'Add a random delay before each character to represent human interaction.',
                'type' => 'checkbox',
                'default' => true
            )
        );

        public function __construct() {
            if ( is_admin() ) {
                add_action( 'admin_init', array( &$this, 'settings' ) );
            }
        }

        public function settings() {
            $section = 'general';
            add_settings_section(
                $this->tag . '_settings_section',
                $this->name . ' Settings',
                function () {
                    echo '<p>Configuration options for the ' . esc_html( $this->name ) . ' plugin.</p>';
                },
                $section
            );
            foreach ( $this->settings AS $id => $options ) {
                $options['id'] = $id;
                add_settings_field(
                    $this->tag . '_' . $id . '_settings',
                    $id,
                    array( &$this, 'settings_field' ),
                    $section,
                    $this->tag . '_settings_section',
                    $options
                );
            }
        }

        protected function settings_field( array $options = array() ) {
            $atts = array(
                'id' => $this->tag . '_' . $options['id'],
                'name' => $this->tag . '[' . $options['id'] . ']',
                'type' => ( isset( $options['type'] ) ? $options['type'] : 'text' ),
                'class' => 'small-text',
                'value' => ( array_key_exists( 'default', $options ) ? $options['default'] : null )
            );
            if ( isset( $this->options[$options['id']] ) ) {
                $atts['value'] = $this->options[$options['id']];
            }
            if ( isset( $options['placeholder'] ) ) {
                $atts['placeholder'] = $options['placeholder'];
            }
            if ( isset( $options['type'] ) && $options['type'] == 'checkbox' ) {
                if ( $atts['value'] ) {
                    $atts['checked'] = 'checked';
                }
                $atts['value'] = true;
            }
            array_walk( $atts, function( &$item, $key ) {
                $item = esc_attr( $key ) . '="' . esc_attr( $item ) . '"';
            } );
            ?>
            <label>
                <input <?php echo implode( ' ', $atts ); ?> />
                <?php if ( array_key_exists( 'description', $options ) ) : ?>
                <?php esc_html_e( $options['description'] ); ?>
                <?php endif; ?>
            </label>
            <?php

            register_setting(
                $section,
                $this->tag,
                array( &$this, 'settings_validate' )
            );

        }

        protected function settings_validate( $input ) {
            $errors = array();
            foreach ( $input AS $key => $value ) {
                if ( $value == '' ) {
                    unset( $input[$key] );
                } elseif ( isset( $this->settings[$key]['validator'] ) ) {
                    switch ( $this->settings[$key]['validator'] ) {
                        case 'numeric':
                            if ( is_numeric( $value ) ) {
                                $input[$key] = intval( $value );
                            } else {
                                $errors[] = $key . ' must be a numeric value.';
                                unset( $input[$key] );
                            }
                        break;
                    }
                } else {
                    $input[$key] = strip_tags( $value );
                }
            }
            if ( count( $errors ) > 0 ) {
                add_settings_error(
                    $this->tag,
                    $this->tag,
                    implode( '<br />', $errors ),
                    'error'
                );
            }
            return $input;
        }
    }
}
