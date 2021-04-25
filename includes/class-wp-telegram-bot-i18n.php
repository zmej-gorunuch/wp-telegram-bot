<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://weblorem.com
 * @since      1.0.0
 *
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/includes
 * @author     Mazuryk Eugene <mazuryk.e@ukr.net>
 */
class Wp_Telegram_Bot_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-telegram-bot',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
