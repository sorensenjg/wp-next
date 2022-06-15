<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sorensenjg.com
 * @since             1.0.0
 * @package           WP_Next
 *
 * @wordpress-plugin
 * Plugin Name:       WP Next
 * Plugin URI:        https://github.com/sorensenjg/wp-next
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Justin Sorensen <hey@sorensenjg.com>
 * Author URI:        https://sorensenjg.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-next
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_NEXT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-next-activator.php
 */
function activate_wp_next() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-next-activator.php';
	WP_Next_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-next-deactivator.php
 */
function deactivate_wp_next() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-next-deactivator.php';
	WP_Next_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_next' );
register_deactivation_hook( __FILE__, 'deactivate_wp_next' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-next.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_next() {

	$plugin = new WP_Next();
	$plugin->run();

}
run_wp_next();
