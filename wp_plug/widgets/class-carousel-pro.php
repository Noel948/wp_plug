<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Carousel Pro Widget
 */
class Carousel_Pro extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-carousel-pro';
    }

    public function get_title()
    {
        return esc_html__('Carousel & Slides Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__('Slides', 'esnp-kit'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_image',
            [
                'label' => esc_html__('Image', 'esnp-kit'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'slide_title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Slide Title', 'esnp-kit'),
            ]
        );

        $repeater->add_control(
            'slide_description',
            [
                'label' => esc_html__('Description', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Add a compelling description for this slide to engage your users.', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'slides_list',
            [
                'label' => esc_html__('Slides List', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['slide_title' => 'Innovative Design', 'slide_description' => 'Modern layouts for modern brands.'],
                    ['slide_title' => 'Next-Gen Performance', 'slide_description' => 'Lightning fast loading speeds.'],
                ],
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Slider Settings', 'esnp-kit'),
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
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite Loop', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slider_id = 'esnp-carousel-' . $this->get_id();
        ?>
        <div id="<?php echo esc_attr($slider_id); ?>" class="esnp-carousel-pro"
            data-autoplay="<?php echo $settings['autoplay']; ?>" data-pause="<?php echo $settings['pause_on_hover']; ?>"
            data-infinite="<?php echo $settings['infinite']; ?>">

            <div class="esnp-carousel-track">
                <?php foreach ($settings['slides_list'] as $index => $item): ?>
                    <div class="esnp-carousel-slide <?php echo (0 === $index) ? 'esnp-is-active' : ''; ?>">
                        <?php if (!empty($item['slide_image']['url'])): ?>
                            <div class="esnp-carousel-bg"
                                style="background-image: url('<?php echo esc_url($item['slide_image']['url']); ?>');"></div>
                        <?php endif; ?>
                        <div class="esnp-carousel-content">
                            <h2 class="esnp-carousel-title">
                                <?php echo esc_html($item['slide_title']); ?>
                            </h2>
                            <p class="esnp-carousel-desc">
                                <?php echo esc_html($item['slide_description']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="esnp-carousel-nav">
                <button class="esnp-carousel-prev" aria-label="Previous Slide">‹</button>
                <button class="esnp-carousel-next" aria-label="Next Slide">›</button>
            </div>

            <div class="esnp-carousel-dots">
                <?php foreach ($settings['slides_list'] as $index => $item): ?>
                    <span class="esnp-carousel-dot <?php echo (0 === $index) ? 'esnp-is-active' : ''; ?>"
                        data-index="<?php echo $index; ?>"></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
