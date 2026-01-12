<?php

namespace WeLabs\VisibleRenderTemplates;

class Assets {
	/**
	 * The constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_all_scripts' ), 10 );

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_scripts' ) );
		}
	}

	/**
	 * Register all Dokan scripts and styles.
	 *
	 * @return void
	 */
	public function register_all_scripts() {
		$this->register_styles();
		$this->register_scripts();
	}

	/**
	 * Register scripts.
	 *
	 * @param array $scripts
	 *
	 * @return void
	 */
	public function register_scripts() {
		$admin_script    = VISIBLE_RENDER_TEMPLATES_PLUGIN_ADMIN_ASSET . '/js/script.js';
		$frontend_script = VISIBLE_RENDER_TEMPLATES_PLUGIN_PUBLIC_ASSET . '/js/script.js';

		wp_register_script( 'visible_render_templates_admin_script', $admin_script, array(), VISIBLE_RENDER_TEMPLATES_PLUGIN_VERSION, true );
		wp_register_script( 'visible_render_templates_script', $frontend_script, array(), VISIBLE_RENDER_TEMPLATES_PLUGIN_VERSION, true );
	}

	/**
	 * Register styles.
	 *
	 * @return void
	 */
	public function register_styles() {
		$admin_style    = VISIBLE_RENDER_TEMPLATES_PLUGIN_ADMIN_ASSET . '/css/style.css';
		$frontend_style = VISIBLE_RENDER_TEMPLATES_PLUGIN_PUBLIC_ASSET . '/css/style.css';

		wp_register_style( 'visible_render_templates_admin_style', $admin_style, array(), VISIBLE_RENDER_TEMPLATES_PLUGIN_VERSION );
		wp_register_style( 'visible_render_templates_style', $frontend_style, array(), VISIBLE_RENDER_TEMPLATES_PLUGIN_VERSION );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( 'visible_render_templates_admin_script' );
		wp_localize_script(
			'visible_render_templates_admin_script',
			'Visible_Render_Templates_Admin',
			array()
		);
	}

	/**
	 * Enqueue front-end scripts.
	 *
	 * @return void
	 */
	public function enqueue_front_scripts() {
		wp_enqueue_script( 'visible_render_templates_script' );
		wp_localize_script(
			'visible_render_templates_script',
			'Visible_Render_Templates',
			array()
		);
	}
}
