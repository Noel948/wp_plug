<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Container Extender Widget
 */
class Container_Extender extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-container-extender';
    }

    public function get_title()
    {
        return esc_html__('Container Extender Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-container';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_layout_ext',
            [
                'label' => esc_html__('Advanced Layout', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'custom_grid_cols',
            [
                'label' => esc_html__('Grid Columns (CSS Grid)', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Example: repeat(3, 1fr) or 1fr 2fr', 'esnp-kit'),
                'selectors' => [
                    '{{WRAPPER}} .esnp-grid-container' => 'display: grid; grid-template-columns: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'fluid_spacing',
            [
                'label' => esc_html__('Fluid Spacing (Clamp)', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Example: clamp(1rem, 5vw, 3rem)', 'esnp-kit'),
                'selectors' => [
                    '{{WRAPPER}} .esnp-grid-container' => 'padding: {{VALUE}}; gap: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'aspect_ratio',
            [
                'label' => esc_html__('Aspect Ratio', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'esnp-kit'),
                    '1/1' => esc_html__('1:1 Square', 'esnp-kit'),
                    '16/9' => esc_html__('16:9 Video', 'esnp-kit'),
                    '4/3' => esc_html__('4:3 Standard', 'esnp-kit'),
                    'custom' => esc_html__('Custom', 'esnp-kit'),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .esnp-grid-container' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_custom_breakpoints',
            [
                'label' => esc_html__('Custom Breakpoints (Pro)', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'breakpoint_max',
            [
                'label' => esc_html__('Max Width (px)', 'esnp-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 768,
            ]
        );

        $repeater->add_control(
            'grid_cols_override',
            [
                'label' => esc_html__('Grid Columns Override', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '1fr',
            ]
        );

        $this->add_control(
            'breakpoints_list',
            [
                'label' => esc_html__('Breakpoints', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => 'max-width: {{{ breakpoint_max }}}px',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        // Generate Dynamic CSS for Breakpoints
        if (!empty($settings['breakpoints_list'])) {
            echo '<style>';
            foreach ($settings['breakpoints_list'] as $item) {
                if (!empty($item['grid_cols_override'])) {
                    echo '@media (max-width: ' . esc_attr($item['breakpoint_max']) . 'px) {';
                    echo ' #esnp-grid-' . $id . ' { grid-template-columns: ' . esc_attr($item['grid_cols_override']) . ' !important; }';
                    echo '}';
                }
            }
            echo '</style>';
        }
        ?>
                <div class="esnp-grid-container" id="esnp-grid-<?php echo $id; ?>">
                    <div class="esnp-container-inner">
                        <?php \Elementor\Plugin::instance()->widgets_manager->get_widget_types('inner-section')->render(); ?>
                    </div>
                </div>
                <?php
    }
}
