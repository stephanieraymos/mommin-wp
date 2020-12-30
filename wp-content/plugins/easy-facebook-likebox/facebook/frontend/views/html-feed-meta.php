<?php

do_action( 'efbl_before_feed_meta', $story );
$reactions_arr = $story->reactions->data;
// if($filter && $filter == 'albums'):
//   $reactions_arr = $story->photos->data[0]->reactions->data;
// endif;
$efbl_love = efbl_check_reaction( 'LOVE', $reactions_arr );
$efbl_wow = efbl_check_reaction( 'WOW', $reactions_arr );
$efbl_angry = efbl_check_reaction( 'ANGRY', $reactions_arr );
$efbl_haha = efbl_check_reaction( 'HAHA', $reactions_arr );
$efbl_likes = efbl_check_reaction( 'LIKE', $reactions_arr );
$efbl_reactions_class = '';
?>
    <div class="efbl-post-footer">


        <div class="efbl-d-flex efbl-justify-content-between">
            <div class="efbl-reacted efbl-d-flex efbl-align-items-center">

				<?php 

if ( $efbl_likes_count > 0 || $efbl_wow && $efbl_wow['total_count'] > 0 || $efbl_haha && $efbl_haha['total_count'] > 0 || $efbl_angry && $efbl_angry['total_count'] > 0 ) {
    ?>

					<?php 
    
    if ( $efbl_skin_values['design']['show_likes'] ) {
        ?>

                        <div class="efbl-reacted-item emotis <?php 
        echo  $efbl_reactions_class ;
        ?>" <?php 
        echo  $efbl_reactions_modal ;
        ?>>

							<?php 
        if ( $efbl_likes_count > 0 ) {
            ?>
                                <i class="icon icon-esf-thumbs-o-up"></i>
							<?php 
        }
        ?>

							<?php 
        //efl_fs()->can_use_premium_code__premium_only()
        ?>
							<?php 
        echo  efbl_readable_count( $efbl_likes_count ) ;
        ?>
                        </div>
					<?php 
    }

}

// All reactions check
?>



				<?php 

if ( $efbl_comments_count > 0 && $efbl_skin_values['design']['show_comments'] ) {
    ?>
                    <div class="efbl-reacted-item">

						<?php 
    ?>

                            <i class="icon icon-esf-comment-o"></i><?php 
    echo  efbl_readable_count( $efbl_comments_count ) ;
    ?>

							<?php 
    ?>

                    </div>
				<?php 
}

?>

				<?php 

if ( $story->shares->count > 0 && $efbl_skin_values['design']['show_shares'] ) {
    ?>

                    <div class="efbl-reacted-item"><i
                                class="icon icon-esf-share"></i><?php 
    echo  efbl_readable_count( $story->shares->count ) ;
    ?>
                    </div>

				<?php 
}

?>


            </div>
            <div class="efbl-view-share efbl-d-flex efbl-justify-content-between efbl-align-items-center efbl-mb-1 efbl-mt-1">

				<?php 

if ( $efbl_skin_values['design']['show_feed_view_on_facebook'] ) {
    ?>

                    <a href="<?php 
    echo  $story_link ;
    ?>"
                       target="<?php 
    echo  $link_target ;
    ?>"
                       class="efbl-view-on-fb no-anchor-style link efbl-mr-1"><?php 
    echo  __( 'View on Facebook', 'easy-facebook-likebox' ) ;
    ?></a>

				<?php 
}

?>

				<?php 

if ( $efbl_skin_values['design']['show_feed_share_button'] ) {
    ?>

                    <div class="esf-share-wrapper">
                        <button class="no-anchor-style link esf-share"><?php 
    echo  __( 'Share', 'easy-facebook-likebox' ) ;
    ?></button>
                        <div class="esf-social-share">
                            <button>
                                <a class="efbl_facebook"
                                   href="https://www.facebook.com/sharer/sharer.php?u=<?php 
    echo  $story_link ;
    ?>"
                                   target="<?php 
    echo  $link_target ;
    ?>">
                                    <i class="icon icon-esf-facebook"></i>
                                </a>
                            </button>

                            <button>
                                <a class="efbl_twitter"
                                   href="https://twitter.com/intent/tweet?text=<?php 
    echo  $story_link ;
    ?>"
                                   target="<?php 
    echo  $link_target ;
    ?>">
                                    <i class="icon icon-esf-twitter"></i>
                                </a>
                            </button>

                            <button>
                                <a class="efbl_linked_in"
                                   href="https://www.linkedin.com/shareArticle?mini=true&url=<?php 
    echo  $story_link ;
    ?>"
                                   target="<?php 
    echo  $link_target ;
    ?>">
                                    <i class="icon icon-esf-linkedin"></i>
                                </a>
                            </button>
                        </div>
                    </div>
				<?php 
}

?>

            </div>

        </div>


    </div>

<?php 
do_action( 'efbl_after_feed_meta', $story );