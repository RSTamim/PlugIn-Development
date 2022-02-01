<?php
/**
 * Plugin Name: Ramlit Academy
 * Description: A tutorial plugin for weDevs Academy
 * Plugin URI: https://Dragon.co
 * Author: Tareq Hasan
 * Author URI: https://Dragon.co
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Ramlit_Academy {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Ramlit_Academy
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'RM_ACADEMY_VERSION', self::version );
        define( 'RM_ACADEMY_FILE', __FILE__ );
        define( 'RM_ACADEMY_PATH', __DIR__ );
        define( 'RM_ACADEMY_URL', plugins_url( '', RM_ACADEMY_FILE ) );
        define( 'RM_ACADEMY_ASSETS', RM_ACADEMY_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new WeDevs\Academy\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Ramlit\Academy\Ajax();
        }

        if ( is_admin() ) {
            new Ramlit\Academy\Admin();
        } else {
            new Ramlit\Academy\Frontend();
        }

    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Ramlit\Academy\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Ramlit_Academy
 */
function Ramlit_academy() {
    return Ramlit_Academy::init();
}

// kick-off the plugin
ramlit_academy();
