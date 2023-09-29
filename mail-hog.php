<?php
/*
 * Plugin Name:       Mail Hog Settings
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Configure PHPMailer settings for Mail Hog in Docker 
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Daniel Pringle
 * Author URI:        https://danielpringle.co.uk
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/danielpringle/mail-hog/
 * Text Domain:       mail-hog-dev
 * Domain Path:       /languages
 */

// define the wp_mail_failed callback
function action_wp_mail_failed($wp_error) {
    print_r($wp_error, true);
    exit;
}
add_action('wp_mail_failed', 'action_wp_mail_failed', 10, 1);

// configure PHPMailer to send through SMTP
function setup( $phpmailer ) {
    /* Configure mail server */
    define('WORDPRESS_SMTP_AUTH', false);
    define('WORDPRESS_SMTP_SECURE', '');
    define('WORDPRESS_SMTP_HOST', 'mailhog');
    define('WORDPRESS_SMTP_PORT', '1025');
    define('WORDPRESS_SMTP_USERNAME', null);
    define('WORDPRESS_SMTP_PASSWORD', null);
    define('WORDPRESS_SMTP_FROM', 'no-reply@demo.com');
    define('WORDPRESS_SMTP_FROM_NAME', 'Demo');

    $phpmailer->isSMTP();
    // host details
    $phpmailer->SMTPAuth = WORDPRESS_SMTP_AUTH;
    $phpmailer->SMTPSecure = WORDPRESS_SMTP_SECURE;
    $phpmailer->SMTPAutoTLS = false;
    $phpmailer->Host = WORDPRESS_SMTP_HOST;
    $phpmailer->Port = WORDPRESS_SMTP_PORT;
    // from details
    $phpmailer->From = WORDPRESS_SMTP_FROM;
    $phpmailer->FromName = WORDPRESS_SMTP_FROM_NAME;
    // login details
    $phpmailer->Username = WORDPRESS_SMTP_USERNAME;
    $phpmailer->Password = WORDPRESS_SMTP_PASSWORD;
}
add_action( 'phpmailer_init', 'setup' );
