<?php
/*
	Plugin Name: KD3 Dataviz
	Plugin URI: http://kyledinh.com
	Description: Plugin to implement d3js maps
	Version: 1.0.0
	Author: Kyle Dinh
	Author URI: http://kyledinh.com
	Copyright: © Kyle Dinh, Aug 2015
*/

defined('ABSPATH') or die( 'Plugin file cannot be accessed directly.' ); 

if (!class_exists('KD3Dataviz')) {
    final class KD3Dataviz {

        protected static $_instance = null;
        protected $KDUtils;
        protected $KD3DatavizSettings;
        protected $KD3DatavizUSMap;    

        protected $tag;
        protected $version;
        protected $options = array();

        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct() {
            require_once('includes/KD3DatavizConst.php');                      
            require_once('includes/KDUtils.php');
            //include_once('includes/D3DatavizSettings.php');  
            include_once('charts/KD3DatavizUSMap/KD3DatavizUSMap.php');

            $this->tag = KD3DatavizConst::tag;  // 'kd3dataviz'
            $this->version = KD3DatavizConst::version; 

            $this->KDUtils = new KDUtils();
            //$this->D3DatavizSettings = new D3DatavizSettings();
            $this->KD3DatavizUSMap = new KD3DatavizUSMap();

            add_shortcode( 'kd3dataviz-usmap', array( &$this->KD3DatavizUSMap, 'shortcode_usmap' ) );
            add_shortcode( 'kd3dataviz-usmap-donut', array( &$this->KD3DatavizUSMap, 'shortcode_usmap_donut' ) );

        }

    }
    $kd_kd3dataviz = new KD3Dataviz();
}
