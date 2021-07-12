<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://kamal.pw/
 * @since             1.0.0
 * @package           Extend_Rankmath
 *
 * @wordpress-plugin
 * Plugin Name:       Extend Rank Math
 * Plugin URI:        https://kamal.pw/rank-math-extend
 * Description:       Extend Rank Math is a helper plugin for Rank Math.
 * Version:           1.0.1
 * Author:            Kamal H.
 * Author URI:        https://kamal.pw/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       extend-rank-math
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define constants
 * @since             1.0.0
 *
 */

	define( 'ERM_BASE', plugin_basename( __FILE__ ) );


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Extend_Rankmath_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-extend-rank-math-activator.php
 */
function activate_Extend_Rankmath() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-extend-rank-math-activator.php';
	Extend_Rankmath_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-extend-rank-math-deactivator.php
 */
function deactivate_Extend_Rankmath() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-extend-rank-math-deactivator.php';
	Extend_Rankmath_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Extend_Rankmath' );
register_deactivation_hook( __FILE__, 'deactivate_Extend_Rankmath' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-extend-rank-math.php';
require plugin_dir_path( __FILE__ ) . 'includes/class.settings-api.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-extend-rank-math-filter.php';

/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function rm_get_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Extend_Rankmath() {

	$plugin = new Extend_Rankmath();
	$plugin->run();

}
run_Extend_Rankmath();
