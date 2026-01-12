<?php

namespace WeLabs\VisibleRenderTemplates;

/**
 * VisibleRenderTemplates class
 *
 * @class VisibleRenderTemplates The class that holds the entire VisibleRenderTemplates plugin
 */
final class VisibleRenderTemplates {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.0.1';

    /**
     * Instance of self
     *
     * @var VisibleRenderTemplates
     */
    private static $instance = null;

    /**
     * Holds various class instances
     *
     * @since 2.6.10
     *
     * @var array
     */
    private $container = [];

    /**
     * Constructor for the VisibleRenderTemplates class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( VISIBLE_RENDER_TEMPLATES_FILE, [ $this, 'activate' ] );
        register_deactivation_hook( VISIBLE_RENDER_TEMPLATES_FILE, [ $this, 'deactivate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        add_action( 'woocommerce_flush_rewrite_rules', [ $this, 'flush_rewrite_rules' ] );
        add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
    }

    /**
     * Initializes the VisibleRenderTemplates() class
     *
     * Checks for an existing VisibleRenderTemplates instance
     * and if it doesn't find one then create a new one.
     *
     * @return VisibleRenderTemplates
     */
    public static function init() {
        if ( self::$instance === null ) {
			self::$instance = new self();
		}

        return self::$instance;
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @since 2.6.10
     *
     * @param string $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
		}
    }

    /**
     * Placeholder for activation function
     *
     * Nothing is being called here yet.
     */
    public function activate() {
        // Rewrite rules during visible_render_templates activation
        if ( $this->has_woocommerce() ) {
            $this->flush_rewrite_rules();
        }
    }

    /**
	 * Register plugin REST routes
	 *
	 * @return void
	 */
	public function register_rest_route() {
        // Register your REST routes here
	}

    /**
     * Flush rewrite rules after visible_render_templates is activated or woocommerce is activated
     *
     * @since 3.2.8
     */
    public function flush_rewrite_rules() {
        // fix rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {     }

    /**
     * Define all constants
     *
     * @return void
     */
    public function define_constants() {
        defined( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_VERSION' ) || define( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_VERSION', $this->version );
        defined( 'VISIBLE_RENDER_TEMPLATES_DIR' ) || define( 'VISIBLE_RENDER_TEMPLATES_DIR', dirname( VISIBLE_RENDER_TEMPLATES_FILE ) );
        defined( 'VISIBLE_RENDER_TEMPLATES_INC_DIR' ) || define( 'VISIBLE_RENDER_TEMPLATES_INC_DIR', VISIBLE_RENDER_TEMPLATES_DIR . '/includes' );
        defined( 'VISIBLE_RENDER_TEMPLATES_TEMPLATE_DIR' ) || define( 'VISIBLE_RENDER_TEMPLATES_TEMPLATE_DIR', VISIBLE_RENDER_TEMPLATES_DIR . '/templates' );
        defined( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_ASSET' ) || define( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_ASSET', plugins_url( 'assets', VISIBLE_RENDER_TEMPLATES_FILE ) );
        defined( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_ADMIN_ASSET' ) || define( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_ADMIN_ASSET' , VISIBLE_RENDER_TEMPLATES_PLUGIN_ASSET . '/admin' );
        defined( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_PUBLIC_ASSET' ) || define( 'VISIBLE_RENDER_TEMPLATES_PLUGIN_PUBLIC_ASSET' , VISIBLE_RENDER_TEMPLATES_PLUGIN_ASSET . '/public' );

        // give a way to turn off loading styles and scripts from parent theme
        defined( 'VISIBLE_RENDER_TEMPLATES_LOAD_STYLE' ) || define( 'VISIBLE_RENDER_TEMPLATES_LOAD_STYLE', true );
        defined( 'VISIBLE_RENDER_TEMPLATES_LOAD_SCRIPTS' ) || define( 'VISIBLE_RENDER_TEMPLATES_LOAD_SCRIPTS', true );
    }

    /**
     * Load the plugin after WP User Frontend is loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();

        do_action( 'visible_render_templates_loaded' );
    }

    /**
     * Initialize the actions
     *
     * @return void
     */
    public function init_hooks() {
        // initialize the classes
        add_action( 'init', [ $this, 'init_classes' ], 4 );
        add_action( 'plugins_loaded', [ $this, 'after_plugins_loaded' ] );
    }

    /**
     * Include all the required files
     *
     * @return void
     */
    public function includes() {
        // include_once STUB_PLUGIN_DIR . '/functions.php';
    }

    /**
     * Init all the classes
     *
     * @return void
     */
    public function init_classes() {
        $this->container['scripts'] = new Assets();
    }

    /**
     * Executed after all plugins are loaded
     *
     * At this point visible_render_templates Pro is loaded
     *
     * @since 2.8.7
     *
     * @return void
     */
    public function after_plugins_loaded() {
        // Initiate background processes and other tasks
    }

    /**
     * Check whether woocommerce is installed and active
     *
     * @since 2.9.16
     *
     * @return bool
     */
    public function has_woocommerce() {
        return class_exists( 'WooCommerce' );
    }

    /**
     * Check whether woocommerce is installed
     *
     * @since 3.2.8
     *
     * @return bool
     */
    public function is_woocommerce_installed() {
        return in_array( 'woocommerce/woocommerce.php', array_keys( get_plugins() ), true );
    }

    /**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', VISIBLE_RENDER_TEMPLATES_FILE ) );
	}

    /**
     * Get the template file path to require or include.
     *
     * @param string $name
     * @return string
     */
    public function get_template( $name ) {
        $template = untrailingslashit( VISIBLE_RENDER_TEMPLATES_TEMPLATE_DIR ) . '/' . untrailingslashit( $name );

        return apply_filters( 'visible-render-templates_template', $template, $name );
    }
}
