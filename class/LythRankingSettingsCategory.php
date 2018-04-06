<?php
/**
 *
 */
class LythRankingSettingsCategory
{
    public $id_category;
    public $name;
    public $parent = 0;
    public $position = 0;
    public $date_update = '0000-00-00 00:00:00';

    public function __construct($id_category = null)
    {
        if ($id_category) {
            $result = LythRankingCore::getCategory($id_category);
            foreach ($result[0] as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function addCategory()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE name = '$this->name'");
        if (!empty($results)) {
            return false;
        };
        if (!empty($this->parent)) {
            $parent = (int) $this->parent;
        } else {
            $parent = 0;
        };
        if (!empty($this->position) || $this->positon <= 0) {
            $position = (int) $this->position;
        } else {
            $position = 1;
        };
        // check is other category in this position
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE position = $position AND parent = $this->parent");
        if ($results) {
            $resultsSup = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE position >= $position AND parent = $this->parent");
        }
        // update Category >= this position
        if ($resultsSup) {
            $date = current_time("mysql");
            foreach ($resultsSup as $rowSup) {
                $posUp = (int) $rowSup->position + 1;
                $args = array(
                    'name' => (string) $rowSup->name,
                    'parent' => (int) $rowSup->parent,
                    'position' => $posUp,
                    'date_update' => $date
                );
                if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $rowSup->id_category), array( '%s', '%d', '%d', '%s'), array('%d'))) {
                    return false;
                }
            }
        }

        $args = array(
            'name' => $this->name,
            'parent' => $parent,
            'position' => $position,
            'date_update' => $this->date_update
        );
        if (!$wpdb->insert("$lythRanking_category", $args)) {
            return false;
        }
        return true;
    }

    public function updateCategory()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';
        // $resultNoModif = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category = $this->id_category AND name = '$this->name' AND position = $this->position AND parent = $this->parent");
        // if ($resultNoModif) {
        //     return true;
        // }

        $indexPos = $this->position - 1;
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category != $this->id_category AND parent = $this->parent ORDER BY position ASC");
        $current = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category = $this->id_category");
        // modif $this
        $current[0]->name = $this->name;
        $current[0]->position = (int) $this->position;
        $current[0]->parent = (int) $this->parent;
        $current[0]->date_update = $this->date_update;

        $resOrder = array_merge(array_slice($results, 0, $indexPos, true), $current, array_slice($results, $indexPos, null, true));
        // LythTools::array_object_orderby($res, 'position', SORT_ASC);
        // return $resOrder;

        $reIndex = 1;
        foreach ($resOrder as $row) {
            $date = current_time("mysql");
            $args = array(
                'name' => $row->name,
                'parent' => (int) $row->parent,
                'position' => (int) $reIndex,
                'date_update' => $date
            );
            // $wpdb->query( $wpdb->prepare("UPDATE $lythRanking_category WHERE id_category => $row->id_category  post_id = %d AND start IS NULL AND end IS NULL", $event_tag, $post_ID ) );
            if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $row->id_category), array( '%s', '%d', '%d', '%s'), array('%d'))) {
                return false;
            };

            $reIndex++;
        };
        return true;
    }

}
