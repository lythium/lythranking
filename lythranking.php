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
        $this->plugin->version      = '1.0.0';
        $this->plugin->folder       = plugin_dir_path(__FILE__);
        $this->plugin->url          = plugin_dir_url(__FILE__);

        add_action('admin_menu', array($this,'add_admin_menu'));
        add_action('admin_bar_menu', array($this, 'custom_toolbar_link'), 999);

        add_action('admin_enqueue_scripts', array($this, 'lythranking_scripts_admin' ));

        include_once plugin_dir_path(__FILE__).'controller/LythTools.php';
        new LythTools();

        include_once plugin_dir_path(__FILE__).'controller/LythRankingCore.php';
        new LythRankingCore();
        //Create on install
        register_activation_hook(__FILE__, array(__CLASS__, 'lythranking_install' ));

        //Delete on uninstall
        register_deactivation_hook(__FILE__, array(__CLASS__, 'lythranking_uninstall' ));
    }

    static function lythranking_install()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql_lythRanking = "CREATE TABLE {$wpdb->prefix}lythranking-category (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            parent varchar(255) DEFAULT NULL,
            position int(5) NOT NULL,
            UNIQUE KEY  (id)
        ) $charset_collate;";

        $sql_lythRanking &= "CREATE TABLE {$wpdb->prefix}lythranking (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            unit_rank int(5) NOT NULL,
            unit_name varchar(255) NOT NULL,
            category int(5) NOT NULL,
            image_url varchar(255) NOT NULL,
            url_post varchar(255) DEFAULT '0' NOT NULL,
            positive_details varchar(255) NOT NULL,
            negative_details varchar(255) DEFAULT '',
            UNIQUE KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_lythFrame);
    }

    static function lythranking_uninstall()
    {
        global $wpdb;

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

    static function lythRankingList()
    {
        // Load List
        include_once(WP_PLUGIN_DIR.'/lythframe/views/admin/list-ranking.php');
    }

    static function lythRankingAddCategory()
    {
        // Load add Form
        include_once(WP_PLUGIN_DIR.'/lythframe/views/admin/add-category.php');
    }
}
