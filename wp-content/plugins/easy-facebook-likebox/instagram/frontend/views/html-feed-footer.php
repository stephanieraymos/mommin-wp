<?php

do_action( 'esf_insta_before_feed_footer', $esf_insta_feed );
$combined_atts = $hashtag . ',' . $feeds_per_page . ',' . $caption_words . ',' . $skin_id . ',' . $cache_seconds . ',' . $user_id;

if ( $mif_instagram_type == 'personal' ) {
    $mif_self_name = $mif_instagram_personal_accounts[$user_id]['username'];
    $mif_self_username = $mif_self_name;
} else {
    $mif_self_name = $esf_insta_user_data->name;
    $mif_self_username = $esf_insta_user_data->username;
}


if ( $hashtag && !empty($hashtag) ) {
    $mif_self_username = 'explore/tags/' . $hashtag;
    $mif_self_name = '#' . $hashtag;
}

?>

    <div class="esf_insta_load_more_btns_wrap">
        <div class="esf_insta_feed_btns_holder">

			<?php 
?>

            <div class="esf-insta-follow-btn-wrap">
                <a href="<?php 
echo  esc_url_raw( $this->instagram_url ) ;
?>/<?php 
echo  sanitize_text_field( $mif_self_username ) ;
?>"
                   class="esf-insta-follow-btn" target="_blank"><i
                            class="icon icon-esf-instagram"></i> <?php 
esc_html_e( 'Follow on Instagram', 'easy-facebook-likebox' );
?>
                </a>
            </div>

        </div>
    </div>
<?php 
do_action( 'esf_insta_after_feed_footer', $esf_insta_feed );