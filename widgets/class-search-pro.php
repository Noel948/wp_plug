<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Search Pro Widget
 */
class Search_Pro extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-search-pro';
    }

    public function get_title()
    {
        return esc_html__('Search Pro (AJAX)', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-search';
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
                'label' => esc_html__('Search Bar', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__('Placeholder', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Search...', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'show_ajax_results',
            [
                'label' => esc_html__('Live AJAX Results', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'search_icon',
            [
                'label' => esc_html__('Icon', 'esnp-kit'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'solid',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Design', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label' => esc_html__('Input Background', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-search-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        ?>
        <div class="esnp-search-wrapper" id="esnp-search-<?php echo esc_attr($id); ?>"
            data-ajax="<?php echo esc_attr($settings['show_ajax_results']); ?>">
            <form class="esnp-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <div class="esnp-search-input-group">
                    <input type="text" name="s" class="esnp-search-input"
                        placeholder="<?php echo esc_attr($settings['placeholder']); ?>" autocomplete="off">
                    <button type="submit" class="esnp-search-submit">
                        <?php Icons_Manager::render_icon($settings['search_icon'], ['aria-hidden' => 'true']); ?>
                    </button>
                </div>
                <div class="esnp-search-results"></div>
            </form>
        </div>
        <?php
    }
}
