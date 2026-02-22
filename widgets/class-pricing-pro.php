<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Pricing Table Pro Widget
 */
class Pricing_Pro extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-pricing-pro';
    }

    public function get_title()
    {
        return esc_html__('Pricing Table Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-price-table';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_pricing_header',
            [
                'label' => esc_html__('Header', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Standard Plan', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => '$29',
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => esc_html__('Period', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('per month', 'esnp-kit'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_features',
            [
                'label' => esc_html__('Features', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'feature_text',
            [
                'label' => esc_html__('Feature', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Amazing Feature', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => esc_html__('Features List', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['feature_text' => esc_html__('Up to 5 Projects', 'esnp-kit')],
                    ['feature_text' => esc_html__('Basic Support', 'esnp-kit')],
                    ['feature_text' => esc_html__('Cloud Storage', 'esnp-kit')],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->end_controls_section();

        // Styles
        $this->start_controls_section(
            'section_pricing_style',
            [
                'label' => esc_html__('Table Style', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'table_padding',
            [
                'label' => esc_html__('Padding', 'esnp-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .esnp-pricing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'table_border',
                'label' => esc_html__('Border', 'esnp-kit'),
                'selector' => '{{WRAPPER}} .esnp-pricing',
            ]
        );

        $this->add_control(
            'table_border_radius',
            [
                'label' => esc_html__('Border Radius', 'esnp-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .esnp-pricing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_shadow',
                'selector' => '{{WRAPPER}} .esnp-pricing',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_style_header',
            [
                'label' => esc_html__('Header Style', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_bg',
            [
                'label' => esc_html__('Header Background', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-pricing__header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'esnp-kit'),
                'selector' => '{{WRAPPER}} .esnp-pricing__title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'esnp-kit'),
                'selector' => '{{WRAPPER}} .esnp-pricing__amount',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_style_features',
            [
                'label' => esc_html__('Features Style', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'features_color',
            [
                'label' => esc_html__('Text Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-pricing__feature' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_typography',
                'selector' => '{{WRAPPER}} .esnp-pricing__feature',
            ]
        );

        $this->end_controls_section();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-pricing">
            <div class="esnp-pricing__header">
                <h3 class="esnp-pricing__title">
                    <?php echo esc_html($settings['title']); ?>
                </h3>
                <div class="esnp-pricing__cost">
                    <span class="esnp-pricing__amount">
                        <?php echo esc_html($settings['price']); ?>
                    </span>
                    <span class="esnp-pricing__period">
                        <?php echo esc_html($settings['period']); ?>
                    </span>
                </div>
            </div>
            <ul class="esnp-pricing__features">
                <?php foreach ($settings['features'] as $feature): ?>
                    <li class="esnp-pricing__feature">
                        <?php echo esc_html($feature['feature_text']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="esnp-pricing__footer">
                <a href="#" class="esnp-button esnp-button--primary esnp-pricing__button">
                    <?php echo esc_html__('Choose Plan', 'esnp-kit'); ?>
                </a>
            </div>
        </div>
        <?php
    }
}
