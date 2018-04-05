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

    public function __construct($id_category = null)
    {
        if ($id_category) {
            $result = LythRankingCore::getCategory($id_category);
            foreach ($result[0] as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function add()
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
        if (!empty($this->position)) {
            $position = (int) $this->position;
        } else {
            $position = 0;
        };
        $args = array(
            'name' => $this->name,
            'parent' => $this->parent,
            'position' => $position
        );
        if (!$wpdb->insert("$lythRanking_category", $args)) {
            return false;
        }
        return true;
    }

    public function update()
    {
        global $wpdb;
        $lythRanking_category = $wpdb->prefix . 'lythranking_category';
        $result = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category = $this->id_category AND name = '$this->name' AND position = $this->position AND parent = $this->parent");
        if ($result) {
            return true;
        }
        $args = array(
            'name' => $this->name,
            'parent' => $this->parent,
            'position' => $this->position
        );
        if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $this->id_category), array( '%s', '%d', '%d'), array('%d'))) {
            return false;
        }
        return true;
    }
    public function repositioningCategory() {
        global $wpdb;

        $lythRanking_category = $wpdb->prefix . 'lythranking_category';
        if ($this->id_category) {
            $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category != $this->id_category AND position = $this->position AND parent = $this->parent");
            if ($results) {
                $resultsSup = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE id_category != $this->id_category AND position >= $this->position AND parent = $this->parent");
            }
        } else {
            $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE position = $this->position AND parent = $this->parent");
            if ($results) {
                $resultsSup = $results = $wpdb->get_results("SELECT * FROM $lythRanking_category WHERE position >= $this->position AND parent = $this->parent");
            }
        }
        if (!$resultsSup) {
            return true;
        }

        foreach ($resultsSup as $row) {
            $posUp = (int) $row->position + 1;
            $args = array(
                'name' => (string) $row->name,
                'parent' => (int) $row->parent,
                'position' => $posUp
            );
            if (!$wpdb->update("$lythRanking_category", $args, array('id_category' => $row->id_category), array( '%s', '%d', '%d'), array('%d'))) {
                return false;
            }
            $count++;
        }

        return true;
    }
}
