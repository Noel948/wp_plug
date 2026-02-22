<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Reviews Widget
 */
class Reviews_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-reviews';
    }

    public function get_title()
    {
        return esc_html__('Reviews & Testimonials Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-review';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_reviews',
            [
                'label' => esc_html__('Reviews', 'esnp-kit'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'reviewer_name',
            [
                'label' => esc_html__('Name', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => 'John Doe',
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => esc_html__('Rating', 'esnp-kit'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 0.5,
                'default' => 5,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Review', 'esnp-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Amazing experience with this product!',
            ]
        );

        $this->add_control(
            'reviews_list',
            [
                'label' => esc_html__('Reviews List', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['reviewer_name' => 'Alice', 'rating' => 5, 'content' => 'Highly recommended!'],
                ],
                'title_field' => '{{{ reviewer_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="esnp-reviews-container">
            <?php foreach ($settings['reviews_list'] as $item): ?>
                <div class="esnp-review-card">
                    <div class="esnp-review-rating">
                        <?php for ($i = 1; $i <= 5; $i++):
                            $class = ($i <= $item['rating']) ? 'fas fa-star' : (($i - 0.5 <= $item['rating']) ? 'fas fa-star-half-alt' : 'far fa-star');
                            ?>
                            <i class="<?php echo esc_attr($class); ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <h4 class="esnp-reviewer-name">
                        <?php echo esc_html($item['reviewer_name']); ?>
                    </h4>
                    <p class="esnp-review-content">
                        <?php echo esc_html($item['content']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
        // Schema.org JSON-LD
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => []
        ];

        foreach ($settings['reviews_list'] as $index => $item) {
            $schema['itemListElement'][] = [
                '@type' => 'Review',
                'position' => $index + 1,
                'author' => [
                    '@type' => 'Person',
                    'name' => $item['reviewer_name']
                ],
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => $item['rating'],
                    'bestRating' => 5
                ],
                'reviewBody' => $item['content']
            ];
        }
        ?>
        <script type="application/ld+json">
                    <?php echo json_encode($schema); ?>
                </script>
        <?php
    }
}
