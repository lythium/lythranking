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
    public $color = '#ffffff';
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
                    'position' => (int) $posUp,
                    'color' => (string) $rowSup->color,
                    'date_update' => $date,
                );
                if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $rowSup->id_category), array( '%s', '%d', '%d', '%s', '%s'), array('%d'))) {
                    return false;
                }
            }
        }

        $args = array(
            'name' => (string) $this->name,
            'parent' => (int) $parent,
            'position' => (int) $position,
            'color' => (string) $this->color,
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

        $indexPos = $this->position - 1;
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category != $this->id_category AND parent = $this->parent ORDER BY position ASC");
        $current = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category = $this->id_category");
        // modif $this
        $current[0]->name = (string) $this->name;
        $current[0]->position = (int) $this->position;
        $current[0]->parent = (int) $this->parent;
        $current[0]->color = (string) $this->color;
        $current[0]->date_update = $this->date_update;

        $resOrder = array_merge(array_slice($results, 0, $indexPos, true), $current, array_slice($results, $indexPos, null, true));
        // LythTools::array_object_orderby($res, 'position', SORT_ASC);
        // return $resOrder;

        $reIndex = 1;
        foreach ($resOrder as $row) {
            $date = current_time("mysql");
            $args = array(
                'name' => (string) $row->name,
                'position' => (int) $reIndex,
                'parent' => (int) $row->parent,
                'color' => (string) $row->color,
                'date_update' => $date
            );
            if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $row->id_category), array( '%s', '%d', '%d', '%s', '%s'), array('%d'))) {
                return false;
            };

            $reIndex++;
        };
        return true;
    }
    public function deleteCategory()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';
        if (!$wpdb->delete("$lythRanking_category", array('id_category' => $this->id_category), array('%d'))) {
            return false;
        }
        $hasChild = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE parent = $this->id_category");
        if ($hasChild) {
            foreach ($hasChild as $rowChild) {
                if (!$wpdb->delete("$lythRanking_category", array('id_category' => $rowChild->id_category), array('%d'))) {
                    return false;
                }
            }
        }

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE parent = $this->parent ORDER BY position ASC");
        if ($results) {
            $reIndex = 1;
            foreach ($results as $row) {
                $date = current_time("mysql");
                $args = array(
                    'name' => (string) $row->name,
                    'position' => (int) $reIndex,
                    'parent' => (int) $row->parent,
                    'color' => (string) $row->color,
                    'date_update' => $date
                );
                if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $row->id_category), array( '%s', '%d', '%d', '%s', '%s'), array('%d'))) {
                    return false;
                };

                $reIndex++;
            };
        }
        return true;
    }
}
