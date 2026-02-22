<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * SEO FAQ Accordion Widget
 */
class FAQ_Accordion extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-faq-accordion';
    }

    public function get_title()
    {
        return esc_html__('SEO FAQ Accordion', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-accordion';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_faq',
            [
                'label' => esc_html__('FAQ Items', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'question',
            [
                'label' => esc_html__('Question', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('What is ESNP Kit?', 'esnp-kit'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label' => esc_html__('Answer', 'esnp-kit'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('It is an advanced Elementor extension for pros.', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'faq_list',
            [
                'label' => esc_html__('FAQ List', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['question' => esc_html__('Is it fast?', 'esnp-kit'), 'answer' => esc_html__('Yes, it use zero jQuery and optimized CSS.', 'esnp-kit')],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->add_control(
            'enable_schema',
            [
                'label' => esc_html__('Enable Schema.org Markup', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        if (empty($settings['faq_list'])) {
            return;
        }

        // SEO Schema logic
        if ('yes' === $settings['enable_schema']) {
            $questions = [];
            foreach ($settings['faq_list'] as $item) {
                $questions[] = [
                    '@type' => 'Question',
                    'name' => esc_attr($item['question']),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => wp_kses_post($item['answer']),
                    ],
                ];
            }
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $questions,
            ];
            echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
        }
        ?>
        <div class="esnp-faq" id="esnp-faq-<?php echo esc_attr($id); ?>">
            <?php foreach ($settings['faq_list'] as $index => $item): ?>
                <div class="esnp-faq-item">
                    <div class="esnp-faq-question">
                        <span>
                            <?php echo esc_html($item['question']); ?>
                        </span>
                        <span class="esnp-faq-icon">+</span>
                    </div>
                    <div class="esnp-faq-answer">
                        <div class="esnp-faq-answer-inner">
                            <?php echo wp_kses_post($item['answer']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
