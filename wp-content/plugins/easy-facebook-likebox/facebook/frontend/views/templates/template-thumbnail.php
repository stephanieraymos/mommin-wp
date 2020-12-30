<?php

/*
* Stop execution if someone tried to get file directly.
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
list( $efbl_feed_width, $efbl_feed_height, $type, $attr ) = getimagesize( $feed_img );
$efbl_ver = 'free';
if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
    $efbl_ver = 'pro';
}
$efbl_free_popup_type = 'data-imagelink="' . $feed_img . '"';
$efbl_free_popup_class = null;

if ( 'added_video' == $feed_type && !empty($video_source) ) {
    $efbl_free_popup_type = 'data-video="' . $video_source . '"';
    $efbl_free_popup_class = 'efbl_popup_video';
}

?>

<div class="efbl-thumbnail-skin <?php 
echo  $feed_type ;
?> efbl-story-wrapper">

    <div class="efbl-thumbnail-wrapper">
        <div class="efbl-row">

			<?php 

if ( $feed_type == 'mobile_status_update' ) {
    $efbl_status_col_img = 12;
    ?>

				<?php 
    
    if ( $story->attachments->data[0]->media->image->src ) {
        $efbl_status_col_img = 4;
        $efbl_status_col_content = 8;
        ?>
                    <div class="efbl-col-<?php 
        echo  $efbl_status_col_img ;
        ?> efbl-thumbnail-col">

						<?php 
        
        if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {
            ?>

                            <a href="<?php 
            echo  admin_url( 'admin-ajax.php' ) ;
            ?>?action=efbl_generate_popup_html&rand_id=<?php 
            echo  $rand_id ;
            ?>" <?php 
            echo  $efbl_free_popup_type ;
            ?> data-storylink="<?php 
            echo  $story_link ;
            ?>" data-linktext="<?php 
            echo  __( 'Read full story', 'easy-facebook-likebox' ) ;
            ?>" data-caption="<?php 
            echo  htmlentities( $post_text ) ;
            ?>" data-itemnumber="<?php 
            echo  $pi ;
            ?>" class="efbl_feed_popup <?php 
            echo  $efbl_free_popup_class ;
            ?> efbl-cff-item_number-<?php 
            echo  $pi ;
            ?>">
                                <div class="efbl-overlay">

									<?php 
            if ( $efbl_skin_values['design']['show_feed_open_popup_icon'] ) {
                ?>

                                        <i class="icon icon-esf-plus efbl-plus"
                                           aria-hidden="true"></i>

									<?php 
            }
            ?>
									<?php 
            if ( $feed_type == 'added_video' || $feed_attachment_type == 'video_inline' ) {
                ?>
                                        <i class="icon icon-esf-clone icon-esf-video-camera"
                                           aria-hidden="true"></i>
									<?php 
            }
            if ( isset( $story->attachments->data['0']->subattachments->data ) && !empty($story->attachments->data['0']->subattachments->data) ) {
                ?>
                                        <i class="icon icon-esf-clone efbl_multimedia"
                                           aria-hidden="true"></i>
									<?php 
            }
            ?>
                                </div>
                                <img alt="<?php 
            echo  $story->name ;
            ?>"
                                     src="<?php 
            echo  $story->attachments->data[0]->media->image->src ;
            ?>"/>
                                <div class="efbl-overlay">


									<?php 
            if ( $efbl_skin_values['design']['show_feed_open_popup_icon'] ) {
                ?>

                                        <i class="icon icon-esf-plus efbl-plus"
                                           aria-hidden="true"></i>

										<?php 
            }
            ?>
									<?php 
            if ( $feed_type == 'added_video' ) {
                ?>
                                        <i class="icon icon-esf-clone icon-esf-video-camera"
                                           aria-hidden="true"></i>
										<?php 
            }
            if ( isset( $story->attachments->data['0']->subattachments->data ) && !empty($story->attachments->data['0']->subattachments->data) ) {
                ?>
                                        <i class="icon icon-esf-clone efbl_multimedia"
                                           aria-hidden="true"></i>
										<?php 
            }
            ?>
                                </div>
                            </a>

						<?php 
        }
        
        ?>

                    </div>
				<?php 
    }
    
    ?>


                <div class="efbl-feed-content efbl-col-<?php 
    echo  $efbl_status_col_content ;
    ?>  ">

					<?php 
    
    if ( $efbl_skin_values['design']['feed_header'] ) {
        ?>

                        <div class="efbl-d-flex">

							<?php 
        
        if ( $efbl_skin_values['design']['feed_header_logo'] ) {
            ?>

                                <div class="efbl-profile-image">
                                    <a href="https://facebook.com/<?php 
            echo  $page_id ;
            ?>"
                                       title="<?php 
            echo  $story->name ;
            ?>"
                                       target="<?php 
            echo  $link_target ;
            ?>">
                                        <img alt="<?php 
            echo  $story->name ;
            ?>"
                                             src="<?php 
            echo  $auth_img_src ;
            ?>"/></a>
                                </div>

							<?php 
        }
        
        ?>

                            <div class="efbl-profile-title">
                                <div class="efbl-profile-title-wrap <?php 
        echo  $efbl_no_story_name ;
        ?>">
                                    <h2><?php 
        echo  $story_from_name ;
        ?> <span
                                                class="efbl-profile-story-text"><?php 
        echo  $story_text ;
        ?> </span>
                                    </h2>
                                </div>
                                <span><?php 
        echo  $time ;
        ?></span>
                            </div>
                        </div>

					<?php 
    }
    
    ?>


					<?php 
    
    if ( $story->attachments->data[0] ) {
        ?>

                        <div class="efbl_link_text">

                            <p class="efbl_title_link">
                                <a href="<?php 
        echo  $story_link ;
        ?>"
                                   target="<?php 
        echo  $link_target ;
        ?>">
									<?php 
        echo  $story->attachments->data['0']->title ;
        ?>
                                </a>
                            </p>
                        </div>

						<?php 
        
        if ( $post_text ) {
            ?>
							<?php 
            
            if ( $efbl_skin_values['design']['show_feed_caption'] ) {
                ?>
                                <p class="description">
                                    <span class="efbl-description-wrap"><?php 
                echo  nl2br( $post_text ) ;
                ?></span>


									<?php 
                ?>


                                </p>

							<?php 
            }
            
            ?>
						<?php 
        }
        
        ?>

					<?php 
    } else {
        ?>
						<?php 
        
        if ( $efbl_skin_values['design']['show_feed_caption'] ) {
            ?>
                            <p class="description">
                                <span class="efbl-description-wrap"><?php 
            echo  nl2br( $post_text ) ;
            ?></span>


								<?php 
            ?>


                            </p>

						<?php 
        }
        
        ?>

					<?php 
    }
    
    ?>

                </div>

			<?php 
}


if ( $feed_type == 'shared_story' ) {
    $efbl_shared_img_col = 12;
    $shared_src = $story->attachments->data['0']->media->source;
    if ( !isset( $shared_src ) || empty($shared_src) ) {
        $shared_src = $story->full_picture;
    }
    list( $shared_src_width, $shared_src_height, $type, $attr ) = getimagesize( $shared_src );
    if ( $shared_src_width <= 1 || $shared_src_height <= 1 ) {
        $shared_src = null;
    }
    ?>


				<?php 
    
    if ( $story->full_picture ) {
        $efbl_shared_img_col = 8;
        ?>

                <div class="efbl-col-4 efbl-thumbnail-col">

					<?php 
        
        if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {
            ?>

                    <a href="<?php 
            echo  $story->attachments->data['0']->url ;
            ?>"
                       class="efbl_link_image"
                       target="<?php 
            echo  $link_target ;
            ?>"><img
                                alt="<?php 
            echo  $story->name ;
            ?>"
                                src="<?php 
            echo  $story->full_picture ;
            ?>"/>

						<?php 
        }
        
        ?>

                </div>
			<?php 
    }
    
    ?>

                <div class="efbl-feed-content efbl-col-<?php 
    echo  $efbl_shared_img_col ;
    ?>  ">

					<?php 
    
    if ( $efbl_skin_values['design']['feed_header'] ) {
        ?>

                        <div class="efbl-d-flex">

							<?php 
        
        if ( $efbl_skin_values['design']['feed_header_logo'] ) {
            ?>

                                <div class="efbl-profile-image">
                                    <a href="https://facebook.com/<?php 
            echo  $page_id ;
            ?>"
                                       title="<?php 
            echo  $story->name ;
            ?>"
                                       target="<?php 
            echo  $link_target ;
            ?>">
                                        <img alt="<?php 
            echo  $story->name ;
            ?>"
                                             src="<?php 
            echo  $auth_img_src ;
            ?>"/></a>
                                </div>

							<?php 
        }
        
        ?>

                            <div class="efbl-profile-title">
                                <div class="efbl-profile-title-wrap <?php 
        echo  $efbl_no_story_name ;
        ?>">
                                    <h2><?php 
        echo  $story_from_name ;
        ?> <span
                                                class="efbl-profile-story-text"><?php 
        echo  $story_text ;
        ?> </span>
                                    </h2>
                                </div>
                                <span><?php 
        echo  $time ;
        ?></span>
                            </div>
                        </div>

					<?php 
    }
    
    ?>


					<?php 
    
    if ( $post_text ) {
        ?>
						<?php 
        
        if ( $efbl_skin_values['design']['show_feed_caption'] ) {
            ?>
                            <p class="description">
                                <span class="efbl-description-wrap"><?php 
            echo  nl2br( $post_text ) ;
            ?></span>


								<?php 
            ?>


                            </p>

						<?php 
        }
        
        ?>

					<?php 
    }
    
    ?>

                    <div class="efbl_link_text">

                        <p class="efbl_title_link">
                            <a href="<?php 
    echo  $story->attachments->data['0']->url ;
    ?>"
                               target="<?php 
    echo  $link_target ;
    ?>">
								<?php 
    echo  $story->attachments->data['0']->title ;
    ?>
                            </a>
                        </p>
						<?php 
    
    if ( $efbl_skin_values['design']['show_feed_caption'] ) {
        ?>
                            <p class="efbl_link_description"><?php 
        echo  $story->attachments->data['0']->description ;
        ?></p>

						<?php 
    }
    
    ?>
                    </div>


                </div>

			<?php 
}


if ( $feed_type == 'added_photos' || $feed_type == 'added_video' || $filter == 'images' || $filter == 'albums' ) {
    // echo "<pre>"; print_r($story);exit();
    ?>


                <div class="efbl-thumbnail-col efbl-col-4">

					<?php 
    
    if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {
        ?>

                        <a href="<?php 
        echo  admin_url( 'admin-ajax.php' ) ;
        ?>?action=efbl_generate_popup_html&rand_id=<?php 
        echo  $rand_id ;
        ?>" <?php 
        echo  $efbl_free_popup_type ;
        ?>
                           data-storylink="<?php 
        echo  $story_link ;
        ?>"
                           data-linktext="<?php 
        echo  __( 'Read full story', 'easy-facebook-likebox' ) ;
        ?>"
                           data-caption="<?php 
        echo  htmlentities( $post_text ) ;
        ?>"
                           data-itemnumber="<?php 
        echo  $pi ;
        ?>"
                           class="efbl_feed_popup <?php 
        echo  $efbl_free_popup_class ;
        ?> efbl-cff-item_number-<?php 
        echo  $pi ;
        ?>">
                            <div class="efbl-overlay">

								<?php 
        if ( $efbl_skin_values['design']['show_feed_open_popup_icon'] ) {
            ?>

                                    <i class="icon icon-esf-plus efbl-plus"
                                       aria-hidden="true"></i>

								<?php 
        }
        ?>
								<?php 
        if ( $feed_type == 'added_video' || $feed_attachment_type == 'video_inline' ) {
            ?>
                                    <i class="icon icon-esf-clone icon-esf-video-camera"
                                       aria-hidden="true"></i>
								<?php 
        }
        if ( isset( $story->attachments->data['0']->subattachments->data ) && !empty($story->attachments->data['0']->subattachments->data) ) {
            ?>
                                    <i class="icon icon-esf-clone efbl_multimedia"
                                       aria-hidden="true"></i>
								<?php 
        }
        ?>
                            </div>
                            <img src="<?php 
        echo  $feed_img ;
        ?>"
                                 class="img-responsive"
                                 alt="<?php 
        echo  $story_from_name ;
        ?>"/>
                        </a>

					<?php 
    }
    
    ?>


                </div>

                <div class="efbl-feed-content efbl-col-8  ">

					<?php 
    
    if ( $efbl_skin_values['design']['feed_header'] ) {
        ?>

                        <div class="efbl-d-flex">

							<?php 
        
        if ( $efbl_skin_values['design']['feed_header_logo'] ) {
            ?>

                                <div class="efbl-profile-image">
                                    <a href="https://facebook.com/<?php 
            echo  $page_id ;
            ?>"
                                       title="<?php 
            echo  $story->name ;
            ?>"
                                       target="<?php 
            echo  $link_target ;
            ?>">
                                        <img alt="<?php 
            echo  $story->name ;
            ?>"
                                             src="<?php 
            echo  $auth_img_src ;
            ?>"/></a>
                                </div>

							<?php 
        }
        
        ?>

                            <div class="efbl-profile-title">
                                <div class="efbl-profile-title-wrap <?php 
        echo  $efbl_no_story_name ;
        ?>">
                                    <h2><?php 
        echo  $story_from_name ;
        ?> <span
                                                class="efbl-profile-story-text"><?php 
        echo  $story_text ;
        ?> </span>
                                    </h2>
                                </div>
                                <span><?php 
        echo  $time ;
        ?></span>
                            </div>
                        </div>

					<?php 
    }
    
    ?>


					<?php 
    
    if ( $filter == 'videos' ) {
        ?>

                        <div class="efbl_videos_data_holder">
                            <h6 class="efbl_videos_title">
                                <a href="https://www.facebook.com<?php 
        echo  $story->permalink_url ;
        ?>"
                                   target="<?php 
        echo  $link_target ;
        ?>">
									<?php 
        echo  $story->title ;
        ?>
                                </a>
                            </h6>
                        </div>

					<?php 
    }
    
    ?>

					<?php 
    
    if ( $post_text ) {
        ?>
						<?php 
        
        if ( $efbl_skin_values['design']['show_feed_caption'] ) {
            ?>
                            <p class="description">
                                <span class="efbl-description-wrap"><?php 
            echo  nl2br( $post_text ) ;
            ?></span>


								<?php 
            ?>


                            </p>

						<?php 
        }
        
        ?>
					<?php 
    }
    
    ?>

					<?php 
    
    if ( $filter == 'albums' ) {
        ?>

                        <div class="efbl_albums_data_holder">

                            <h6 class="efbl_albums_title">
                                <a href="<?php 
        echo  $story->link ;
        ?>"
                                   target="<?php 
        echo  $link_target ;
        ?>">
									<?php 
        echo  $story->name ;
        ?>
                                </a>
                            </h6>

                            <div class="efbl-total-album-images">
                                <span class="efbl_albums_icon"><i
                                            class="icon icon-esf-picture-o"
                                            aria-hidden="true"></i></span>
                                <span class="efbl_albums_count"><?php 
        echo  $story->count ;
        ?> </span>
                            </div>

                        </div>

					<?php 
    }
    
    ?>

                </div>
			<?php 
}


if ( $feed_type == 'created_event' || $filter == 'events' ) {
    // premium codition
    ?>

				<?php 
    
    if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {
        ?>

				<?php 
        
        if ( $story->attachments->data[0]->media->image->src ) {
            ?>
                    <div class="efbl-col-4">

                        <img src="<?php 
            echo  $story->attachments->data[0]->media->image->src ;
            ?>"/></a>

                    </div>
				<?php 
        }
        
        ?>

                <div class="efbl-feed-content efbl-col-8  ">

					<?php 
        
        if ( $efbl_skin_values['design']['feed_header'] ) {
            ?>

                        <div class="efbl-d-flex">

							<?php 
            
            if ( $efbl_skin_values['design']['feed_header_logo'] ) {
                ?>

                                <div class="efbl-profile-image">
                                    <a href="https://facebook.com/<?php 
                echo  $page_id ;
                ?>"
                                       title="<?php 
                echo  $story->name ;
                ?>"
                                       target="<?php 
                echo  $link_target ;
                ?>">
                                        <img alt="<?php 
                echo  $story->name ;
                ?>"
                                             src="<?php 
                echo  $auth_img_src ;
                ?>"/></a>
                                </div>

							<?php 
            }
            
            ?>

                            <div class="efbl-profile-title">
                                <div class="efbl-profile-title-wrap <?php 
            echo  $efbl_no_story_name ;
            ?>">
                                    <h2><?php 
            echo  $story_from_name ;
            ?> <span
                                                class="efbl-profile-story-text"><?php 
            echo  $story_text ;
            ?> </span>
                                    </h2>
                                </div>
                                <span><?php 
            echo  $time ;
            ?></span>
                            </div>
                        </div>

					<?php 
        }
        
        ?>
					<?php 
        
        if ( $efbl_skin_values['design']['show_feed_caption'] ) {
            ?>
                        <p class="efbl_link_description"><?php 
            echo  $post_text ;
            ?></p>
					<?php 
        }
        
        ?>

                </div>

			<?php 
    }
    
    ?>


			<?php 
}

// events conditon
?>


        </div>
		<?php 

if ( $esf_feed_meta_url = locate_template( [ 'easy-facebook-likebox/html-feed-meta.php' ] ) ) {
    $esf_feed_meta_url = $esf_feed_meta_url;
} else {
    $esf_feed_meta_url = EFBL_PLUGIN_DIR . 'frontend/views/html-feed-meta.php';
}

include $esf_feed_meta_url;
?>
    </div>

</div>