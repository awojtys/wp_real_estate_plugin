<?php

class ConnectWithDB {
    public function getMetaForOffer()
    {
        global $wpdb;
        global $post;
        $result = array();
        if($post->post_type == 'offers')
        {
            $query = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = $post->ID ");
            foreach ($query as $key)
            {
                if($key->meta_key[0] != '_')
                {
                    $result[$key->meta_key] = $key->meta_value;
                }
            }
        }
        return $result; 
    }
    
    public function getPicturesName()
    {
        global $wpdb;
        global $post;
        $result = array();
        $query = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = $post->ID AND meta_key = 'all_files_name'");
        $files = explode(',', $query[0]->meta_value);
        array_pop($files);
        return $files;
    }
}

?>
