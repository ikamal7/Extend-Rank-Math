<?php

/**
 * filter Rank Math
 *
 *
 * @link       https://kamal.pw/
 * @since      1.0.0
 *
 * @package    Extend_Rankmath
 * @subpackage Extend_Rankmath/includes
 */

/**
 *
 * @since      1.0.0
 * @package    Extend_Rankmath
 * @subpackage Extend_Rankmath/includes
 * @author     Kamal H. <kamalhosen8920@gmail.com>
 */
class Extend_Rankmath_Filter{
    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    /**
     * Intialize class constructor
     *
     * @since      1.0.0
     */
    public function __construct($plugin_name, $version){
        $this->plugin_name = $plugin_name;
		$this->version = $version;
        add_filter( 'rank_math/metabox/power_words',[$this, 'power_words']);
        add_action('init', [$this, 'show_keyword_meta_tag']);
    }



    public function power_words($words){
        $custom_power_words = rm_get_option('custom_power_words', 'basics');
        $new_words = explode(',',trim($custom_power_words));
        return array_merge( $words, $new_words );
    }

    public function show_keyword_meta_tag(){
        $show = rm_get_option('show_keyword_meta','basics');
        if($show == 'on'){
            add_filter( 'rank_math/frontend/show_keywords', '__return_true');
        }else{
            add_filter( 'rank_math/frontend/show_keywords', '__return_false');
        }
    }

}