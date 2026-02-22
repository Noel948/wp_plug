<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Progress Tracker Widget
 */
class Progress_Tracker extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-progress-tracker';
    }

    public function get_title()
    {
        return esc_html__('Progress Tracker Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-scroll-progress';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_tracker',
            [
                'label' => esc_html__('Tracker Settings', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'tracker_type',
            [
                'label' => esc_html__('Type', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => 'Horizontal Bar',
                    'circular' => 'Circular',
                ],
                'default' => 'horizontal',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-progress-tracker esnp-tracker-<?php echo esc_attr($settings['tracker_type']); ?>">
            <?php if ('circular' === $settings['tracker_type']): ?>
                <svg class="esnp-progress-circle" viewBox="0 0 100 100">
                    <circle class="esnp-progress-bg" cx="50" cy="50" r="45"></circle>
                    <circle class="esnp-progress-fill" cx="50" cy="50" r="45"></circle>
                </svg>
            <?php else: ?>
                <div class="esnp-progress-bar">
                    <div class="esnp-progress-fill"></div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
