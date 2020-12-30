<?php

$efbl_bio_data = efbl_get_page_bio( $page_id, $access_token, $cache_seconds );

$page_meta = $fb_settings['approved_pages'][ $page_id ];


if ( $efbl_bio_data ) {
	do_action( 'efbl_before_feed_header', $page_meta );
	?>

    <div class="efbl_header">
        <div class="efbl_header_inner_wrap">

			<?php if ( $auth_img_src && $efbl_skin_values['design']['show_dp'] ) : ?>

                <div class="efbl_header_img">
                    <a href="https://www.facebook.com/<?php echo $efbl_bio_data->id; ?>"
                       target="_blank"><img src="<?php echo $auth_img_src; ?>"/>
                    </a>
                </div>

			<?php endif; ?>
            <div class="efbl_header_content">
                <div class="efbl_header_meta">
                    <div class="efbl_header_title">
                        <h4><?php echo $efbl_bio_data->name; ?></h4>
                    </div>
					<?php if ( isset( $efbl_bio_data->category ) && $efbl_skin_values['design']['show_page_category'] ) : ?>

                        <div class="efbl_cat"
                             title="<?php echo __( 'Category', 'easy-facebook-likebox' ); ?>">
                            <i class="icon icon-esf-tag"
                               aria-hidden="true"></i><?php echo $efbl_bio_data->category; ?>
                        </div>

					<?php endif;

					if ( isset( $efbl_bio_data->fan_count ) && $efbl_skin_values['design']['show_no_of_followers'] ) : ?>

                        <div class="efbl_followers"
                             title="<?php echo __( 'Followers', 'easy-facebook-likebox' ); ?>">
                            <i class="icon icon-esf-user"
                               aria-hidden="true"></i><?php echo efbl_readable_count( $efbl_bio_data->fan_count ); ?>
                        </div>

					<?php endif; ?>
                </div>
				<?php if ( isset( $efbl_bio_data->about ) && $efbl_skin_values['design']['show_bio'] ) : ?>

                    <p class="efbl_bio"><?php echo $efbl_bio_data->about; ?></p>

				<?php endif; ?>
            </div>
        </div>
    </div>

	<?php do_action( 'efbl_after_feed_header', $page_meta );
} ?>