<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Hero Section Widget
 */
class Hero_Advanced extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-hero-advanced';
    }

    public function get_title()
    {
        return esc_html__('Advanced Hero Section', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-banner';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_hero_content',
            [
                'label' => esc_html__('Content', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hero_title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Your Amazing Hero Title', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'hero_description',
            [
                'label' => esc_html__('Description', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('A compelling description for your hero section that converts visitors.', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'hero_primary_button',
            [
                'label' => esc_html__('Primary Button Text', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Get Started', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'hero_primary_link',
            [
                'label' => esc_html__('Primary Button Link', 'esnp-kit'),
                'type' => Controls_Manager::URL,
                'default' => ['url' => '#'],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_hero_style',
            [
                'label' => esc_html__('Style', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hero_height',
            [
                'label' => esc_html__('Height (vh)', 'esnp-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['vh'],
                'range' => [
                    'vh' => ['min' => 40, 'max' => 100],
                ],
                'default' => ['unit' => 'vh', 'size' => 80],
                'selectors' => [
                    '{{WRAPPER}} .esnp-hero' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hero_background',
                'selector' => '{{WRAPPER}} .esnp-hero',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .esnp-hero__title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="esnp-hero">
            <div class="esnp-hero__overlay"></div>
            <div class="esnp-hero__container">
                <h1 class="esnp-hero__title">
                    <?php echo esc_html($settings['hero_title']); ?>
                </h1>
                <p class="esnp-hero__description">
                    <?php echo esc_html($settings['hero_description']); ?>
                </p>
                <div class="esnp-hero__actions">
                    <?php if (!empty($settings['hero_primary_button'])): ?>
                        <a href="<?php echo esc_url($settings['hero_primary_link']['url']); ?>"
                            class="esnp-button esnp-button--primary">
                            <?php echo esc_html($settings['hero_primary_button']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
