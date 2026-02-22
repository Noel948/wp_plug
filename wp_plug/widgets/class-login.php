<?php
namespace ESNP_Kit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Login Widget
 */
class Login_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'esnp-login';
    }

    public function get_title()
    {
        return esc_html__('Login Pro', 'esnp-kit');
    }

    public function get_icon()
    {
        return 'eicon-lock-user';
    }

    public function get_categories()
    {
        return ['esnp-kit'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Form Fields', 'esnp-kit'),
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => esc_html__('Show Labels', 'esnp-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'redirect_after_login',
            [
                'label' => esc_html__('Redirect After Login', 'esnp-kit'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://yoursite.com/dashboard',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $redirect = !empty($settings['redirect_after_login']['url']) ? $settings['redirect_after_login']['url'] : home_url();

        if (is_user_logged_in() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            echo '<div class="esnp-login-message">' . esc_html__('You are already logged in.', 'esnp-kit') . ' <a href="' . wp_logout_url(get_permalink()) . '">' . esc_html__('Logout', 'esnp-kit') . '</a></div>';
            return;
        }

        $args = [
            'echo' => true,
            'redirect' => $redirect,
            'form_id' => 'esnp-loginform-' . $this->get_id(),
            'label_username' => $settings['show_labels'] === 'yes' ? __('Username or Email Address') : '',
            'label_password' => $settings['show_labels'] === 'yes' ? __('Password') : '',
            'label_remember' => __('Remember Me'),
            'label_log_in' => __('Log In'),
            'remember' => true,
            'value_username' => '',
            'value_remember' => false,
        ];
        ?>
        <div class="esnp-login-container">
            <?php wp_login_form($args); ?>
            <div class="esnp-login-footer">
                <a href="<?php echo wp_lostpassword_url(); ?>">
                    <?php _e('Lost your password?'); ?>
                </a>
            </div>
        </div>
        <?php
    }
}
