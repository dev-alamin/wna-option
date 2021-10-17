<?php

/**
 * Plugin Name: WNA Option Page
 * Plugin URI:  https://almn.me/plugin
 * Description: This is a plugin for practicing with Hasin Haydar vai.
 * Version:     1.0
 * Author:      Al Amin
 * Author URI:  https://almn.me
 * Text Domain: wna
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     WnaOption
 * @author      Al Amin
 * @copyright   2021 WNA
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      wna
 */

defined('ABSPATH') || die('No script kiddies please!');

/**
 * Main Class
 */
class WnaOption
{
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'wna_plugin_init']);
        add_action('admin_menu', [$this, 'option_menu']);
        add_action('admin_init', [$this, 'option_menu_fileds']);
    }

    /**
     * Load localization files
     *
     * @return void
     */
    function wna_plugin_init()
    {
        load_plugin_textdomain('wna_plugin_init', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    /**
     * Main Menu for the Page 
     */
    function option_menu()
    {
        $capability = 'manage_options';
        $paren_slug = 'wna-options';
        add_menu_page(__('WNA Option', 'wna'), __('WNA Option', 'wna'), $capability, $paren_slug, [$this, 'wna_callback'], 'dashicons-screenoptions');
        add_submenu_page($paren_slug, __('Social Links', 'wna'), __('Social Links', 'wna'), $capability, $paren_slug, [$this, 'wna_callback']);
        add_submenu_page($paren_slug, __('Settings', 'wna'), __('Settings', 'wna'), $capability, 'wna-settings', [$this, 'wna_callback_settings']);
    }
    /**
     * Submenu Callback 
     */
    function wna_callback_settings()
    { ?>
        <form action="options.php" method="POST">
            <?php
            settings_fields('submenu');
            do_settings_sections('submenu-page');
            submit_button();
            ?>
        </form>
    <?php }

    /**
     * Main Menu Callback
     */
    function wna_callback()
    { ?>
        <form action="options.php" method="POST">
            <?php
            settings_fields('our-settings');
            do_settings_sections('our-page');
            submit_button();
            ?>
        </form>
    <?php }
    /**
     * Main Menu Fields
     */
    function option_menu_fileds()
    {
        add_settings_section('our-settings', __('Social Profile', 'wna'), null, 'our-page');

        add_settings_field('protfolio_url', __('Portfolio URL', 'wna'), [$this, 'facebook_callback_func'], 'our-page', 'our-settings', ['protfolio_url']);
        add_settings_field('facebook_url', __('Facebook URL', 'wna'), [$this, 'facebook_callback_func'], 'our-page', 'our-settings', ['facebook_url']);
        add_settings_field('twitter_url', __('Twitter URL', 'wna'), [$this, 'facebook_callback_func'], 'our-page', 'our-settings', ['twitter_url']);

        register_setting('our-settings', 'facebook_url');
        register_setting('our-settings', 'twitter_url');
        register_setting('our-settings', 'protfolio_url');

        /**
         * Fields for Submenu Page
         */

        add_settings_section('submenu', __('WNA Settings', 'wna'), null, 'submenu-page');

        add_settings_field('is_show_header_footer', __('Show Header or Footer?', 'wna'), [$this, 'show_header_footer'], 'submenu-page', 'submenu');

        register_setting('submenu', 'is_show_header_footer');
    }

    /**
     * Fields Element Callback 
     */
    function facebook_callback_func($args)
    {
        $option = get_option($args[0]);
        printf('<input class="regular-text" type="text" name="%s" id="%s" value="%s" />', $args[0], $args[0], $option);
    }

    /**
     * Submenu Element Callback 
     */
    function show_header_footer()
    {
        $option = get_option('is_show_header_footer');
        $elements = ['Header', 'Footer'];

        echo '<select>';

        foreach ($elements as $element) {
            $select = '';
            if ($option == $element) {
                $select = 'selected';
            }
            printf('<option value="%s" %s> %s </option>', $element, $select, $element);
        }
        echo '</select>';
    ?>
<?php }
}


new WnaOption();
