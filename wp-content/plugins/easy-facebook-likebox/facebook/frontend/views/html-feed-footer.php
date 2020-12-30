<?php

do_action( 'efbl_before_feed_footer', $json_decoded );
/*
* Combinig shortcode atts for getting feeds from instagram api.
*/
$combined_atts = $post_limit . ',' . $words_limit . ',' . $skin_id . ',' . $cache_seconds . ',' . $page_id . ',' . $layout . ',' . $trasneint_name . ',' . $filter . ',' . $events_filter . ',' . $link_target;
if ( !$is_saved_posts && empty($next_post_url) ) {
    $load_btn_disabled = 'no-more';
}