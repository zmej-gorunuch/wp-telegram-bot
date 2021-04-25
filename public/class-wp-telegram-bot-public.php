<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://weblorem.com
 * @since      1.0.0
 *
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/public
 * @author     Mazuryk Eugene <mazuryk.e@ukr.net>
 */
class Wp_Telegram_Bot_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name    = $plugin_name;
		$this->version        = $version;
		$this->plugin_options = get_option( $this->plugin_name );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-telegram-bot-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-telegram-bot-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Send Telegram message
	 *
	 * @param $token
	 * @param $chat_id
	 * @param $message
	 *
	 * @return false|int|mixed
	 */
	static function send_telegram_message( $token, $chat_id, $message ) {

		if ( $token && $chat_id && $message ) {

			$response = array(
				'chat_id' => $chat_id,
				'text'    => $message
			);

			$url = 'https://api.telegram.org/bot' . $token . '/sendMessage';

			$curl = curl_init();

			curl_setopt_array( $curl, array(
				CURLOPT_POST           => 1,
				CURLOPT_POSTFIELDS     => $response,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HEADER         => 0,
				CURLOPT_URL            => $url,
			) );

			$server_response = curl_exec( $curl );
			curl_close( $curl );

			$server_response = json_decode( $server_response, 1 );

			if ( isset( $server_response['error'] ) ) {
				return 0;
			} else {
				return $server_response['result'];
			}
		}

		return false;
	}

	/**
	 * Send mail message to Telegram
	 *
	 * @param \PHPMailer\PHPMailer\PHPMailer $phpmailer
	 */
	function send_mail_to_telegram( PHPMailer\PHPMailer\PHPMailer $phpmailer ) {

		if ( ! empty( $this->plugin_options['bot_token'] ) || ! empty( $this->plugin_options['chat_id'] ) ) {
			$message = __( 'Message subject:' ) . ' ';
			$message .= $phpmailer->Subject . PHP_EOL . PHP_EOL;
			$message .= $phpmailer->Body;

			$this->send_telegram_message( $this->plugin_options['bot_token'], $this->plugin_options['chat_id'], $message );
		}

	}

}
