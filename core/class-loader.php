<?php
namespace ESNP_Kit\Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Loader Class
 */
class Loader
{

    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    private function define_constants()
    {
        define('ESNP_PATH', plugin_dir_path(dirname(__FILE__)));
        define('ESNP_URL', plugin_dir_url(dirname(__FILE__)));
        define('ESNP_ASSETS_URL', ESNP_URL . 'assets/');
    }

    private function includes()
    {
        require_once(ESNP_PATH . 'core/class-design-system.php');
    }

    private function init_hooks()
    {
        // Register Widget Category
        add_action('elementor/elements/categories_registered', [$this, 'register_widget_categories']);

        // Register Widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);

        // Load Assets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        // AJAX Search
        add_action('wp_ajax_esnp_ajax_search', [$this, 'ajax_search_handler']);
        add_action('wp_ajax_nopriv_esnp_ajax_search', [$this, 'ajax_search_handler']);

        // Initialize Design System
        Design_System::instance();

        // Booking Submission
        add_action('wp_ajax_esnp_booking_submit', [$this, 'booking_submit_handler']);
        add_action('wp_ajax_nopriv_esnp_booking_submit', [$this, 'booking_submit_handler']);
    }

    public function booking_submit_handler()
    {
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
        $time = isset($_POST['time']) ? sanitize_text_field($_POST['time']) : '';

        if (!$name || !$email || !$date || !$time) {
            wp_send_json_error(['message' => __('Please fill all fields.', 'esnp-kit')]);
        }

        // Simulate success
        wp_send_json_success(['message' => sprintf(__('Thank you %s! Your booking for %s at %s is confirmed.', 'esnp-kit'), $name, $date, $time)]);
    }

    public function ajax_search_handler()
    {
        $query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';
        $results = new \WP_Query([
            's' => $query,
            'post_type' => 'any',
            'posts_per_page' => 5,
        ]);

        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                ?>
                <a href="<?php the_permalink(); ?>" class="esnp-search-result-item">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="esnp-search-result-thumb"><?php the_post_thumbnail('thumbnail'); ?></div>
                    <?php endif; ?>
                    <div class="esnp-search-result-content">
                        <span class="esnp-search-result-title"><?php the_title(); ?></span>
                        <span class="esnp-search-result-type"><?php echo get_post_type(); ?></span>
                    </div>
                </a>
                <?php
            }
        } else {
            echo '<div class="esnp-search-no-results">No results found.</div>';
        }
        wp_reset_postdata();
        wp_die();
    }

    public function register_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'esnp-kit',
            [
                'title' => esc_html__('ESNP Kit', 'esnp-kit'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    public function register_widgets($widgets_manager)
    {
        require_once(ESNP_PATH . 'widgets/class-mega-nav.php');
        require_once(ESNP_PATH . 'widgets/class-container-extender.php');
        require_once(ESNP_PATH . 'widgets/class-hero-advanced.php');
        require_once(ESNP_PATH . 'widgets/class-pricing-pro.php');
        require_once(ESNP_PATH . 'widgets/class-testimonial-carousel.php');
        require_once(ESNP_PATH . 'widgets/class-faq-accordion.php');
        require_once(ESNP_PATH . 'widgets/class-search-pro.php');
        require_once(ESNP_PATH . 'widgets/class-animated-headline.php');
        require_once(ESNP_PATH . 'widgets/class-link-in-bio.php');
        require_once(ESNP_PATH . 'widgets/class-posts-grid.php');
        require_once(ESNP_PATH . 'widgets/class-flip-box.php');
        require_once(ESNP_PATH . 'widgets/class-carousel-pro.php');
        require_once(ESNP_PATH . 'widgets/class-lottie.php');

        require_once(ESNP_PATH . 'widgets/class-lottie.php');
        require_once(ESNP_PATH . 'widgets/class-hotspot.php');
        require_once(ESNP_PATH . 'widgets/class-share-buttons.php');
        require_once(ESNP_PATH . 'widgets/class-reviews-pro.php');
        require_once(ESNP_PATH . 'widgets/class-login.php');
        require_once(ESNP_PATH . 'widgets/class-countdown.php');
        require_once(ESNP_PATH . 'widgets/class-table-of-contents.php');
        require_once(ESNP_PATH . 'widgets/class-progress-tracker.php');
        require_once(ESNP_PATH . 'widgets/class-accessibility-tools.php');
        require_once(ESNP_PATH . 'widgets/class-booking.php');

        $widgets_manager->register(new \ESNP_Kit\Widgets\Mega_Nav());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Container_Extender());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Hero_Advanced());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Pricing_Pro());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Testimonial_Carousel());
        $widgets_manager->register(new \ESNP_Kit\Widgets\FAQ_Accordion());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Search_Pro());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Animated_Headline());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Link_In_Bio());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Posts_Grid());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Flip_Box());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Carousel_Pro());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Lottie_Widget());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Hotspot());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Share_Buttons());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Reviews_Widget());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Login_Widget());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Countdown());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Table_Of_Contents());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Progress_Tracker());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Accessibility_Tools());
        $widgets_manager->register(new \ESNP_Kit\Widgets\Booking_Widget());
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('esnp-kit-main', ESNP_ASSETS_URL . 'css/main.css', [], '1.0.0');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'esnp-lottie',
            'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js',
            [],
            '5.9.6',
            true
        );
        wp_enqueue_script('esnp-kit-main', ESNP_ASSETS_URL . 'js/main.js', [], '1.0.0', true);
        wp_localize_script('esnp-kit-main', 'esnpData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ]);
    }
}
