<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Lottie Widget
 */
class Lottie_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-lottie';
    }

    public function get_title()
    {
        return esc_html__('Lottie Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-lottie';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_lottie',
            [
                'label' => esc_html__('Lottie', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'lottie_url',
            [
                'label' => esc_html__('JSON URL', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://assets2.lottiefiles.com/packages/lf20_...json',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'esnp-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 1],
                'range' => [
                    'px' => ['min' => 0.1, 'max' => 5, 'step' => 0.1],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = 'esnp-lottie-' . $this->get_id();
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="esnp-lottie-container"
            data-lottie-url="<?php echo esc_url($settings['lottie_url']); ?>" data-loop="<?php echo $settings['loop']; ?>"
            data-autoplay="<?php echo $settings['autoplay']; ?>" data-speed="<?php echo $settings['speed']['size']; ?>">
        </div>
        <?php
    }
}
