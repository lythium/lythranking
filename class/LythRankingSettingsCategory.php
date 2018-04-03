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
}
