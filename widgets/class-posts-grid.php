<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Posts Grid Widget
 */
class Posts_Grid extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-posts-grid';
    }

    public function get_title()
    {
        return esc_html__('Posts & Portfolio Grid', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Query', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => [
                    'post' => esc_html__('Posts', 'esnp-kit'),
                    'page' => esc_html__('Pages', 'esnp-kit'),
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Count', 'esnp-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'esnp-kit'),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .esnp-posts-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__('Column Gap', 'esnp-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 30, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .esnp-posts-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style_card',
            [
                'label' => esc_html__('Card', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Padding', 'esnp-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .esnp-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'label' => esc_html__('Background', 'esnp-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .esnp-post-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => esc_html__('Border', 'esnp-kit'),
                'selector' => '{{WRAPPER}} .esnp-post-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'esnp-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .esnp-post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .esnp-post-card',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Typography & Content', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .esnp-post-title',
            ]
        );

        $this->add_control(
            'heading_excerpt',
            [
                'label' => esc_html__('Excerpt', 'esnp-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .esnp-post-excerpt',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $query_args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
        ];

        $query = new \WP_Query($query_args);

        if ($query->have_posts()):
            ?>
            <div class="esnp-posts-grid">
                <?php while ($query->have_posts()):
                    $query->the_post(); ?>
                    <article class="esnp-post-card">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="esnp-post-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="esnp-post-content">
                            <h3 class="esnp-post-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="esnp-post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="esnp-post-more">
                                <?php esc_html_e('Read More', 'esnp-kit'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php
            wp_reset_postdata();
        endif;
    }
}
