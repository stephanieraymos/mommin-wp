<?php


if ( ! isset( $esf_insta_user_data->error ) && empty( $esf_insta_user_data->error ) ) {

	do_action( 'esf_insta_before_post_header', $esf_insta_user_data );

	if ( $mif_instagram_type == 'personal' ) {

		$mif_self_name = $mif_instagram_personal_accounts[ $user_id ]['username'];

		$mif_self_username = $mif_self_name;

	} else {
		$mif_self_name = $esf_insta_user_data->name;

		$mif_self_username = $esf_insta_user_data->username;
	}

	$mif_self_name = apply_filters( 'esf_insta_feed_post_name', $mif_self_name, $esf_insta_user_data );

	if ( $hashtag && ! empty( $hashtag ) ) {

		$mif_self_username = 'explore/tags/' . $hashtag;

		$mif_self_name = '#' . $hashtag;
	}

	?>

    <div class="esf-insta-d-flex">

		<?php if ( $esf_insta_user_data->profile_picture_url && $mif_values['feed_header_logo'] ) { ?>

            <div class="esf-insta-profile-image">
                <a href="<?php echo esc_url_raw( $this->instagram_url ); ?>/<?php echo sanitize_text_field( $mif_self_username ); ?>"
                   title="@<?php echo sanitize_text_field( $mif_self_username ); ?>"
                   target="_blank">

                    <img src="<?php echo esc_url( apply_filters( 'esf_insta_post_header_image', $esf_insta_user_data->profile_picture_url, $esf_insta_user_data ) ); ?>"/>

					<?php if ( $hashtag && ! empty( $hashtag ) ) { ?>

                        <span class="esf-insta-hashtag-overlay"><i
                                    class="icon icon-esf-instagram"></i></span>

					<?php } ?>

                </a>
            </div>

		<?php } ?>

        <div class="esf-insta-profile-title">

			<?php if ( $mif_self_name ) { ?>

                <div class="esf-insta-profile-title-wrap ">
                    <h2><?php echo $mif_self_name; ?></h2>
                </div>

			<?php } ?>

            <span><?php echo $feed_time; ?></span>

        </div>
    </div>

	<?php do_action( 'esf_insta_after_post_header', $esf_insta_user_data );

} ?>