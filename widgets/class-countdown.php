<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Countdown Widget
 */
class Countdown extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-countdown';
    }

    public function get_title()
    {
        return esc_html__('Countdown Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_countdown',
            [
                'label' => esc_html__('Countdown', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label' => esc_html__('Due Date', 'esnp-kit'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i', strtotime('+1 day')),
            ]
        );

        $this->add_control(
            'show_days',
            [
                'label' => esc_html__('Days', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = 'esnp-countdown-' . $this->get_id();
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="esnp-countdown"
            data-date="<?php echo esc_attr($settings['due_date']); ?>">
            <?php if ('yes' === $settings['show_days']): ?>
                <div class="esnp-countdown-item">
                    <span class="esnp-countdown-value esnp-days">00</span>
                    <span class="esnp-countdown-label">
                        <?php esc_html_e('Days', 'esnp-kit'); ?>
                    </span>
                </div>
            <?php endif; ?>
            <div class="esnp-countdown-item">
                <span class="esnp-countdown-value esnp-hours">00</span>
                <span class="esnp-countdown-label">
                    <?php esc_html_e('Hours', 'esnp-kit'); ?>
                </span>
            </div>
            <div class="esnp-countdown-item">
                <span class="esnp-countdown-value esnp-minutes">00</span>
                <span class="esnp-countdown-label">
                    <?php esc_html_e('Minutes', 'esnp-kit'); ?>
                </span>
            </div>
            <div class="esnp-countdown-item">
                <span class="esnp-countdown-value esnp-seconds">00</span>
                <span class="esnp-countdown-label">
                    <?php esc_html_e('Seconds', 'esnp-kit'); ?>
                </span>
            </div>
        </div>
        <?php
    }
}
