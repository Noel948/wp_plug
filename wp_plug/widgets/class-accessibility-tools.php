<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Accessibility Tools Widget
 */
class Accessibility_Tools extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-ally-tools';
    }

    public function get_title()
    {
        return esc_html__('Accessibility (Ally) Tools', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-accessibility';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_ally',
            [
                'label' => esc_html__('Allly Settings', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => esc_html__('Position', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'bottom-right' => 'Bottom Right',
                    'bottom-left' => 'Bottom Left',
                    'top-right' => 'Top Right',
                    'top-left' => 'Top Left',
                ],
                'default' => 'bottom-right',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-ally-wrapper esnp-ally-<?php echo esc_attr($settings['position']); ?>">
            <button class="esnp-ally-toggle" aria-label="Open Accessibility Menu">
                <i class="fas fa-universal-access"></i>
            </button>
            <div class="esnp-ally-menu">
                <h4 class="esnp-ally-title">
                    <?php esc_html_e('Accessibility Tools', 'esnp-kit'); ?>
                </h4>
                <ul class="esnp-ally-list">
                    <li><button data-ally="contrast">
                            <?php esc_html_e('High Contrast', 'esnp-kit'); ?>
                        </button></li>
                    <li><button data-ally="grayscale">
                            <?php esc_html_e('Grayscale', 'esnp-kit'); ?>
                        </button></li>
                    <li><button data-ally="font-size">
                            <?php esc_html_e('Increase Font Size', 'esnp-kit'); ?>
                        </button></li>
                    <li><button data-ally="reset">
                            <?php esc_html_e('Reset Settings', 'esnp-kit'); ?>
                        </button></li>
                </ul>
            </div>
        </div>
        <?php
    }
}
