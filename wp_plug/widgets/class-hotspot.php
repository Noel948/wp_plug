<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Hotspot Widget
 */
class Hotspot extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-hotspot';
    }

    public function get_title()
    {
        return esc_html__('Hotspot Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-image-hotspot';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Image', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'esnp-kit'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_hotspots',
            [
                'label' => esc_html__('Hotspots', 'esnp-kit'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Point', 'esnp-kit'),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Tooltip Content', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Details about this part of the image.', 'esnp-kit'),
            ]
        );

        $repeater->add_control(
            'pos_left',
            [
                'label' => esc_html__('Left (%)', 'esnp-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 50],
            ]
        );

        $repeater->add_control(
            'pos_top',
            [
                'label' => esc_html__('Top (%)', 'esnp-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 50],
            ]
        );

        $this->add_control(
            'hotspots_list',
            [
                'label' => esc_html__('Hotspots List', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['label' => 'Feature 1', 'pos_left' => ['size' => 20], 'pos_top' => ['size' => 30]],
                ],
                'title_field' => '{{{ label }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (empty($settings['image']['url']))
            return;
        ?>
        <div class="esnp-hotspot-wrapper">
            <img src="<?php echo esc_url($settings['image']['url']); ?>" class="esnp-hotspot-main-image">

            <div class="esnp-hotspots">
                <?php foreach ($settings['hotspots_list'] as $item): ?>
                    <div class="esnp-hotspot-point"
                        style="left: <?php echo $item['pos_left']['size']; ?>%; top: <?php echo $item['pos_top']['size']; ?>%;">
                        <div class="esnp-hotspot-dot"></div>
                        <div class="esnp-hotspot-tooltip">
                            <strong>
                                <?php echo esc_html($item['label']); ?>
                            </strong>
                            <p>
                                <?php echo esc_html($item['content']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
