<?php
/**
 *
 */
class LythRankingCore
{

    function __construct()
    {
        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'lythrankinglist' || $_GET['page'] == 'lythrankingaddcategory') {
                add_action( 'admin_enqueue_scripts', array($this,'load_wp_media_files' ));
            }
        }

        add_action( 'wp_ajax_category_lr_Process', array($this, 'category_lr_Process' ));
        add_action( 'wp_ajax_nopriv_category_lr_Process', array($this, 'category_lr_Process' ));

        add_action( 'wp_ajax_unit_lr_Process', array($this, 'unit_lr_Process' ));
        add_action( 'wp_ajax_nopriv_unit_lr_Process', array($this, 'unit_lr_Process' ));
    }

    public static function category_lr_Process() {
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
            $obj->date_update = (string) current_time("mysql");

            if (!$obj->addCategory()) {
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
            $obj->date_update = current_time("mysql");

            if (!$obj->updateCategory()) {
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

    public static function unit_lr_Process() {
        if (!isset($_POST['unit_rank']) || empty($_POST['unit_rank']) || !LythTools::isInt((int) $_POST['unit_rank'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'Rank invalid'
            )));
        }
        if (!isset($_POST['unit_name']) || empty($_POST['unit_name']) || !LythTools::isGenericName($_POST['unit_name'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'Unit Name invalid'
            )));
        }
        if (!empty($_POST['url_post'])) {
             if (!LythTools::isUrl($_POST['url_post'])) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'Url Post invalid'
                )));
            }
        }
        if (!isset($_POST['category']) || $_POST['category'] === '0' || !LythTools::isInt((int) $_POST['category'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'Category invalid'
            )));
        }
        if (!isset($_POST['image_url']) || empty($_POST['image_url']) || !LythTools::isUrl($_POST['image_url'])) {
            die(json_encode(array(
                'return' => false,
                'error' => 'image invalid'
            )));
        }
        if (!empty($_POST['positive_details'])) {
             if (!LythTools::isString($_POST['positive_details'])) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'Positive Details invalid'
                )));
            }
        }
        if (!empty($_POST['negative_details'])) {
             if (!LythTools::isString($_POST['negative_details'])) {
                die(json_encode(array(
                    'return' => false,
                    'error' => 'Negative Details invalid'
                )));
            }
        }
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
