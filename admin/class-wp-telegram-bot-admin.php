<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://weblorem.com
 * @since      1.0.0
 *
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/admin
 * @author     Mazuryk Eugene <mazuryk.e@ukr.net>
 */
class Wp_Telegram_Bot_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * All options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @var false|mixed|void $plugin_options Options of this plugin.
	 */
	private $plugin_options;

	/**
	 * All options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @var object $plugin_public Object class Wp_Telegram_Bot_Public
	 */
	private $plugin_public;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name    = $plugin_name;
		$this->version        = $version;
		$this->plugin_options = get_option( $this->plugin_name );
		$this->plugin_public  = new Wp_Telegram_Bot_Public( $this->plugin_name, $this->version );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Telegram_Bot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Telegram_Bot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-telegram-bot-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Telegram_Bot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Telegram_Bot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-telegram-bot-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the Settings menu.
		*/
		add_options_page( __( 'Settings Telegram Bot', $this->plugin_name ), __( 'WP Telegram Bot', $this->plugin_name ), 'manage_options', $this->plugin_name, array(
				$this,
				'display_plugin_setup_page'
			)
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 */
	public function add_action_links( $links ) {

		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
		);

		return array_merge( $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 */
	public function display_plugin_setup_page() {

		include_once( 'partials/wp-telegram-bot-admin-display.php' );

	}

	/**
	 * Validate options
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function validate( $input ) {
		$valid              = array();
		$valid['bot_token'] = ( isset( $input['bot_token'] ) && ! empty( $input['bot_token'] ) ) ? $input['bot_token'] : '';
		$valid['chat_id']   = ( isset( $input['chat_id'] ) && ! empty( $input['chat_id'] ) ) ? $input['chat_id'] : '';

		return $valid;
	}

	/**
	 * Update all options
	 */
	public function options_update() {
		register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'validate' ) );
	}

	/**
	 * The function sends ajax test telegram messages
	 */
	public function send_test_telegram_message() {

		if ( wp_doing_ajax() ) {

			if ( empty( $this->plugin_options['bot_token'] ) || empty( $this->plugin_options['chat_id'] ) ) {
				$data = [
					'message' => __( 'Error! Plugin settings should not be empty.', $this->plugin_name ),
				];
				wp_send_json_error( $data );
			}


			$message = esc_attr__( 'This is a test message from the site', $this->plugin_name ) . ': ' . home_url();

			$send_message = $this->plugin_public->send_telegram_message( $this->plugin_options['bot_token'], $this->plugin_options['chat_id'], $message );

			if ( $send_message ) {
				$data = [ 'message' => __( 'Message sent!', $this->plugin_name ) ];
				wp_send_json_success( $data );
			} else {
				$data = [
					'message' => __( 'Error sending message!', $this->plugin_name ),
				];
				wp_send_json_error( $data );
			}

		}

		$data = [ 'message' => __( 'AJAX query error!', $this->plugin_name ) ];
		wp_send_json_error( $data );

	}

	/**
	 * The function get Telegram Chat ID
	 */
	function get_telegram_chat_id() {
		if ( wp_doing_ajax() ) {
			if ( empty( $this->plugin_options['bot_token'] ) ) {
				$data = [
					'message' => __( 'Error! Token should not be empty.', $this->plugin_name ),
				];
				wp_send_json_error( $data );
			}

			$url = 'https://api.telegram.org/bot' . $this->plugin_options['bot_token'] . '/getUpdates';

			$curl = curl_init();

			curl_setopt_array( $curl, array(
				CURLOPT_POST           => 1,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HEADER         => 0,
				CURLOPT_URL            => $url,
			) );

			$server_response = curl_exec( $curl );
			curl_close( $curl );

			$server_response = json_decode( $server_response, 1 );

			if ( ! $server_response['ok'] ) {
				$data = [
					'message' => __( 'Error Telegram API!', $this->plugin_name ),
				];
				wp_send_json_error( $data );
			} else {
				$private_chat_array = [];
				$group_chat_array   = [];

				foreach ( $server_response['result'] as $result ) {
					if ( $result['message']['chat']['type'] == 'private' ) {
						$private_chat_array[ $result['message']['date'] ] = [
							'username' => $result['message']['chat']['username'],
							'chat_id'  => $result['message']['chat']['id'],
						];
					}
				}

				foreach ( $server_response['result'] as $result ) {
					if ( $result['message']['chat']['type'] == 'group' ) {
						$group_chat_array[ $result['message']['date'] ] = [
							'title'   => $result['message']['chat']['title'],
							'chat_id' => $result['message']['chat']['id'],
						];
					}
				}

				if ( empty( $private_chat_array ) && empty( $group_chat_array ) ) {
					$data = [ 'message' => __( 'Write a private message to your Telegram bot, or add it to a group.', $this->plugin_name ) ];
					wp_send_json_error( $data );
				}

				$private_chat_array = array_pop( $private_chat_array );
				$group_chat_array   = array_pop( $group_chat_array );

				$private_chat = null;
				$group_chat   = null;

				if ( ! empty( $private_chat_array['username'] ) && $private_chat_array['chat_id'] ) {
					$private_chat = '<b>' . __( 'Username:', $this->plugin_name ) . '</b> ' . $private_chat_array['username'] . '<br>';
					$private_chat .= '<b>' . __( 'Chat ID:', $this->plugin_name ) . '</b> ' . $private_chat_array['chat_id'] . '<br>';
				}

				if ( ! empty( $group_chat_array['title'] ) && $group_chat_array['chat_id'] ) {
					$group_chat = ! empty( $private_chat ) ? '<hr>' : null;
					$group_chat .= '<b>' . __( 'Group title:', $this->plugin_name ) . '</b> ' . $group_chat_array['title'] . '<br>';
					$group_chat .= '<b>' . __( 'Group chat ID:', $this->plugin_name ) . '</b> ' . $group_chat_array['chat_id'] . '<br>';
				}

				$data = [ 'message' => $private_chat . $group_chat ];
				wp_send_json_success( $data );
			}

		}

		$data = [ 'message' => __( 'AJAX query error!', $this->plugin_name ) ];
		wp_send_json_error( $data );

	}

}
