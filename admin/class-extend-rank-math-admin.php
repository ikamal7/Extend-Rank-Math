<?php

    /**
     * The admin-specific functionality of the plugin.
     *
     * @package    Extend_Rankmath
     * @subpackage Extend_Rankmath/admin
     *
     * @link       https://kamal.pw/
     * @since      1.0.0
     */

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Extend_Rankmath
     * @subpackage Extend_Rankmath/admin
     *
     * @author     Kamal H. <kamalhosen8920@gmail.com>
     */
    class Extend_Rankmath_Admin {
        /**
         * The ID of this plugin.
         *
         * @access   private
         * @var string $plugin_name The ID of this plugin.
         * @since    1.0.0
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         *
         * @access   private
         * @var string $version The current version of this plugin.
         * @since    1.0.0
         */
        private $version;

        public $options = array();

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         *
         * @param string $plugin_name The name of this plugin.
         * @param string $version     The version of this plugin.
         */
        public function __construct( $plugin_name, $version ) {
            $this->settings_api = new WeDevs_Settings_API;
            $this->options     = get_option( 'Extend_Rankmath_settings' );
            $this->plugin_name = $plugin_name;
            $this->version     = $version;
            add_action( 'admin_menu', [$this, 'Extend_Rankmath_add_admin_menu'] );
            add_action( 'admin_init', [$this, 'Extend_Rankmath_settings_init'] );
            add_filter( 'rank_math/focus_keyword/maxtags', [$this, 'focus_keyword']);
            add_filter( 'plugin_action_links_'. ERM_BASE, [ $this, 'settings' ] );

            // Admin bar Mode filter
            add_filter( 'rank_math/admin_bar/items', [$this, 'admin_bar_mode']);
        }


        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {
            /*
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in Extend_Rankmath_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The Extend_Rankmath_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/extend-rank-math-admin.css', array(), $this->version, 'all' );

        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts() {
            /*
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in Extend_Rankmath_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The Extend_Rankmath_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/extend-rank-math-admin.js', array( 'jquery' ), $this->version, false );

        }
        /**
         * Create settings link
         *
         * @since 1.0.0
         */
        public function settings( $links ) {
            $links[] = '<a href="'. admin_url('options-general.php?page=extend_rank_math') .'">Settings</a>';
            return $links;
        }

        /**
         * Change the Focus Keyword Limit
         */
        public function focus_keyword() {
            return $this->options['rankmath_focus_keyword']; // Number of Focus Keywords. 
        }
        /**
         * Add item to Rank Math admin bar node.
         *
         * @param array $items Array of nodes for Rank Math menu.
         */
        public function admin_bar_mode( $items ) {
            return $items;
        }

        public function Extend_Rankmath_add_admin_menu() {
            add_options_page( 'Extend Rank Math', 'Extend Rank Math', 'manage_options', 'extend_rank_math', [$this, 'Extend_Rankmath_options_page'] );

        }

        public function Extend_Rankmath_settings_init() {
            //set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );

            //initialize settings
            $this->settings_api->admin_init();

        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'erm_basics',
                    'title' => __( 'Basic Settings', ' extend-rank-math' )
                ),
            );
            return $sections;
        }
        /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'erm_basics' => array(
                array(
                    'name'              => 'rankmath_focus_keyword',
                    'label'             => __( 'Focus Keyword Limit', ' extend-rank-math' ),
                    'desc'              => __( '', ' extend-rank-math' ),
                    'placeholder'       => __( '', ' extend-rank-math' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '10',
                    'sanitize_callback' => 'floatval'
                ),
                array(
                    'name'        => 'custom_power_words',
                    'label'       => __( 'Custom Power Words', ' extend-rank-math' ),
                    'desc'        => __( 'Word separated by `comma`', ' extend-rank-math' ),
                    'placeholder' => __( 'word-1, word-2', ' extend-rank-math' ),
                    'type'        => 'textarea'
                ),
                array(
                    'name'  => 'show_keyword_meta',
                    'label' => __( 'Show Keyword meta tag frontend', ' extend-rank-math' ),
                    'desc'  => __( 'Add <\meta name=\'keywords\' content=\'focus keywords\'>', ' extend-rank-math' ),
                    'type'  => 'checkbox'
                ),
            ),
        );

        return $settings_fields;
    }

    public function Extend_Rankmath_options_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }


    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

