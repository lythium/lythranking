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
    public $image_url;
    public $url_post = '';
    public $positive_details;
    public $negative_details = '';
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
        // check is other unit in category on this unit_rank
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE unit_rank = $unit_rank AND category = $this->category");
        if ($results) {
            $resultsSup = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE unit_rank >= $unit_rank AND category = $this->category");
        }
        // update unit >= in category on this unit_rank
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

        $indexPos = $this->unit_rank - 1;
        $results = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE id_rank != $this->id_rank AND category = $this->category ORDER BY unit_rank ASC");
        $current = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE id_rank = $this->id_rank");
        // modif $this
        $current[0]->unit_name = (string) $this->unit_name;
        $current[0]->unit_rank = (int) $this->unit_rank;
        $current[0]->category = (int) $this->category;
        $current[0]->image_url = (string) $this->image_url;
        $current[0]->url_post = (string) $this->url_post;
        $current[0]->positive_details = (string) $this->positive_details;
        $current[0]->negative_details = (string) $this->negative_details;
        $current[0]->date_update = $this->date_update;

        $resOrder = array_merge(array_slice($results, 0, $indexPos, true), $current, array_slice($results, $indexPos, null, true));
        // LythTools::array_object_orderby($res, 'unit_rank', SORT_ASC);
        // return $resOrder;

        $reIndex = 1;
        foreach ($resOrder as $row) {
            $date = current_time("mysql");
            $args = array(
                'unit_rank' => (int) $reIndex,
                'unit_name' => (string) $row->unit_name,
                'category' => (int) $row->category,
                'image_url' => (string) $row->image_url,
                'url_post' => (string) $row->url_post,
                'positive_details' => (string) $row->positive_details,
                'negative_details' => (string) $row->negative_details,
                'date_update' => $date,
            );
            if (!$wpdb->update("$lythRanking_unit", $args, array('id_rank' => $row->id_rank), array( '%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s'), array('%d'))) {
                return false;
            };

            $reIndex++;
        };
        return true;
    }

    public function deleteUnit()
    {
        global $wpdb;
        $lythRanking_unit = $wpdb->prefix . 'lythranking';
        if (!$wpdb->delete("$lythRanking_unit", array('id_rank' => $this->id_rank), array('%d'))) {
            return false;
        }

        $results = $wpdb->get_results("SELECT * FROM $lythRanking_unit WHERE category = $this->category ORDER BY unit_rank ASC");
        if ($results) {
            $reIndex = 1;
            foreach ($results as $row) {
                $date = current_time("mysql");
                $args = array(
                    'unit_rank' => (int) $reIndex,
                    'unit_name' => (string) $row->unit_name,
                    'category' => (int) $row->category,
                    'image_url' => (string) $row->image_url,
                    'url_post' => (string) $row->url_post,
                    'positive_details' => (string) $row->positive_details,
                    'negative_details' => (string) $row->negative_details,
                    'date_update' => $date,
                );
                if (!$wpdb->update("$lythRanking_unit", $args, array('id_rank' => $row->id_rank), array( '%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s'), array('%d'))) {
                    return false;
                };

                $reIndex++;
            };
        }
        return true;
    }
}
