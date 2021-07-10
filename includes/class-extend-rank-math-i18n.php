<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://kamal.pw/
 * @since      1.0.0
 *
 * @package    Extend_Rankmath
 * @subpackage Extend_Rankmath/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Extend_Rankmath
 * @subpackage Extend_Rankmath/includes
 * @author     Kamal H. <kamalhosen8920@gmail.com>
 */
class Extend_Rankmath_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'extend-rank-math',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
