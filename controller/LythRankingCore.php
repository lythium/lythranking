<?php
/**
 *
 */
class LythRankingCore
{

    function __construct()
    {
        add_action( 'admin_enqueue_scripts', array($this,'load_wp_media_files' ));

        add_action( 'wp_ajax_add_lr_Process', array($this, 'add_lr_Process' ));
        add_action( 'wp_ajax_nopriv_add_lr_Process', array($this, 'add_lr_Process' ));

        add_action( 'wp_ajax_update_lr_Process', array($this, 'update_lr_Process' ));
        add_action( 'wp_ajax_nopriv_update_lr_Process', array($this, 'update_lr_Process' ));
    }

    public static function add_lr_Process() {
        if (!isset($_POST['name']) || empty($_POST['name']) || !LythTools::isGenericName($_POST['name'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'Name invalid'
            )));
        }
        if (!isset($_POST['position']) || empty($_POST['position']) || !LythTools::isInt((int) $_POST['position'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'Position invalid'
            )));
        }
        if (isset($_POST['parent']) && $_POST['parent'] === '0' && !LythTools::isInt((int) $_POST['parent'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'Parent invalid'
            )));
        }
        if ($_POST['method'] == "add") {
            $obj = new LythRankingSettingsCategory();
            $obj->name = $_POST['name'];
            $obj->position = (int) $_POST['position'];
            $obj->parent = (int) $_POST['parent'];

            if (!$obj->repositioningCategory()) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'update order failed'
                )));
            }

            if (!$obj->add()) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'Error to save'
                )));
            }
            die(json_encode(array(
                'return' => true,
                'message' => 'Add Category Success'
            )));
        } elseif($_POST['method'] == "update") {
            if (!isset($_POST['id']) && !LythTools::isInt((int) $_POST['id'])) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'Error Id'
                )));
            }
            $obj = new LythRankingSettingsCategory($_POST['id']);
            $obj->name = $_POST['name'];
            $obj->position = (int) $_POST['position'];
            $obj->parent = (int) $_POST['parent'];

            if (!$obj->repositioningCategory()) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'update order failed'
                )));
            }
            if (!$obj->update()) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'Error to update'
                )));
            }
            die(json_encode(array(
                'return' => true,
                'message' => 'Update Category Success'
            )));
        } else {
            die(json_encode(array(
                'return' => false,
                'error' => 'Method Error'
            )));
        }
    }

    public static function update_lr_Process() {

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
    public static function getCategory($id_category) {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category = $id_category", OBJECT);
        if (!$results) {
            $results = false;
        }
        return $results;
    }

    public static function getCategoryParent()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE parent = 0 ORDER BY position ASC", OBJECT);
        if (!$results) {
            $results = false;
        }
        return $results;
    }

    public static function getChildrenCategory($id_parent)
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE parent = $id_parent ORDER BY position ASC", OBJECT);
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
