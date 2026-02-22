<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Mega Navigation Widget
 */
class Mega_Nav extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-mega-nav';
    }

    public function get_title()
    {
        return esc_html__('Mega Navigation Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    public function get_keywords()
    {
        return ['menu', 'navigation', 'mega menu', 'mega'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Menu Items', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Menu Item', 'esnp-kit'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'esnp-kit'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'esnp-kit'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'is_mega',
            [
                'label' => esc_html__('Is Mega Menu?', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $sub_repeater = new Repeater();

        $sub_repeater->add_control(
            'sub_item_title',
            [
                'label' => esc_html__('Sub Item Title', 'esnp-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Sub Item', 'esnp-kit'),
                'label_block' => true,
            ]
        );

        $sub_repeater->add_control(
            'sub_item_link',
            [
                'label' => esc_html__('Sub Item Link', 'esnp-kit'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'sub_menu_items',
            [
                'label' => esc_html__('Sub Menu Items', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $sub_repeater->get_controls(),
                'title_field' => '{{{ sub_item_title }}}',
                'condition' => [
                    'is_mega' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label' => esc_html__('Menu Items', 'esnp-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => esc_html__('Home', 'esnp-kit'),
                    ],
                    [
                        'item_title' => esc_html__('Services', 'esnp-kit'),
                        'is_mega' => 'yes',
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();

        // Behavior Section
        $this->start_controls_section(
            'section_behavior',
            [
                'label' => esc_html__('Behavior & Mobile', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sticky_header',
            [
                'label' => esc_html__('Sticky Header', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'hide_on_scroll',
            [
                'label' => esc_html__('Hide on Scroll Down', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'sticky_header' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mobile_offcanvas',
            [
                'label' => esc_html__('Mobile Off-canvas', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // WooCommerce Section
        $this->start_controls_section(
            'section_woocommerce',
            [
                'label' => esc_html__('WooCommerce Cart', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_cart',
            [
                'label' => esc_html__('Show Cart Icon', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'esnp-kit'),
                'label_off' => esc_html__('No', 'esnp-kit'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'cart_style',
            [
                'label' => esc_html__('Cart Style', 'esnp-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon_count',
                'options' => [
                    'icon_only' => esc_html__('Icon Only', 'esnp-kit'),
                    'icon_count' => esc_html__('Icon + Count', 'esnp-kit'),
                    'icon_subtotal' => esc_html__('Icon + Subtotal', 'esnp-kit'),
                ],
                'condition' => [
                    'show_cart' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Styles Section
        $this->start_controls_section(
            'section_style_menu',
            [
                'label' => esc_html__('Menu Style', 'esnp-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_text_color',
            [
                'label' => esc_html__('Text Color', 'esnp-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .esnp-nav-item-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['menu_items'])) {
            return;
        }

        $wrapper_classes = ['esnp-mega-nav-wrapper'];
        if ('yes' === $settings['sticky_header']) {
            $wrapper_classes[] = 'esnp-sticky-header';
        }

        $this->add_render_attribute('wrapper', [
            'class' => $wrapper_classes,
            'data-hide-on-scroll' => $settings['hide_on_scroll'],
            'id' => 'esnp-nav-' . $this->get_id(),
        ]);
        ?>
                <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                    <div class="esnp-nav-container">
                        <button class="esnp-mobile-toggle" data-target="esnp-nav-list-<?php echo $this->get_id(); ?>">
                            <span class="esnp-toggle-bar"></span>
                            <span class="esnp-toggle-bar"></span>
                            <span class="esnp-toggle-bar"></span>
                        </button>

                        <nav class="esnp-nav-main" id="esnp-nav-list-<?php echo $this->get_id(); ?>">
                            <ul class="esnp-nav-list">
                                <?php foreach ($settings['menu_items'] as $item):
                                    $is_mega = ('yes' === $item['is_mega']);
                                    ?>
                                        <li class="esnp-nav-item <?php echo $is_mega ? 'esnp-has-mega' : ''; ?>">
                                            <a href="<?php echo esc_url($item['item_link']['url']); ?>" class="esnp-nav-item-link">
                                                <?php echo esc_html($item['item_title']); ?>
                                            </a>
                                            <?php if ($is_mega && !empty($item['sub_menu_items'])): ?>
                                                    <div class="esnp-mega-dropdown">
                                                        <div class="esnp-mega-dropdown-inner">
                                                            <ul class="esnp-sub-menu">
                                                                <?php foreach ($item['sub_menu_items'] as $sub_item): ?>
                                                                        <li class="esnp-sub-item">
                                                                            <a href="<?php echo esc_url($sub_item['sub_item_link']['url']); ?>"
                                                                                class="esnp-sub-link">
                                                                                <?php echo esc_html($sub_item['sub_item_title']); ?>
                                                                            </a>
                                                                        </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                            <?php endif; ?>
                                        </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>

                        <?php if ('yes' === $settings['show_cart'] && class_exists('WooCommerce')): ?>
                                <div class="esnp-nav-cart">
                                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="esnp-nav-cart-toggle">
                                        <span class="esnp-cart-icon">🛒</span>
                                        <?php if ($settings['cart_style'] === 'icon_count'): ?>
                                                <span class="esnp-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                        <?php elseif ($settings['cart_style'] === 'icon_subtotal'): ?>
                                                <span class="esnp-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <div class="esnp-mini-cart">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                        <?php endif; ?>
                    </div>
                    <?php
    }
}
