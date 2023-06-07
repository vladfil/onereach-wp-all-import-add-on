<?php
/*
Plugin Name: OneReach WP All Import Add-on
Plugin URI: 
Description: WP All Import Add-on for updating fields. Use this plugin with 'WP All Import'
Version: 0.0.1
Author: Vlad Filonenko
*/

function onereach_pmxi_custom_field($value, $post_id, $key, $original_value, $existing_meta_keys, $import_id)
{
  if ($key === 'journal_image') {
    if (!!$value) {
      $imgName = pathinfo($value)['filename'];
      $basename = basename($value);
      global $wpdb;

      $post_name = sanitize_title($imgName);
      $res = $wpdb->get_row("SELECT ID FROM wp_posts WHERE post_type ='attachment' AND post_name = '$post_name'");
      if ($res) {
        return $res->ID;
      } else {
        $res = $wpdb->get_row("SELECT ID FROM wp_posts WHERE post_type ='attachment' AND `guid` LIKE '$basename'");
        if ($res) {
          return $res->ID;
        }
      }
    }
  }

  return $value;
}

add_filter('pmxi_custom_field', 'onereach_pmxi_custom_field', 10, 6);
