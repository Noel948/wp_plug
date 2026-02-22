<?php
namespace ESNP_Kit\Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Design System Manager
 */
class Design_System
{

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
        add_action('wp_head', [$this, 'inject_global_vars'], 1);
    }

    public function inject_global_vars()
    {
        // Placeholder for design tokens
        // These will eventually be managed via a settings page or Elementor global site settings
        $tokens = [
            '--esnp-spacing-xs' => '0.5rem',
            '--esnp-spacing-s' => '1rem',
            '--esnp-spacing-m' => '2rem',
            '--esnp-spacing-l' => '4rem',
            '--esnp-spacing-xl' => '8rem',
            '--esnp-radius-s' => '4px',
            '--esnp-radius-m' => '8px',
            '--esnp-radius-l' => '16px',
        ];

        echo '<style id="esnp-design-tokens">:root {';
        foreach ($tokens as $key => $value) {
            echo esc_html($key) . ': ' . esc_html($value) . ';';
        }
        echo '}</style>';
    }
}
