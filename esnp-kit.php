<?php
/**
 * Plugin Name: Elementor Structure & Navigation Pro Kit
 * Description: Advanced structural elements, mega menus, and global design system for Elementor.
 * Version: 1.0.0
 * Author: Noels
 * Text Domain: esnp-kit
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/Noel948/wp_plug
 *
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Main ESNP Kit Class
 */
final class ESNP_Kit
{

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.5.0';
    const MINIMUM_PHP_VERSION = '7.4';

    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
        }
    }

    public function is_compatible()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }

        return true;
    }

    public function init()
    {
        // Load the loader class
        require_once(__DIR__ . '/core/class-loader.php');
        \ESNP_Kit\Core\Loader::instance();
    }

    public function admin_notice_missing_main_plugin()
    {
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'esnp-kit'),
            '<strong>' . esc_html__('ESNP Kit', 'esnp-kit') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'esnp-kit') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_elementor_version()
    {
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'esnp-kit'),
            '<strong>' . esc_html__('ESNP Kit', 'esnp-kit') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'esnp-kit') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version()
    {
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'esnp-kit'),
            '<strong>' . esc_html__('ESNP Kit', 'esnp-kit') . '</strong>',
            '<strong>' . esc_html__('PHP', 'esnp-kit') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}

ESNP_Kit::instance();
