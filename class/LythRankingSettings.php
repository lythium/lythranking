<?php
/**
 *
 */
class LythRankingSettings
{
    public $id_rank;
    public $unit_rank = 1;
    public $unit_name;
    public $category;
    public $image_url ;
    public $url_post = '0';
    public $positive_details ;
    public $negative_details ;
    public $date_update = '0000-00-00 00:00:00';

    public function __construct($id_rank = null)
    {
        if ($id_rank) {
            $result = LythRankingCore::getUnit($id_rank);
            foreach ($result[0] as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    public function addUnit()
    {
        global $wpdb;
        $lythRanking_unit = $wpdb->prefix . 'lythranking';
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE unit_name = '$this->name' AND category = $this->category");
        if (!empty($results)) {
            return false;
        };
        if (!empty($this->unit_rank) || $this->unit_rank <= 0) {
            $unit_rank = (int) $this->unit_rank;
        } else {
            $unit_rank = 1;
        };
        // check is other unit in category on this position
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE unit_rank = $unit_rank AND category = $this->category");
        if ($results) {
            $resultsSup = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE unit_rank >= $unit_rank AND category = $this->category");
        }
        // update unit >= in category on this position
        if ($resultsSup) {
            $date = current_time("mysql");
            foreach ($resultsSup as $rowSup) {
                $posUp = (int) $rowSup->unit_rank + 1;
                $args = array(
                    'unit_rank' => (int) $posUp,
                    'unit_name' => (string) $rowSup->unit_name,
                    'category' => (int) $rowSup->category,
                    'image_url' => (string) $rowSup->image_url,
                    'url_post' => (string) $rowSup->url_post,
                    'positive_details' => (string) $rowSup->positive_details,
                    'negative_details' => (string) $rowSup->negative_details,
                    'date_update' => $date,
                );
                if (!$wpdb->update("$lythRanking_unit", $args, array('id_rank' => $rowSup->id_rank), array( '%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s'), array('%d'))) {
                    return false;
                }
            }
        }

        $args = array(
            'unit_rank' => (int) $this->unit_rank,
            'unit_name' => (string) $this->unit_name,
            'category' => (int) $this->category,
            'image_url' => (string) $this->image_url,
            'url_post' => (string) $this->url_post,
            'positive_details' => (string) $this->positive_details,
            'negative_details' => (string) $this->negative_details,
            'date_update' => $this->date_update,
        );
        if (!$wpdb->insert("$lythRanking_unit", $args)) {
            return false;
        }
        return true;
    }
    public function updateUnit()
    {
        global $wpdb;
        $lythRanking_unit = $wpdb->prefix . 'lythranking';
    }
    public function deleteUnit()
    {
        global $wpdb;
        $lythRanking_unit = $wpdb->prefix . 'lythranking';
    }
}
