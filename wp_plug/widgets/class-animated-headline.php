<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Animated Headline Widget
 */
class Animated_Headline extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-animated-headline';
    }

    public function get_title()
    {
        return esc_html__('Animated Headline', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-animated-headline';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'before_text',
            [
                'label' => esc_html__('Before Text', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('We build', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'highlight_text',
            [
                'label' => esc_html__('Highlighted Text', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Amazing', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'after_text',
            [
                'label' => esc_html__('After Text', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Websites', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label' => esc_html__('Animation Style', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'highlight',
                'options' => [
                    'highlight' => esc_html__('Highlight (Draw)', 'esnp-kit'),
                    'rotate' => esc_html__('Rotate (Flip)', 'esnp-kit'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'headline_color',
            [
                'label' => esc_html__('Text Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-animated-headline' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'highlight_color',
            [
                'label' => esc_html__('Highlight Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffcc00',
                'selectors' => [
                    '{{WRAPPER}} .esnp-headline-highlight svg path' => 'stroke: {{VALUE}};',
                ],
                'condition' => [
                    'animation_type' => 'highlight',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <h2 class="esnp-animated-headline esnp-anim-<?php echo esc_attr($settings['animation_type']); ?>">
            <span class="esnp-headline-before">
                <?php echo esc_html($settings['before_text']); ?>
            </span>
            <span class="esnp-headline-dynamic">
                <?php if ('highlight' === $settings['animation_type']): ?>
                    <span class="esnp-headline-highlight">
                        <?php echo esc_html($settings['highlight_text']); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
                            <path d="M7.7,145.6C109,125,299.9,111.2,401,114.3c41.2,1.3,73.1,10.6,83,18.3" />
                        </svg>
                    </span>
                <?php else: ?>
                    <span class="esnp-headline-rotate">
                        <?php echo esc_html($settings['highlight_text']); ?>
                    </span>
                <?php endif; ?>
            </span>
            <span class="esnp-headline-after">
                <?php echo esc_html($settings['after_text']); ?>
            </span>
        </h2>
        <?php
    }
}
