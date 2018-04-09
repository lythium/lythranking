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
