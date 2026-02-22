<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Share Buttons Widget
 */
class Share_Buttons extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-share-buttons';
    }

    public function get_title()
    {
        return esc_html__('Share Buttons Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-share-buttons';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_buttons',
            [
                'label' => esc_html__('Buttons', 'esnp-kit'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'network',
            [
                'label' => esc_html__('Network', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter (X)',
                    'linkedin' => 'LinkedIn',
                    'whatsapp' => 'WhatsApp',
                    'email' => 'Email',
                ],
                'default' => 'facebook',
            ]
        );

        $repeater->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'share_list',
            [
                'label' => esc_html__('Share Networks', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['network' => 'facebook', 'label' => 'Facebook'],
                    ['network' => 'twitter', 'label' => 'Twitter'],
                ],
                'title_field' => '{{{ network }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon-text' => 'Icon & Text',
                    'icon' => 'Icon Only',
                    'text' => 'Text Only',
                ],
                'default' => 'icon-text',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $current_url = urlencode(get_permalink());
        $current_title = urlencode(get_the_title());

        $networks = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$current_url}",
            'twitter' => "https://twitter.com/intent/tweet?text={$current_title}&url={$current_url}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$current_url}",
            'whatsapp' => "https://api.whatsapp.com/send?text={$current_title}%20{$current_url}",
            'email' => "mailto:?subject={$current_title}&body={$current_url}",
        ];
        ?>
        <div class="esnp-share-buttons esnp-view-<?php echo esc_attr($settings['view']); ?>">
            <?php foreach ($settings['share_list'] as $item):
                $network = $item['network'];
                $url = $networks[$network] ?? '';
                if (!$url)
                    continue;
                ?>
                <a href="<?php echo esc_url($url); ?>" class="esnp-share-btn esnp-share-<?php echo esc_attr($network); ?>"
                    target="_blank" rel="noopener">
                    <span class="esnp-share-icon"><i class="fab fa-<?php echo esc_attr($network); ?>"></i></span>
                    <?php if ('icon' !== $settings['view']): ?>
                        <span class="esnp-share-text">
                            <?php echo esc_html($item['label'] ?: ucfirst($network)); ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
