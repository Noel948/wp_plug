<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Flip Box Widget
 */
class Flip_Box extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-flip-box';
    }

    public function get_title()
    {
        return esc_html__('Flip Box Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-flip-box';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_front',
            [
                'label' => esc_html__('Front Side', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'front_icon',
            [
                'label' => esc_html__('Icon', 'esnp-kit'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-rocket',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Front Side', 'esnp-kit'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_back',
            [
                'label' => esc_html__('Back Side', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Back Side', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'back_description',
            [
                'label' => esc_html__('Description', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Pushing boundaries with innovative digital solutions that scale your business.', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'esnp-kit'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'esnp-kit'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-flip-box">
            <div class="esnp-flip-box-inner">
                <div class="esnp-flip-box-front">
                    <div class="esnp-flip-box-icon">
                        <?php Icons_Manager::render_icon($settings['front_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                    <h3 class="esnp-flip-box-title">
                        <?php echo esc_html($settings['front_title']); ?>
                    </h3>
                </div>
                <div class="esnp-flip-box-back">
                    <h3 class="esnp-flip-box-title">
                        <?php echo esc_html($settings['back_title']); ?>
                    </h3>
                    <p class="esnp-flip-box-desc">
                        <?php echo esc_html($settings['back_description']); ?>
                    </p>
                    <?php if (!empty($settings['button_text'])): ?>
                        <a href="<?php echo esc_url($settings['button_link']['url']); ?>"
                            class="esnp-button esnp-button--primary">
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
