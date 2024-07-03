<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package Post_Content_Warnings
 */

$_pwcc_wpcli_commands_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_pwcc_wpcli_commands_tests_dir ) {
	$_pwcc_wpcli_commands_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

// Forward custom PHPUnit Polyfills configuration to PHPUnit bootstrap file.
$_pwcc_wpcli_commands_phpunit_polyfills_path = __DIR__ . '/../vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
if ( false !== $_pwcc_wpcli_commands_phpunit_polyfills_path ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound -- test suite constant.
	define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $_pwcc_wpcli_commands_phpunit_polyfills_path );
}

if ( ! file_exists( "{$_pwcc_wpcli_commands_tests_dir}/includes/functions.php" ) ) {
	echo "Could not find {$_pwcc_wpcli_commands_tests_dir}/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once "{$_pwcc_wpcli_commands_tests_dir}/includes/functions.php";

/**
 * Manually load the plugin being tested.
 */
function _pwcc_wpcli_commands_manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/wpcli-dev-helper-commands.php';
}

tests_add_filter( 'muplugins_loaded', '_pwcc_wpcli_commands_manually_load_plugin' );

// Start up the WP testing environment.
require "{$_pwcc_wpcli_commands_tests_dir}/includes/bootstrap.php";
