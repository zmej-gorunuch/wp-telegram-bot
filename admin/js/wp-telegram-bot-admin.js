(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    // Send test telegram message
    $(function () {
        let send_btn = $('#wp-telegram-bot-test_message_button');
        let send_btn_spinner = $('.spinner-animation.wp-telegram-bot-test_message_button');
        let result_block = $('#wp-telegram-bot-test_message_result');

        send_btn.on('click', function (e) {
            e.preventDefault();
            result_block.hide().empty().removeClass('notice-error notice-success');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'send_test_telegram_message',
                },
                beforeSend: function () {
                    send_btn_spinner.toggle();
                },
                success: function (json) {
                    send_btn_spinner.toggle();
                    if (json.success) {
                        if (json.data.message) {
                            result_block.addClass('notice-success').append('<p>' + json.data.message + '</p>').show();
                        } else {
                            console.log(json);
                        }
                    } else {
                        if (json.data.errors) {
                            result_block.addClass('notice-error').append('<p>' + json.data.message + ' ' + json.data.errors + '</p>').show();
                        } else {
                            result_block.addClass('notice-error').append('<p>' + json.data.message + '</p>').show();
                        }
                    }
                },
                error: function (errorThrown) {
                    send_btn_spinner.toggle();
                    console.log(errorThrown);
                }
            });
        });
    });

    // Get ajax telegram chat id
    $(function () {
        let send_btn = $('#wp-telegram-bot-telegram_chat_id_button');
        let send_btn_spinner = $('.spinner-animation.wp-telegram-bot-telegram_chat_id_button');
        let result_block = $('#wp-telegram-bot-test_message_result');

        send_btn.on('click', function (e) {
            e.preventDefault();
            result_block.hide().empty().removeClass('notice-error notice-success');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'get_telegram_chat_id',
                },
                beforeSend: function () {
                    send_btn_spinner.toggle();
                },
                success: function (json) {
                    send_btn_spinner.toggle();
                    if (json.success) {
                        if (json.data.message) {
                            result_block.addClass('notice-success').append('<p>' + json.data.message + '</p>').show();
                        } else {
                            console.log(json);
                        }
                    } else {
                        if (json.data.errors) {
                            result_block.addClass('notice-error').append('<p>' + json.data.message + ' ' + json.data.errors + '</p>').show();
                        } else {
                            result_block.addClass('notice-error').append('<p>' + json.data.message + '</p>').show();
                        }
                    }
                },
                error: function (errorThrown) {
                    send_btn_spinner.toggle();
                    console.log(errorThrown);
                }
            });
        });
    });

})(jQuery);
