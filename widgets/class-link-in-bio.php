<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Link in Bio Widget
 */
class Link_In_Bio extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-link-in-bio';
    }

    public function get_title()
    {
        return esc_html__('Link in Bio Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-link';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_profile',
            [
                'label' => esc_html__('Profile', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'profile_image',
            [
                'label' => esc_html__('Profile Image', 'esnp-kit'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'profile_name',
            [
                'label' => esc_html__('Name', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('@yourbrand', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'profile_bio',
            [
                'label' => esc_html__('Bio', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Digital Creator | Innovating Web Solutions', 'esnp-kit'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_links',
            [
                'label' => esc_html__('Links', 'esnp-kit'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'link_text',
            [
                'label' => esc_html__('Link Text', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Visit Website', 'esnp-kit'),
            ]
        );

        $repeater->add_control(
            'link_url',
            [
                'label' => esc_html__('URL', 'esnp-kit'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'esnp-kit'),
            ]
        );

        $repeater->add_control(
            'is_featured',
            [
                'label' => esc_html__('Featured (Pulse)', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'links_list',
            [
                'label' => esc_html__('Links List', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['link_text' => 'Join our Newsletter', 'link_url' => ['url' => '#']],
                    ['link_text' => 'Portfolio', 'link_url' => ['url' => '#']],
                ],
                'title_field' => '{{{ link_text }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style_links',
            [
                'label' => esc_html__('Link Design', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'link_bg_color',
            [
                'label' => esc_html__('Background Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .esnp-bio-link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_text_color',
            [
                'label' => esc_html__('Text Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .esnp-bio-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-bio-wrapper">
            <div class="esnp-bio-header">
                <?php if (!empty($settings['profile_image']['url'])): ?>
                    <div class="esnp-bio-image">
                        <img src="<?php echo esc_url($settings['profile_image']['url']); ?>"
                            alt="<?php echo esc_attr($settings['profile_name']); ?>">
                    </div>
                <?php endif; ?>
                <h3 class="esnp-bio-name">
                    <?php echo esc_html($settings['profile_name']); ?>
                </h3>
                <p class="esnp-bio-tagline">
                    <?php echo esc_html($settings['profile_bio']); ?>
                </p>
            </div>

            <div class="esnp-bio-links">
                <?php foreach ($settings['links_list'] as $item):
                    $featured_class = ('yes' === $item['is_featured']) ? 'esnp-bio-featured' : '';
                    ?>
                    <a href="<?php echo esc_url($item['link_url']['url']); ?>"
                        class="esnp-bio-link <?php echo $featured_class; ?>">
                        <?php echo esc_html($item['link_text']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
