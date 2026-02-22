<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Table of Contents Widget
 */
class Table_Of_Contents extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-toc';
    }

    public function get_title()
    {
        return esc_html__('Table of Contents Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-table-of-contents';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_toc',
            [
                'label' => esc_html__('Table of Contents', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('On This Page', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'selectors',
            [
                'label' => esc_html__('Include Headings', 'esnp-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default' => ['h2', 'h3'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $selectors = implode(',', $settings['selectors']);
        ?>
        <div class="esnp-toc-wrapper" data-selectors="<?php echo esc_attr($selectors); ?>">
            <div class="esnp-toc-header">
                <h3 class="esnp-toc-title">
                    <?php echo esc_html($settings['title']); ?>
                </h3>
            </div>
            <nav class="esnp-toc-nav">
                <ul class="esnp-toc-list">
                    <!-- Populated by JS -->
                </ul>
            </nav>
        </div>
        <?php
    }
}
