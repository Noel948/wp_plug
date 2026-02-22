<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Testimonial Carousel Widget (Swiper JS)
 */
class Testimonial_Carousel extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-testimonial-carousel';
    }

    public function get_title()
    {
        return esc_html__('Testimonial Carousel Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_testimonials',
            [
                'label' => esc_html__('Testimonials', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'testimonial_content',
            [
                'label' => esc_html__('Content', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('This plugin is amazing! It changed my workflow completely.', 'esnp-kit'),
            ]
        );

        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => 'John Doe',
            ]
        );

        $repeater->add_control(
            'testimonial_job',
            [
                'label' => esc_html__('Job Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => 'CEO, Tech Corp',
            ]
        );

        $this->add_control(
            'testimonials_list',
            [
                'label' => esc_html__('Testimonials', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['testimonial_name' => 'John Doe'],
                    ['testimonial_name' => 'Jane Smith'],
                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-testimonial-carousel swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($settings['testimonials_list'] as $item): ?>
                    <div class="swiper-slide esnp-testimonial-item">
                        <div class="esnp-testimonial__content">
                            <p>
                                <?php echo esc_html($item['testimonial_content']); ?>
                            </p>
                        </div>
                        <div class="esnp-testimonial__meta">
                            <h4 class="esnp-testimonial__name">
                                <?php echo esc_html($item['testimonial_name']); ?>
                            </h4>
                            <span class="esnp-testimonial__job">
                                <?php echo esc_html($item['testimonial_job']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination/Navigation if needed -->
            <div class="swiper-pagination"></div>
        </div>
        <?php
    }
}
