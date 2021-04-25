<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://weblorem.com
 * @since      1.0.0
 *
 * @package    Wp_Telegram_Bot
 * @subpackage Wp_Telegram_Bot/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
// All form options
$options = get_option( $this->plugin_name );

// Form options
$bot_token = $options['bot_token'];
$chat_id   = $options['chat_id'];
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
		<?php
		// Hidden form fields on the settings page
		settings_fields( $this->plugin_name );
		do_settings_sections( $this->plugin_name );
		?>

        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        <hr>

        <table class="form-table" role="presentation">
            <tbody>

            <tr>
                <th scope="row">
                    <label for="<?php echo $this->plugin_name; ?>-bot_token">
						<?php esc_attr_e( 'Token', $this->plugin_name ); ?>
                    </label>
                </th>
                <td>
                    <input type="text"
                           class="regular-text code" id="<?php echo $this->plugin_name; ?>-bot_token"
                           name="<?php echo $this->plugin_name; ?>[bot_token]"
                           value="<?php if ( ! empty( $bot_token ) ) {
						       esc_attr_e( $bot_token, $this->plugin_name );
					       } ?>"
                           placeholder="<?php esc_attr_e( 'Enter bot token', $this->plugin_name ); ?>"
                    />
                    <span class="description">
                    <?php esc_attr_e( 'Token received from BotFather.', $this->plugin_name ); ?>
                </span>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo $this->plugin_name; ?>-chat_id">
						<?php esc_attr_e( 'Chat ID', $this->plugin_name ); ?>
                    </label>
                </th>
                <td>
                    <input type="text"
                           class="all-options code" id="<?php echo $this->plugin_name; ?>-chat_id"
                           name="<?php echo $this->plugin_name; ?>[chat_id]"
                           value="<?php if ( ! empty( $chat_id ) ) {
						       esc_attr_e( $chat_id, $this->plugin_name );
					       } ?>"
                           placeholder="<?php esc_attr_e( 'Enter chat id', $this->plugin_name ); ?>"
                    />
                    <span class="description">
                    <?php esc_attr_e( 'Telegram chat id.', $this->plugin_name ); ?>
                </span>
                </td>
            </tr>

            </tbody>
        </table>
        <br class="clear"/>

        <table class="form-table" role="presentation">
            <tbody>

            <tr>
                <td>
                    <button type="button" class="button wp-hide-pw hide-if-no-js"
                            id="<?php echo $this->plugin_name; ?>-test_message_button">
                        <span class="text spinner-animation"><?php esc_attr_e( 'Send test message', $this->plugin_name ); ?></span>
                        <span class="spinner is-active spinner-animation <?php echo $this->plugin_name; ?>-test_message_button" style="display: none"></span>
                        <span class="text spinner-animation <?php echo $this->plugin_name; ?>-test_message_button"
                              style="display: none"><?php esc_attr_e( 'Sending...', $this->plugin_name ); ?></span>
                    </button>

                    <button type="button" class="button wp-hide-pw hide-if-no-js"
                            id="<?php echo $this->plugin_name; ?>-telegram_chat_id_button">
                        <span class="text spinner-animation"><?php esc_attr_e( 'Get Telegram chat ID', $this->plugin_name ); ?></span>
                        <span class="spinner is-active spinner-animation <?php echo $this->plugin_name; ?>-telegram_chat_id_button" style="display: none"></span>
                        <span class="text spinner-animation <?php echo $this->plugin_name; ?>-telegram_chat_id_button"
                              style="display: none"><?php esc_attr_e( 'Sending...', $this->plugin_name ); ?></span>
                    </button>

                    <div id="<?php echo $this->plugin_name; ?>-test_message_result"
                         class="notice is-dismissible inline"
                         style="width:50%;display: none">
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
        <br class="clear"/>

		<?php submit_button(); ?>

    </form>
</div>