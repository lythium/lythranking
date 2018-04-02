<?php
/**
 *
 */
class LythRankingCore
{

    function __construct()
    {
        add_action( 'admin_enqueue_scripts', array($this,'load_wp_media_files' ));

        add_action( 'wp_ajax_addProcess', array($this, 'addProcess' ));
        add_action( 'wp_ajax_nopriv_addProcess', array($this, 'addProcess' ));

        add_action( 'wp_ajax_updateProcess', array($this, 'updateProcess' ));
        add_action( 'wp_ajax_nopriv_updateProcess', array($this, 'updateProcess' ));
    }

    public static function addProcess() {

    }

    public static function updateProcess() {

    }

    public static function getItem($id_unit)
    {
        global $wpdb;

        return;
    }
    public static function getListRank()
    {
        global $wpdb;

        return false;
    }
    public static function getListCategory()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category ORDER BY id_category ASC", OBJECT);
        if (!$results) {
            $results = false;
        }
        return $results;
    }
    public static function getListFront()
    {
        global $wpdb;

        return;
    }
    public function load_wp_media_files() {
        wp_enqueue_media();
    }

    public static function image_id_by_url( $image_url ) {
        global $wpdb;

        if( empty( $image_url ) ) {
            return false;
        }

        $query_arr = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
        $image_id = (!empty( $query_arr )) ? $query_arr[0] : 0;

        return $image_id;
    }
}
