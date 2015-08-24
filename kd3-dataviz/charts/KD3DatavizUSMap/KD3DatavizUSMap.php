<?php
/**
 *  KD3Dataviz Chart Class
 *
 * @author      Kyle Dinh
 * @category    Charts
 * @package     Charts
 * @since       1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if ( ! class_exists( 'KD3DatavizUSMap' ) ) {

    class KD3DatavizUSMap {

        private $tag;
        public $KDUtils;

        public function __construct() {
            include_once(plugin_dir_path( __FILE__ ).'../../includes/KD3DatavizConst.php');            
            include_once(plugin_dir_path( __FILE__ ).'../../includes/KDUtils.php');

            $this->tag = KD3DatavizConst::tag;
            $this->KDUtils = new KDUtils();
        }

        // [kd3dataviz-usmap height="300" class="myclass"]
        public function shortcode_usmap( $atts, $content = null ) {
            extract( shortcode_atts( array(
                'width' => false,
                'height' => false,
                'class' => false
            ), $atts ) );

            $this->_enqueue();

            $classes = $this->KDUtils->make_classes('kd3dataviz-usmap');
            $styles = $this->KDUtils->make_styles($width, $height);

            ob_start();
            echo($this->KDUtils->draw_div('kd3dataviz-usmap', $classes, $styles));
            return ob_get_clean();
        }

        // [kd3dataviz-usmap-donut height="300" class="myclass"]
        public function shortcode_usmap_donut( $atts, $content = null ) {
            extract( shortcode_atts( array(
                'width' => false,
                'height' => false,
                'class' => false
            ), $atts ) );

            $classes = $this->KDUtils->make_classes('kd3dataviz-usmap-donut');
            $styles = $this->KDUtils->make_styles($width, $height);

            ob_start();
            echo($this->KDUtils->draw_div('kd3dataviz-usmap-donut', $classes, $styles));
            return ob_get_clean();
        }

        protected function _enqueue() {

            $plugin_path = plugins_url().'/kd3-dataviz/'; 

            if ( !wp_script_is( $this->tag, 'enqueued' ) ) {
                wp_enqueue_script(
                    'd3js-' . $this->tag,
                    $plugin_path . 'lib/d3/d3.v3.min.js'
                );
                wp_enqueue_script(
                    'topojson-' . $this->tag,
                    $plugin_path . 'lib/d3/topojson.v1.min.js'
                );
                wp_enqueue_script(
                    'queue-' . $this->tag,
                    $plugin_path . 'lib/d3/queue.js'
                );  
                wp_enqueue_script(
                    'datamap-' . $this->tag,
                    $plugin_path . 'lib/d3/datamaps.usa.min.js'
                );     
                wp_enqueue_style(
                    'kd3dataviz-usmap-css',
                    $plugin_path . 'charts/KD3DatavizUSMap/kd3dataviz-usmap.css',
                    array(),
                    '1.0.0'
                );   
                wp_enqueue_script(
                    'kd3dataviz-usmap-js' . $this->tag,
                    $plugin_path . 'charts/KD3DatavizUSMap/kd3dataviz-usmap.js'
                );                                         

            }
        }
    }
}
