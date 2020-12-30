<?php

/** 
 * Represents the view for the public-facing feed of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 * 
 * @package   Easy Facebook like box
 * @author    Danish Ali Malik
 * @link      https://easysocialfeed.com
 * @copyright 2019 MaltaThemes
 */
extract( $instance );
error_reporting( E_ERROR | E_PARSE );
/*
 * Getting main class
 */
$FTA = new Feed_Them_All();
/*
 * Getting Settings
 */
$fta_settings = $FTA->fta_get_settings();
/*
 * Facebook Settings
 */
$fb_settings = $fta_settings['plugins']['facebook'];
/*
 * Getting approved pages.
 */
$approved_pages = $fb_settings['approved_pages'];

if ( !isset( $access_token ) or !isset( $instance['fb_appid'] ) ) {
    $access_token = $fb_settings['access_token'];
    if ( empty($access_token) ) {
        $access_token = '222116127877068|4223b75bbcf692242b677db0c08d9b56';
    }
}

if ( isset( $instance['fb_appid'] ) and !empty($instance['fb_appid']) ) {
    $access_token = $instance['fb_appid'];
}
$test_mode = false;
$test_mode = apply_filters( 'efbl_disable_cache', $test_mode );
if ( empty($fanpage_id) ) {
    $page_id = $fanpage_url;
}
if ( empty($fanpage_url) ) {
    $page_id = $fanpage_id;
}
$page_id = apply_filters( 'efbl_page_id_before_query', $page_id );
if ( empty($fanpage_id) && empty($fanpage_url) ) {
    $page_id = '617177998743210';
}
if ( is_customize_preview() ) {
    $page_id = get_option( 'efbl_account_id', false );
}
$page_id = efbl_parse_url( $page_id );
// echo "<pre>"; print_r($page_id);exit();
$efbl_page_slug = is_numeric( $page_id );
if ( $approved_pages ) {
    foreach ( $approved_pages as $efbl_page ) {
        if ( !$efbl_page_slug && $efbl_page['username'] && $efbl_page['username'] == $page_id ) {
            $page_id = $efbl_page['id'];
        }
        if ( $efbl_page['id'] == $page_id ) {
            $own_access_token = $efbl_page['access_token'];
        }
    }
}
$post_limit = ( $post_limit ? $post_limit : '10' );
$number_of_posts = ( $post_number ? $post_number : '10' );
if ( isset( $layout ) && !empty($layout) ) {
    
    if ( $layout == 'half' ) {
        $layout = 'halfwidth';
    } elseif ( $layout == 'full' ) {
        $layout = 'fullwidth';
    }

}
$link_target = ( $links_new_tab ? '_blank' : '_self' );

if ( empty($show_logo) || $show_logo == 0 ) {
    $show_logo = 0;
} else {
    $show_logo = 1;
}


if ( empty($show_image) || $show_image == 0 ) {
    $show_image = 0;
} else {
    $show_image = 1;
}

if ( empty($cache_unit) ) {
    $cache_unit = 5;
}
if ( $cache_unit < 1 ) {
    $cache_unit = 1;
}
//Calculate the cache time in seconds
if ( $cache_duration == 'minutes' ) {
    $cache_duration = 60;
}
if ( $cache_duration == 'hours' ) {
    $cache_duration = 60 * 60;
}
if ( $cache_duration == 'days' ) {
    $cache_duration = 60 * 60 * 24;
}
$cache_seconds = $cache_duration * $cache_unit;
//setting query for "Show Posts By"
$query = 'posts';
$others_only = false;

if ( $post_by == 'me' ) {
    $query = 'posts';
} else {
    
    if ( $post_by == 'others' ) {
        $query = 'feed';
    } else {
        
        if ( $post_by == 'onlyothers' ) {
            $query = 'feed';
            $others_only = true;
        }
    
    }

}

$enable_popup_for = [ 'photo', 'video' ];
$page_name = $approved_pages[$page_id]['name'];
$trasneint_name = 'efbl_' . $query . '_' . str_replace( ' ', '', $page_name ) . '-' . $post_limit;
if ( empty($page_name) ) {
    $trasneint_name = 'efbl_' . $query . '_' . str_replace( ' ', '', $page_id ) . '-' . $post_limit;
}
global  $efbl_skins ;
if ( is_customize_preview() ) {
    $skin_id = get_option( 'efbl_skin_id', false );
}
$is_saved_posts = false;
$next_post_url = null;
$posts_json = get_transient( $trasneint_name );
if ( isset( $posts_json ) && !empty($posts_json) ) {
    $is_saved_posts = true;
}
if ( $approved_pages ) {
    foreach ( $approved_pages as $key => $approved_page ) {
        if ( $approved_page['id'] == $page_id ) {
            $own_access_token = $approved_page['access_token'];
        }
    }
}
if ( empty($own_access_token) ) {
    $own_access_token = $fb_settings['access_token'];
}

if ( efl_fs()->is_free_plan() && !array_key_exists( $page_id, $approved_pages ) ) {
    reset( $approved_pages );
    $result = key( $approved_pages );
    $page_id = $result;
    $own_access_token = $approved_pages[$page_id]['access_token'];
}

$is_public_page = false;
if ( !array_key_exists( $page_id, $approved_pages ) ) {
    $is_public_page = true;
}
if ( empty($page_name) ) {
    $page_name = $page_id;
}
if ( isset( $accesstoken ) && !empty($accesstoken) ) {
    $own_access_token = $accesstoken;
}

if ( !$posts_json || '' == $posts_json || $test_mode ) {
    $efbl_api_url = add_query_arg( apply_filters( 'efbl_api_url_params', [
        'fields'       => 'posts.limit(' . $post_limit . '){place,status_type,full_picture,permalink_url,likes{pic_crop,id,name},comments.limit(30){id,like_count,permalink_url,comments,reactions,comment_count,created_time,message,message_tags,attachment},reactions{id,name,pic_crop,type,link},created_time,story,message,reactions.type(LIKE).limit(0).summary(1).as(like),reactions.type(LOVE).limit(0).summary(1).as(love),reactions.type(HAHA).limit(0).summary(1).as(haha),reactions.type(WOW).limit(0).summary(1).as(wow),reactions.type(SAD).limit(0).summary(1).as(sad),reactions.type(ANGRY).limit(0).summary(1).as(angry),from,message_tags,shares,story_tags,picture,attachments},about,picture{url}',
        'access_token' => $access_token,
        'locale'       => 'en_us',
    ], $instance ), apply_filters( 'efbl_api_url_base', 'https://graph.facebook.com/v4.0/' . $page_id . '', $instance ) );
    $posts_json = jws_fetchUrl( $efbl_api_url );
    $json_decoded = json_decode( $posts_json );
    if ( !$test_mode && !empty($json_decoded->posts->data) ) {
        set_transient( $trasneint_name, $posts_json, $cache_seconds );
    }
}

$json_decoded = json_decode( $posts_json );
$fbData = $json_decoded->posts->data;
$selected_skin = $instance['layout'];
if ( !$instance['layout'] && empty($instance['layout']) ) {
    $selected_skin = $efbl_skins[$skin_id]['layout'];
}

if ( is_customize_preview() ) {
    $skin_id = get_option( 'efbl_skin_id', false );
    $efbl_skin_settings = get_option( 'efbl_skin_' . $skin_id, false );
    $efbl_skin_values['design'] = $efbl_skin_settings;
    $layout = get_post_meta( $skin_id, 'layout', true );
    if ( !$layout ) {
        $layout = $efbl_skin_values['design']['layout_option'];
    }
} else {
    $efbl_skin_values = $efbl_skins[$skin_id];
}

// plan end
// Filter the feeds before showing
$fbData = apply_filters( 'efbl_pre_feeds_show', $fbData );
// echo "<pre>"; print_r($json_decoded);exit();

if ( !$json_decoded->error ) {
    $auth_img_src = efbl_get_page_logo( $page_id );
    $returner = null;
    $rand_id = mt_rand( 1, 10 );
    $efbl_bio_data = efbl_get_page_bio( $page_id, $access_token, $cache_seconds );
    $page_meta = $fb_settings['approved_pages'][$page_id];
    ?>

	<div class="efbl_feed_wraper efbl_skin_<?php 
    echo  $skin_id ;
    ?>" id="efbl_feed_<?php 
    echo  $rand_id ;
    ?>">

	<?php 
    
    if ( $efbl_skin_values['design']['show_header'] ) {
        
        if ( $esf_theme_header_url = locate_template( [ 'easy-facebook-likebox/html-feed-header.php' ] ) ) {
            $esf_theme_header_url = $esf_theme_header_url;
        } else {
            $esf_theme_header_url = EFBL_PLUGIN_DIR . 'frontend/views/html-feed-header.php';
        }
        
        include_once $esf_theme_header_url;
    }
    
    $is_sliced = false;
    $fbData = array_slice( $fbData, 0, $post_limit );
    if ( isset( $fbData ) && !empty($fbData) ) {
        $is_sliced = true;
    }
    
    if ( $fbData ) {
        $i = null;
        $pi = 1;
        // increment counter for popup gallery
        $efbl_skin = $efbl_skins[$skin_id]['design'];
        if ( empty($layout) ) {
            $layout = $selected_skin;
        }
        if ( $layout == 'half' ) {
            $layout = 'halfwidth';
        }
        if ( $layout == 'full' ) {
            $layout = 'fullwidth';
        }
        if ( empty($layout) ) {
            $layout = 'halfwidth';
        }
        $efbl_number_of_cols = $efbl_skin_values['design']['number_of_cols'];
        if ( !$efbl_number_of_cols ) {
            $efbl_number_of_cols = 3;
        }
        $carousel_class = null;
        $carousel_atts = null;
        ?>


 <div class="efbl_feeds_holder efbl_feeds_<?php 
        echo  $layout ;
        ?>  <?php 
        echo  $carousel_class ;
        ?>" <?php 
        echo  $carousel_atts ;
        ?> data-template="<?php 
        echo  $layout ;
        ?>">

<?php 
        ?>

<?php 
        foreach ( $fbData as $story ) {
            $efbl_comments_count = 0;
            $post_text = null;
            $story_id = $story->id;
            //get the feed type
            $feed_type = $story->status_type;
            
            if ( isset( $story->attachments->data[0]->type ) ) {
                $feed_attachment_type = $story->attachments->data[0]->type;
            } else {
                $feed_attachment_type = null;
            }
            
            $story_from_name = $story->from->name;
            if ( 'events' == $filter ) {
                $story_from_name = $story->owner->name;
            }
            $efbl_likes_count = $story->like->summary->total_count + $story->love->summary->total_count + $story->haha->summary->total_count + $story->wow->summary->total_count + $story->sad->summary->total_count + $story->angry->summary->total_count;
            if ( 'events' == $filter or 'albums' == $filter or 'videos' == $filter or 'images' == $filter or 'mentioned' == $filter ) {
                $efbl_likes_count = count( $story->reactions->data );
            }
            if ( isset( $story->comments->data ) ) {
                $efbl_comments_count = count( $story->comments->data );
            }
            if ( !$efbl_comments_count ) {
                $efbl_comments_count = 0;
            }
            //getting number of shares
            $shares = $story->shares;
            //get the time of story
            $time = $story->created_time;
            if ( 'events' == $filter ) {
                $time = $story->updated_time;
            }
            //convert time into minutes/days ago.
            $time = efbl_time_ago( $time );
            $story_link = 'https://www.facebook.com/' . $story->id;
            $pic_class = "efbl_no_image";
            if ( $story->full_picture && 'shared_story' !== $feed_type ) {
                $pic_class = "efbl_has_image";
            }
            
            if ( $feed_type == 'mobile_status_update' ) {
                if ( isset( $story->attachments->data['0']->description ) && !empty($story->attachments->data['0']->description) ) {
                    $post_text = $story->attachments->data['0']->description;
                }
                if ( isset( $story->attachments->data['0']->description_tags ) && !empty($story->attachments->data['0']->description_tags) ) {
                    $text_tags = $story->attachments->data['0']->description;
                }
            }
            
            
            if ( !$story_from_name ) {
                $efbl_no_story_name = 'efbl-empty-author-name';
            } else {
                $efbl_no_story_name = '';
            }
            
            ( isset( $story->message_tags ) ? $text_tags = $story->message_tags : ($text_tags = $story->story_tags) );
            
            if ( !empty($story->story) && $filter != 'mentioned' ) {
                $story_text = str_replace( $story_from_name, '', htmlspecialchars( $story->story ) );
            } else {
                $story_text = '';
            }
            
            //get mesasge
            if ( !empty($story->message) ) {
                $post_text = htmlspecialchars( $story->message );
            }
            $post_plain_text = $post_text;
            $html_check_array = [
                '&lt;',
                '’',
                '“',
                '&quot;',
                '&amp;',
                '#',
                'http'
            ];
            //Convert links url to html links
            $post_text = ecff_makeClickableLinks( $post_text, [ 'http', 'mail' ], [
                'target' => $link_target,
            ] );
            //convert hastags into links
            $post_text = ecff_hastags_to_link( $post_text );
            //always use the text replace method
            
            if ( ecff_stripos_arr( $post_text, $html_check_array ) !== false ) {
                //Loop through the tags
                if ( $text_tags ) {
                    foreach ( $text_tags as $message_tag ) {
                        $tag_name = $message_tag->name;
                        $tag_link = '<a href="https://facebook.com/' . $message_tag->id . '" target="' . $link_target . '">' . $tag_name . '</a>';
                        $post_text = str_replace( $tag_name, $tag_link, $post_text );
                    }
                }
            } else {
                //not html found now use manaul loop
                $message_tags_arr = [];
                $j = 0;
                if ( $text_tags ) {
                    foreach ( $text_tags as $message_tag ) {
                        $j++;
                        $tag_name = $message_tag->name;
                        $tag_link = '<a href="https://facebook.com/' . $message_tag->id . '" target="' . $link_target . '">' . $message_tag->name . '</a>';
                        $post_text = str_replace( $tag_name, $tag_link, $post_text );
                    }
                }
            }
            
            $feed_img = $story->full_picture;
            if ( !empty($feed_img) && 'shared_story' != $feed_type ) {
                $pic_class = "efbl_has_image";
            }
            $video_source = $story->attachments->data['0']->media->source;
            $efbl_feed_popup_url = '';
            if ( $layout == 'grid' && $pic_class != "efbl_has_image" ) {
                continue;
            }
            if ( $filter == 'albums' && $story->count == 0 ) {
                continue;
            }
            $video_iframe = null;
            $story_attach_type = $story->attachments->data['0']->type;
            if ( $story_attach_type == 'video_inline' && empty($video_source) ) {
                $video_iframe = '<iframe type="text/html" width="720"  height="512" src="https://www.facebook.com/v2.3/plugins/video.php?href=' . $story->attachments->data['0']->url . '?autoplay=1&amp;mute=0&width=720&height=512" allowfullscreen="" frameborder="0" webkitallowfullscreen="" mozallowfullscreen=""></iframe>';
            }
            //get author image src
            $author_image = '<a href="https://facebook.com/' . $page_id . '" title="' . $story->name . '" target="' . $link_target . '"><img alt="' . $story->name . '" src="' . $auth_img_src . '" title="' . $story->from->name . '" width="40" height="40" /></a>';
            if ( isset( $words_limit ) && !empty($words_limit) ) {
                
                if ( str_word_count( $post_text ) <= $words_limit ) {
                    $efbl_words_trimmed = false;
                } else {
                    $post_text = wp_trim_words( $post_text, $words_limit, '' );
                    $efbl_words_trimmed = true;
                }
            
            }
            $post_text = ecff_hastags_to_link( $post_text );
            $post_text = ecff_makeClickableLinks( $post_text, [ 'http', 'mail', 'https' ], [
                'target' => $link_target,
            ] );
            
            if ( $efbl_templateurl = locate_template( [ 'easy-facebook-likebox/templates/template-' . $layout . '.php' ] ) ) {
                $efbl_templateurl = $efbl_templateurl;
            } else {
                $efbl_templateurl = EFBL_PLUGIN_DIR . 'frontend/views/templates/template-' . $layout . '.php';
            }
            
            require $efbl_templateurl;
            $i++;
            if ( 'added_photos' == $feed_type or 'added_video' == $feed_type ) {
                $pi++;
            }
        }
        ?>

	 <?php 
        ?>  

	</div>

	<?php 
        
        if ( $esf_theme_footer_url = locate_template( [ 'easy-facebook-likebox/facebook/frontend/views/html-feed-footer.php' ] ) ) {
            $esf_theme_footer_url = $esf_theme_footer_url;
        } else {
            $esf_theme_footer_url = EFBL_PLUGIN_DIR . 'frontend/views/html-feed-footer.php';
        }
        
        include_once $esf_theme_footer_url;
    } else {
        
        if ( $filter ) {
            
            if ( isset( $events_filter ) && $events_filter == 'upcoming' ) {
                $events_filter_name = __( "upcoming", 'easy-facebook-likebox' );
            } else {
                $events_filter_name = '';
            }
            
            ?>

			<p class="efbl_error_msg"><?php 
            echo  __( "{$efbl_bio_data->name} don't have any {$events_filter_name} {$filter}.", 'easy-facebook-likebox' ) ;
            ?> </p>

  <?php 
        } else {
            ?>

  			<p class="efbl_error_msg"> <?php 
            echo  __( 'Whoops! Nothing found according to your query, Try changing parameters to see posts.', 'easy-facebook-likebox' ) ;
            ?> </p>

	<?php 
        }
    
    }
    
    //empty end
    //Display like box here if enabled
    
    if ( $show_like_box ) {
        ?>
		
		<div class="efbl_custom_likebox"><?php 
        echo  do_shortcode( '[efb_likebox fanpage_url="' . $page_id . '" box_width="" box_height="500" colorscheme="light" locale="en_US" responsive="1" show_faces="0" show_header="0" show_stream="0" show_border="0" ]' ) ;
        ?></div>
  <?php 
    }
    
    ?>
		<input type="hidden" id="item_number" value="">
	</div>

<?php 
    do_action( 'efbl_after_feed_footer', $json_decoded );
} else {
    $error_msg = $json_decoded->error->message;
    
    if ( $fbData->error->code == 10 ) {
        $error_msg = __( 'Please authenticate your Facebook pages from Easy Social Feed settings page and use page id of approved pages only', 'easy-facebook-likebox' );
    } else {
        ?>

		<p class="efbl_error_msg"><?php 
        echo  __( 'Error: ', 'easy-facebook-likebox' ) ;
        ?> <?php 
        echo  $error_msg ;
        ?></p>
<?php 
    }

}
