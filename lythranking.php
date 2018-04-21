<?php
/*
Plugin Name: LythRanking
Plugin URI: https://www.Lythium.fr/
Description: Manage Unit ranking
Version: 1.0
Author: Ever Team
Author URI: https://www.team-ever.com/
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class LythRanking
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Plugin Details
        $this->plugin               = new stdClass;
        $this->plugin->name         = 'lythframe'; // Plugin Folder
        $this->plugin->displayName  = 'LythFrame'; // Plugin Name
        $this->plugin->version      = '1.0.1';
        $this->plugin->folder       = plugin_dir_path(__FILE__);
        $this->plugin->url          = plugin_dir_url(__FILE__);

        add_action('admin_menu', array($this,'add_admin_menu'));
        add_action('admin_bar_menu', array($this, 'custom_toolbar_link'), 999);

        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'lythrankinglist' || $_GET['page'] == 'lythrankingaddcategory') {
                add_action('admin_enqueue_scripts', array($this, 'lythranking_scripts_admin' ));
            }
        }
        // css & js front
        add_action('wp_enqueue_scripts', array($this, 'lythranking_scripts_front' ));
        // add shortcode
        add_shortcode('LythRanking', array($this, 'lythranking_shortcode'));

        include_once plugin_dir_path(__FILE__).'controller/LythTools.php';
        new LythTools();

        include_once plugin_dir_path(__FILE__).'controller/LythRankingCore.php';
        new LythRankingCore();

        include_once plugin_dir_path(__FILE__).'class/LythRankingSettingsCategory.php';
        new LythRankingSettingsCategory();

        include_once plugin_dir_path(__FILE__).'class/LythRankingSettings.php';
        new LythRankingSettings();

        //Create on install
        register_activation_hook(__FILE__, array(__CLASS__, 'lythranking_install' ));

        //Delete on uninstall
        register_deactivation_hook(__FILE__, array(__CLASS__, 'lythranking_uninstall' ));
    }

    static function lythranking_install()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';
        $lythRanking = $wpdb->prefix . 'lythranking';

        $sql_lythRanking_category = "CREATE TABLE $lythRanking_category (
            id_category mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            position int(5) NOT NULL DEFAULT '0',
            parent varchar(255) NOT NULL DEFAULT '0',
            color varchar(7) NOT NULL DEFAULT '#ffffff',
            date_update datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            UNIQUE KEY  (id_category)
        ) $charset_collate;";

        $sql_lythRanking = "CREATE TABLE $lythRanking (
            id_rank mediumint(9) NOT NULL AUTO_INCREMENT,
            unit_rank int(5) NOT NULL,
            unit_name varchar(255) NOT NULL,
            category int(5) NOT NULL,
            image_url varchar(255) NOT NULL,
            url_post varchar(255) DEFAULT '' NOT NULL,
            positive_details varchar(255) NOT NULL,
            negative_details varchar(255) DEFAULT '',
            date_update datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            UNIQUE KEY  (id_rank)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_lythRanking_category);
        dbDelta($sql_lythRanking);
    }

    static function lythranking_uninstall()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';
        $lythRanking = $wpdb->prefix . 'lythranking';

        $wpdb->query("DROP TABLE IF EXISTS $lythRanking_category");
        $wpdb->query("DROP TABLE IF EXISTS $lythRanking");

    }

    static function add_admin_menu()
     {
        add_menu_page('Ranking list',
            'Ranking list',
            'manage_options',
            'lythrankinglist',
            array($this, 'lythRankingList')
        );
        add_submenu_page('lythrankinglist',
            'General',
            'Ranking list',
            'manage_options',
            'lythrankinglist',
            array($this, 'lythRankingList')
        );
        add_submenu_page('lythrankinglist',
            'Add Category',
            'Add Category',
            'manage_options',
            'lythrankingaddcategory',
            array($this, 'lythRankingAddCategory')
        );
     }

    static function custom_toolbar_link($wp_admin_bar) {
         $args = array(
             'id' => 'lythrankinglist',
             'title' => 'Ranking list',
             'href' => get_admin_url().'admin.php?page=lythrankinglist',
             'meta' => array(
                 'class' => 'lythranking',
                 'title' => 'Ranking list'
                 )
         );
         $wp_admin_bar->add_node($args);

     // Add the first child link

         $args = array(
             'id' => 'lythranking',
             'title' => 'Ranking list',
             'href' => get_admin_url().'admin.php?page=lythrankinglist',
             'parent' => 'lythrankinglist',
             'meta' => array(
                 'class' => 'lythranking',
                 'title' => 'Ranking list'
                 )
         );
         $wp_admin_bar->add_node($args);

     // Add another child link
     $args = array(
             'id' => 'lyth-add-category',
             'title' => 'Add Category',
             'href' => get_admin_url().'admin.php?page=lythrankingaddcategory',
             'parent' => 'lythrankinglist',
             'meta' => array(
                 'class' => 'lythranking',
                 'title' => 'Add Category'
                 )
         );
         $wp_admin_bar->add_node($args);
    }

    public function lythranking_shortcode()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        // new LythRankingCore();
        // $multiList = LythRankingCore::getListFront();
        ob_start();
        include plugin_dir_path(__FILE__).'views/front/listing.php';
		return ob_get_clean();
    }

    static function lythranking_scripts_admin()
    {
        // Ajax
        wp_register_script( 'ajaxHandle', get_site_url() . '/wp-content/plugins/lythranking/views/js/lr-ajax.js', array(), false, true );
        wp_enqueue_script( 'ajaxHandle' );
        wp_localize_script( 'ajaxHandle', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
        // CSS
        wp_register_style( 'lythrankingadmincss', get_site_url() . '/wp-content/plugins/lythranking/views/css/lr_admin_style.css' );
        wp_enqueue_style( 'lythrankingadmincss' );
    }
    static function lythranking_scripts_front()
    {
        wp_register_style( 'lythrankingcss', get_site_url() . '/wp-content/plugins/lythranking/views/css/lr_front_style.css' );
        wp_enqueue_style( 'lythrankingcss' );
        wp_enqueue_script( 'lythrankingjs', get_site_url() . '/wp-content/plugins/lythranking/views/js/lr-front.js', array(), false, true );
        wp_enqueue_script( 'lythframejs' );
    }

    static function lythRankingList()
    {
        // Load List
        include_once(WP_PLUGIN_DIR.'/lythranking/views/backoff/list-ranking.php');
    }

    static function lythRankingAddCategory()
    {
        // Load add Form
        include_once(WP_PLUGIN_DIR.'/lythranking/views/backoff/add-category.php');
    }
}
new LythRanking();
