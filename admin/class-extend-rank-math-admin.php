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
            $this->options     = get_option( 'Extend_Rankmath_settings' );
            $this->plugin_name = $plugin_name;
            $this->version     = $version;
            add_action( 'admin_menu', [$this, 'Extend_Rankmath_add_admin_menu'] );
            add_action( 'admin_init', [$this, 'Extend_Rankmath_settings_init'] );
            add_filter( 'rank_math/focus_keyword/maxtags', [$this, 'focus_keyword']);
            add_filter( 'plugin_action_links_'. ERM_BASE, [ $this, 'settings' ] );
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

        public function Extend_Rankmath_add_admin_menu() {
            add_options_page( 'Extend Rank Math', 'Extend Rank Math', 'manage_options', 'extend_rank_math', [$this, 'Extend_Rankmath_options_page'] );

        }

        public function Extend_Rankmath_settings_init() {
            register_setting( 'Extend_Rankmath_settings', 'Extend_Rankmath_settings' );

            add_settings_section(
                'Extend_Rankmath_settings_section',
                '',
                '',
                'Extend_Rankmath_settings'
            );

            add_settings_field(
                'rankmath_focus_keyword',
                __( 'Focus Keyword Limit', 'extend-rank-math' ),
                [$this, 'rankmath_focus_keyword_render'],
                'Extend_Rankmath_settings',
                'Extend_Rankmath_settings_section'
            );

        }

        public function rankmath_focus_keyword_render() {
            $limit = isset( $this->options['rankmath_focus_keyword'] ) ? $this->options['rankmath_focus_keyword'] : 5;

        ?>
			<input type='number' name='Extend_Rankmath_settings[rankmath_focus_keyword]' value='<?php echo $limit; ?>'>
		<?php

            }

            public function Extend_Rankmath_settings_section_callback() {
                // echo __( 'This section description', 'extend-rank-math' );

            }

            public function Extend_Rankmath_options_page() {
            ?>
			<form action='options.php' method='post'>

				<h2><?php _e('Extend Rank Math'); ?></h2>

				<?php
					settings_fields( 'Extend_Rankmath_settings' );
					do_settings_sections( 'Extend_Rankmath_settings' );
					submit_button();
				?>

			</form>
		<?php

                }
                
        }

