<?php
/**
 * Utils Class
 *
 * @author      Kyle Dinh
 * @category    Util
 * @package     Utils
 * @since       1
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if ( ! class_exists( 'KDUtils' ) ) {
    class KDUtils {

        public function __construct() {}

        public function make_classes($class) {
            $classes = array();
            if ( !empty( $class ) ) {
                $classes[] = esc_attr( $class );
            }
            return $classes;
        }

        public function make_styles($width, $height) {
            $styles = array();
            if ( !empty($width) && is_numeric($width) ) {
                $styles[] = esc_attr( 'width: ' . $width . 'px;' );
            }
            if ( !empty($height) && is_numeric($height) ) {
                if (empty($styles)) {
                    $styles[] = esc_attr( 'height: ' . $height . 'px;' );
                } else {
                    array_push($styles, esc_attr( ' height: ' . $height . 'px;' ));
                }
            }
            return $styles;
        }

        public function draw_div($id, $classes, $styles) {
            $buff = '<div';
            if (!is_null($id)) { $buff = $buff . ' id="' . $id . '"'; }
            if (!empty($classes)) { $buff = $buff . ' class="' . implode( ' ', $classes ) . '"'; }
            if (!empty($styles)) { $buff = $buff . ' style="' . implode( ' ', $styles ) . '"'; }
            $buff = $buff . '></div>';
            return $buff;
        }
    }
}
