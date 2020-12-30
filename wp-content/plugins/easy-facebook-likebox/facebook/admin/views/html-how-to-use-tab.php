<?php

/**
 * Admin View: Tab - How to Use
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global  $efbl_skins ;
$FTA = new Feed_Them_All();
$fta_settings = $FTA->fta_get_settings();
$efbl_default_likebox_notice = '';
?>
<div id="efbl-general" class="col s12 efbl_tab_c slideLeft">
    <div class="row">
        <div class="efbl-tabs-vertical">
            <div class="col s2 efbl_si_tabs_name_holder">
                <ul class="tabs">
                    <li class="tab">
                        <a class="active"
                           href="#efbl-feed-use"><?php 
esc_html_e( "Facebook Page feed", 'easy-facebook-likebox' );
?></a>
                    </li>
                    <li class="tab">
                        <a href="#efbl-likebox-use"><?php 
esc_html_e( "Facebook Page Likebox", 'easy-facebook-likebox' );
?></a>
                    </li>

                </ul>
            </div>
            <div class="col s10  efbl_tabs_holder">
                <div id="efbl-feed-use" class="tab-content efbl_tab_c_holder">

                    <div class="row">

                        <div class="efbl_collapsible_info col s12">

                            <div class="efbl_default_shortcode_holder col s8">
                                <h5><?php 
esc_html_e( "How to use this plugin?", 'easy-facebook-likebox' );
?></h5>

								<?php 

if ( isset( $fta_settings['plugins']['facebook']['approved_pages'] ) && !empty($fta_settings['plugins']['facebook']['approved_pages']) ) {
    $default_page_id = efbl_default_page_id();
    ?>

                                    <p><?php 
    esc_html_e( "Copy and paste the following shortcode in any page, post or text widget to display the feed.", 'easy-facebook-likebox' );
    ?></p>
                                    <div class="efbl-shortcode-holder">
                                        <blockquote
                                                class="efbl-shortcode-block">
                                            [efb_feed fanpage_id="<?php 
    echo  $default_page_id ;
    ?>" skin_id="<?php 
    echo  efbl_default_skin_id() ;
    ?>" words_limit="25"]
                                        </blockquote>

                                        <a class="btn waves-effect efbl_copy_shortcode waves-light tooltipped"
                                           data-position="right" data-delay="50"
                                           data-tooltip="<?php 
    esc_html_e( "Copy", 'easy-facebook-likebox' );
    ?>"
                                           data-clipboard-text='[efb_feed fanpage_id="<?php 
    echo  $default_page_id ;
    ?>" skin_id="<?php 
    echo  efbl_default_skin_id() ;
    ?>" words_limit="25"]'
                                           href="javascript:void(0);"><i
                                                    class="material-icons right">content_copy</i>
                                        </a>
                                    </div>

								<?php 
} else {
    ?>

                                    <blockquote
                                            class="efbl-red-notice"><?php 
    esc_html_e( "It looks like you did not authenticate the plugin. Please go to ", 'easy-facebook-likebox' );
    ?>
                                        <a href="<?php 
    echo  esc_url( admin_url( 'admin.php?page=easy-facebook-likebox' ) ) ;
    ?>"><?php 
    esc_html_e( "Authenticate", 'easy-facebook-likebox' );
    ?></a> <?php 
    esc_html_e( 'page and click on the "Connect My Facebook Pages" button', 'easy-facebook-likebox' );
    ?>
                                    </blockquote>

								<?php 
}

?>

                                <h5 class="efbl_more_head"><?php 
esc_html_e( "Need More Options?", 'easy-facebook-likebox' );
?></h5>

                                <p><?php 
esc_html_e( "Use the following shortcode generator to further customize the shortcode.", 'easy-facebook-likebox' );
?></p>

                            </div>

                            <div class="efbl_shortocode_genrator_main col s4">
                                <h5><?php 
esc_html_e( "How to use shortcode?", 'easy-facebook-likebox' );
?></h5>
                                <ol>
                                    <li><?php 
esc_html_e( "Generate the shortcode using the shortcode generator below.", 'easy-facebook-likebox' );
?></li>
                                    <li><?php 
esc_html_e( "Copy the shortcode in the left column or generate shortcode if you need more options.", 'easy-facebook-likebox' );
?></li>
                                    <li><?php 
esc_html_e( "Paste in the page/post content or in text widget", 'easy-facebook-likebox' );
?></li>
                                </ol>
                            </div>

                            <form class="efbl_shortocode_genrator"
                                  name="efbl_shortocode_genrator" type="post">
                                <h5><?php 
esc_html_e( "Shortcode Generator", 'easy-facebook-likebox' );
?></h5>
                                <div class="input-field col s12 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_page_info">?</a>
                                    <select id="efbl_page_id"
                                            class="icons efbl_page_id">
										<?php 

if ( $fta_settings['plugins']['facebook']['approved_pages'] ) {
    foreach ( $fta_settings['plugins']['facebook']['approved_pages'] as $efbl_page ) {
        
        if ( $efbl_page['id'] ) {
            
            if ( isset( $efbl_page['username'] ) ) {
                $username = $efbl_page['username'];
            } else {
                $username = $efbl_page['id'];
            }
            
            ?>

                                                    <option value="<?php 
            echo  $username ;
            ?>"
                                                            data-icon="<?php 
            echo  efbl_get_page_logo( $efbl_page['id'] ) ;
            ?>"><?php 
            echo  $efbl_page['name'] ;
            ?></option>

												<?php 
        }
    
    }
} else {
    ?>

                                            <option value="" disabled
                                                    selected><?php 
    esc_html_e( "No page(s) found, Please connect your Facebook page with plugin first from authenticate tab", 'easy-facebook-likebox' );
    ?></option>

										<?php 
}

?>
                                    </select>
                                    <label><?php 
esc_html_e( "Select Page", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s12 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_access_token_info">?</a>
                                    <input id="efbl_access_token" type="text">
                                    <label for="efbl_access_token"
                                           class=""><?php 
esc_html_e( "Access Token (Optional)", 'easy-facebook-likebox' );
?></label>
                                </div>


								<?php 
?>

                                    <div class="input-field col s12 efbl_fields">
                                        <a href="javascript:void(0)"
                                           class="efbl_open_collapisble"
                                           data-id="efbl_other_pages_info">?</a>
                                        <input id="ef_other_spage_free"
                                               type="text" min="1">
                                        <label for="ef_other_spage_free"
                                               class=""><?php 
esc_html_e( "Any other page ID", 'easy-facebook-likebox' );
?></label>
                                    </div>

                                    <div class="col s12 efbl_fields">
                                        <a href="javascript:void(0)"
                                           class="efbl_open_collapisble"
                                           data-id="efbl_filter_posts_info">?</a>
                                        <select id="efbl_free_filter_popup"
                                                class="icons efbl_filter">
                                            <option value=""><?php 
esc_html_e( "None", 'easy-facebook-likebox' );
?></option>
                                            <option value=""><?php 
esc_html_e( "Mentioned", 'easy-facebook-likebox' );
?></option>
                                            <option value=""><?php 
esc_html_e( "Events", 'easy-facebook-likebox' );
?></option>
                                            <option value=""><?php 
esc_html_e( "Albums", 'easy-facebook-likebox' );
?></option>
                                            <option value=""><?php 
esc_html_e( "Videos", 'easy-facebook-likebox' );
?></option>
                                            <option value=""><?php 
esc_html_e( "Images", 'easy-facebook-likebox' );
?></option>
                                        </select>
                                        <label><?php 
esc_html_e( "Filter Posts", 'easy-facebook-likebox' );
?></label>
                                    </div>

								<?php 
?>


								<?php 
?>

                                <div class="input-field col s12 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_skin_id_info">?</a>
                                    <select id="efbl_skin_id"
                                            class="icons efbl_skin_id">
										<?php 
if ( isset( $efbl_skins ) ) {
    foreach ( $efbl_skins as $efbl_skin ) {
        $layout_selected = ucfirst( $efbl_skin['layout'] );
        ?>

                                                <option value="<?php 
        echo  $efbl_skin['ID'] ;
        ?>" data-icon="<?php 
        echo  get_the_post_thumbnail_url( $efbl_skin['ID'], 'thumbnail' ) ;
        ?>"><?php 
        echo  $efbl_skin['title'] ;
        ?> | Layout: <?php 
        echo  $layout_selected ;
        ?></span>
                                                </option>

											<?php 
    }
}

if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {
    ?>

                                            <option value="free-grid"><?php 
    esc_html_e( "Grid Skin | Layout: Grid", 'easy-facebook-likebox' );
    ?></option>
                                            <option value="free-masonry"><?php 
    esc_html_e( "Grid Masonry | Layout: Masonry", 'easy-facebook-likebox' );
    ?></option>
                                            <option value="free-carousel"><?php 
    esc_html_e( "Grid Carousel | Layout: Carousel", 'easy-facebook-likebox' );
    ?></option>

										<?php 
}

?>

                                    </select>
                                    <label><?php 
esc_html_e( "Select skin and layout", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields"
                                     style="padding-right: 10px;">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_post_limit_info">?</a>
                                    <input id="efbl_post_limit" value="10"
                                           type="number" min="1">
                                    <label for="efbl_post_limit"
                                           class=""><?php 
esc_html_e( "Number of posts to display", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_caption_words_info">?</a>
                                    <input id="efbl_caption_words" value="25"
                                           type="number" min="1">
                                    <label for="efbl_caption_words"
                                           class=""><?php 
esc_html_e( "Number of words in caption/content", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields"
                                     style="margin-top: 22px; padding-right: 10px;">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_cache_unit_info">?</a>
                                    <input id="efbl_cache_unit" value="1"
                                           type="number" min="1">
                                    <label for="efbl_cache_unit"
                                           class=""><?php 
esc_html_e( "Cache Unit", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_cache_duration_info">?</a>
                                    <select id="efbl_cache_duration"
                                            class="efbl_cache_duration">
                                        <option value="minutes"><?php 
esc_html_e( "Minutes", 'easy-facebook-likebox' );
?></option>
                                        <option value="hours"><?php 
esc_html_e( "Hours", 'easy-facebook-likebox' );
?></option>
                                        <option selected
                                                value="days"><?php 
esc_html_e( "Days", 'easy-facebook-likebox' );
?></option>
                                    </select>
                                    <label><?php 
esc_html_e( "Cache Duration", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="col s6 efbl_fields"
                                     style="padding-right: 10px;">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_show_likebox_info">?</a>
                                    <input name="efbl_show_likebox"
                                           type="checkbox" class="filled-in"
                                           value="" id="efbl_show_likebox"/>
                                    <label for="efbl_show_likebox"><?php 
esc_html_e( "Show Likebox", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_collapisble"
                                       data-id="efbl_link_new_tab_info">?</a>
                                    <input name="efbl_link_new_tab"
                                           type="checkbox" class="filled-in"
                                           value="" id="efbl_link_new_tab"/>
                                    <label for="efbl_link_new_tab"><?php 
esc_html_e( "Open links in new tab", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <input type="submit"
                                       class="btn  efbl_shortcode_submit"
                                       value="<?php 
esc_html_e( "Generate", 'easy-facebook-likebox' );
?>"/>
                            </form>

                            <div class="efbl_generated_shortcode">
                                <p><?php 
esc_html_e( "Paste in the page/post content or in text widget", 'easy-facebook-likebox' );
?></p>
                                <blockquote
                                        class="efbl-shortcode-block"></blockquote>
                                <a class="btn waves-effect efbl_copy_shortcode efbl_shortcode_generated_final waves-light tooltipped"
                                   data-position="bottom" data-delay="50"
                                   data-tooltip="<?php 
esc_html_e( "Copy", 'easy-facebook-likebox' );
?>"
                                   href="javascript:void(0);"><i
                                            class="material-icons center">content_copy</i>
                                </a>
                            </div>

                        </div>

                        <div class="efbl_collapsible_info col s12">
                            <h5><?php 
esc_html_e( "How to use Widget?", 'easy-facebook-likebox' );
?></h5>
                            <ol>
                                <li><?php 
esc_html_e( "Go to Appearance > Widgets.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Look for Easy Facebook Feed widget in available widgets section.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Drag and drop the widget to any of your active sidebar.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Change default values with your requirements like fanpage ID of your page and post layout etc.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Click the save button and visit your site to see feeds in widget", 'easy-facebook-likebox' );
?></li>
                            </ol>
                            <a class="waves-effect waves-light btn"
                               href="<?php 
echo  esc_url( admin_url( "widgets.php" ) ) ;
?>"><?php 
esc_html_e( "Widgets", 'easy-facebook-likebox' );
?>
                                <i class="material-icons right">link</i></a>
                        </div>


                    </div>

                    <h5><?php 
esc_html_e( "Unable to understand shortocde parameters?", 'easy-facebook-likebox' );
?></h5>
                    <p><?php 
esc_html_e( "No worries, Each shortocde parameter is explained below first read them and generate your shortocde.", 'easy-facebook-likebox' );
?></p>
                    <ul class="collapsible efbl_shortcode_accord"
                        data-collapsible="accordion">
                        <li id="efbl_page_info">
                            <div class="collapsible-header">
                                <i class="material-icons">pages</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Pages", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "List of pages you approved for plugin to get the feeds. Select the page you want to display feeds.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_access_token_info">
                            <div class="collapsible-header">
                                <i class="material-icons">code</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Access Token (Optional)", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Access Token provided from Facebook to display your page feeds. If you have your own Facebook app and retrieved access token you can use that to display your feed but this is optional if you don't have your app the default access token will be used. Please note: Your Access token is required to show your page events you can follow the steps explained ", 'easy-facebook-likebox' );
?>
                                    <a target='_blank'
                                       href="<?php 
echo  esc_url( 'https://easysocialfeed.com/custom-facebook-feed/page-token/' ) ;
?>"><?php 
esc_html_e( "here", 'easy-facebook-likebox' );
?></a>. <?php 
esc_html_e( "This step is only required for events filter", 'easy-facebook-likebox' );
?>
                                </p>
                            </div>
                        </li>

                        <li id="efbl_other_pages_info">
                            <div class="collapsible-header">
                                <i class="material-icons">filter_list</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Other Pages", 'easy-facebook-likebox' );
?>
                                    <a href="<?php 
echo  esc_url( efl_fs()->get_upgrade_url() ) ;
?>">(<?php 
esc_html_e( "pro", 'easy-facebook-likebox' );
?>)</a>
                                </span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "You can display any other public page feed which you don't owns/manage. eg:gopro", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>


                        <li id="efbl_filter_posts_info">
                            <div class="collapsible-header">
                                <i class="material-icons">filter_list</i>

                                <span class="mif_detail_head"><?php 
esc_html_e( "Filter posts", 'easy-facebook-likebox' );
?>
                                    <a href="<?php 
echo  esc_url( efl_fs()->get_upgrade_url() ) ;
?>">(<?php 
esc_html_e( "pro", 'easy-facebook-likebox' );
?>)</a>
                                </span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "You can filter page feed by mentioned, events, albums, videos and images. Select any of them to display only specific type of posts like page mentioned only posts, pages events only, page albums only, page videos only and page images only.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_filter_events_info">
                            <div class="collapsible-header">
                                <i class="material-icons">filter_list</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Events Filter", 'easy-facebook-likebox' );
?><a
                                            href="<?php 
echo  esc_url( efl_fs()->get_upgrade_url() ) ;
?>">(<?php 
esc_html_e( "pro", 'easy-facebook-likebox' );
?>)</a></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Filter events to display past, upcoming or all events. Default value is Upcoming", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_skin_id_info">
                            <div class="collapsible-header">
                                <i class="material-icons">web</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Skin", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Skins let's you totally customize the look and feel of your feed in real time. Skin holds all the design settings like feed layout, page header and single post colors, margins and alot of cool settings seprately. You can create new skin from Facebook Likebox - ESPF > Facebook > Skins tab.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_post_limit_info">
                            <div class="collapsible-header">
                                <i class="material-icons">view_compact</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Number of posts", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "You can set number of posts to display on your website page. Like if you set 10 only first 10 posts from your page will retrieve.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_caption_words_info">
                            <div class="collapsible-header">
                                <i class="material-icons">plus_one</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Number of words in caption/content", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "You can set number of words in post description. Like if you set 20 only 20 words from feed description will display.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_cache_unit_info">
                            <div class="collapsible-header">
                                <i class="material-icons">cached</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Cache unit", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Feeds Will be automatically refreshed after selected time interval. In this setting, the possible values are any number. Recommended value is 5", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_cache_duration_info">
                            <div class="collapsible-header">
                                <i class="material-icons">access_time</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Cache duration", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Define cache duration to refresh feeds automatically. Like after specified minutes/hours/days feeds would be refreshed. Recommended value is days", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_show_likebox_info">
                            <div class="collapsible-header">
                                <i class="material-icons">video_label</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Show likebox", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "It will let you show the page like box or the page plugin at the end of feeds.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_link_new_tab_info">
                            <div class="collapsible-header">
                                <i class="material-icons">open_in_new</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Links in new tab", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked all links in feeds will be opened in a new browser tab instead of current tab.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                    </ul>
                </div>
                <div id="efbl-likebox-use"
                     class="tab-content efbl_tab_c_holder">


                    <div class="row">

                        <div class="efbl_collapsible_info col s12">

                            <div class="efbl_default_shortcode_holder col s8">
                                <h5><?php 
esc_html_e( "How to use this plugin?", 'easy-facebook-likebox' );
?></h5>
                                <p><?php 
esc_html_e( "Copy and paste the following shortcode in any page, post or text widget to display the likebox/page plugin.", 'easy-facebook-likebox' );
?></p>

                                <div class="efbl-shortcode-holder">
                                    <blockquote class="efbl-shortcode-block">
                                        [efb_likebox
                                        fanpage_url=<?php 
echo  $default_page_id ;
?>
                                        responsive=1]
                                    </blockquote>
                                    <a class="btn waves-effect efbl_copy_shortcode waves-light tooltipped"
                                       data-position="right" data-delay="50"
                                       data-tooltip="<?php 
esc_html_e( "Copy", 'easy-facebook-likebox' );
?>"
                                       data-clipboard-text="[efb_likebox fanpage_url=<?php 
echo  $default_page_id ;
?> responsive=1]"
                                       href="javascript:void(0);"><i
                                                class="material-icons right">content_copy</i>
                                    </a>
                                </div>
								<?php 
echo  $efbl_default_likebox_notice ;
?>
                                <h5 class="efbl_more_head"><?php 
esc_html_e( "Need More Options?", 'easy-facebook-likebox' );
?></h5>
                                <p><?php 
esc_html_e( "Use the following shortcode generator to further customize the shortcode.", 'easy-facebook-likebox' );
?></p>
                            </div>

                            <div class="efbl_shortocode_genrator_main col s4">
                                <h5><?php 
esc_html_e( "How to use shortcode?", 'easy-facebook-likebox' );
?></h5>
                                <ol>
                                    <li><?php 
esc_html_e( "Generate the shortcode using the shortcode generator below.", 'easy-facebook-likebox' );
?></li>
                                    <li><?php 
esc_html_e( "Copy the shortcode in the left column or generate shortcode if you need more options.", 'easy-facebook-likebox' );
?></li>
                                    <li><?php 
esc_html_e( "Paste in the page/post content or in text widget", 'easy-facebook-likebox' );
?></li>
                                </ol>
                            </div>

                            <form class="efbl_like_box_shortocode_genrator"
                                  name="efbl_like_box_shortocode_genrator"
                                  type="post">
                                <h5><?php 
esc_html_e( "Shortcode Generator", 'easy-facebook-likebox' );
?></h5>
                                <div class="input-field col s12 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_url_info">?</a>
                                    <input id="efbl_like_box_url" type="text">
                                    <label for="efbl_like_box_url"
                                           class=""><?php 
esc_html_e( "Your page full URL", 'easy-facebook-likebox' );
?></label>
                                </div>

								<?php 
?>

                                    <div class="col s12 efbl_fields">
                                        <a href="javascript:void(0)"
                                           class="efbl_open_likebox_collapisble"
                                           data-id="efbl_tabs_info">?</a>
                                        <input name="" class="modal-trigger"
                                               href="#efbl-tabs-upgrade"
                                               type="checkbox" required
                                               value="efbl_free_tabs"
                                               id="efbl_free_tabs"/>
                                        <label for="efbl_free_tabs"><?php 
esc_html_e( "Tabs", 'easy-facebook-likebox' );
?></label>
                                    </div>

								<?php 
?>

                                <div class="input-field col s6 efbl_fields"
                                     style="padding-right: 10px;">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_appid_info">?</a>
                                    <input id="efbl_like_box_app_id"
                                           type="number" min="1">
                                    <label for="efbl_like_box_app_id"
                                           class=""><?php 
esc_html_e( "Facebook App ID(optional)", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_width_info">?</a>
                                    <input id="efbl_like_box_width"
                                           type="number" min="1">
                                    <label for="efbl_like_box_width"
                                           class=""><?php 
esc_html_e( "Box width", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields"
                                     style="margin-top: 22px; padding-right: 10px;">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_height_info">?</a>
                                    <input id="efbl_like_box_height"
                                           type="number" min="1">
                                    <label for="efbl_like_box_height"
                                           class=""><?php 
esc_html_e( "Box height", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="input-field col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_locale_info">?</a>
                                    <select id="efbl_like_box_locale"
                                            class="efbl_like_box_locale">

										<?php 
$efbl_get_locales = efbl_get_locales();
if ( $efbl_get_locales ) {
    foreach ( $efbl_get_locales as $key => $efbl_get_local ) {
        ?>
                                                <option value="<?php 
        echo  $key ;
        ?>"><?php 
        echo  $efbl_get_local[1] ;
        ?></option>
											<?php 
    }
}
?>


                                    </select>
                                    <label><?php 
esc_html_e( "Select language", 'easy-facebook-likebox' );
?></label>
                                </div>


                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_responsive_info">?</a>
                                    <input name="efbl_like_box_responsive"
                                           type="checkbox" class="filled-in"
                                           value=""
                                           id="efbl_like_box_responsive"/>
                                    <label for="efbl_like_box_responsive"><?php 
esc_html_e( "Responsive", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_faces_info">?</a>
                                    <input name="efbl_like_box_faces"
                                           type="checkbox" class="filled-in"
                                           value="" id="efbl_like_box_faces"/>
                                    <label for="efbl_like_box_faces"><?php 
esc_html_e( "Show faces", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_stream_info">?</a>
                                    <input name="efbl_like_box_stream"
                                           type="checkbox" class="filled-in"
                                           value="" id="efbl_like_box_stream"/>
                                    <label for="efbl_like_box_stream"><?php 
esc_html_e( "Show posts stream", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_cover_info">?</a>
                                    <input name="efbl_like_box_cover"
                                           type="checkbox" class="filled-in"
                                           value="" id="efbl_like_box_cover"/>
                                    <label for="efbl_like_box_cover"><?php 
esc_html_e( "Hide cover", 'easy-facebook-likebox' );
?></label>
                                </div>


                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       style="right: 10px;"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_sh_info">?</a>
                                    <input name="efbl_like_box_small_header"
                                           type="checkbox" class="filled-in"
                                           value=""
                                           id="efbl_like_box_small_header"/>
                                    <label for="efbl_like_box_small_header"><?php 
esc_html_e( "Small header", 'easy-facebook-likebox' );
?></label>
                                </div>


                                <div class="col s6 efbl_fields">
                                    <a href="javascript:void(0)"
                                       class="efbl_open_likebox_collapisble"
                                       data-id="efbl_like_box_cta_info">?</a>
                                    <input name="efbl_like_box_hide_cta"
                                           type="checkbox" class="filled-in"
                                           value=""
                                           id="efbl_like_box_hide_cta"/>
                                    <label for="efbl_like_box_hide_cta"><?php 
esc_html_e( "Hide call to action button", 'easy-facebook-likebox' );
?></label>
                                </div>

                                <input type="submit"
                                       class="btn efbl_likebox_shortcode_submit"
                                       value="<?php 
esc_html_e( "Generate", 'easy-facebook-likebox' );
?>"/>
                            </form>

                            <div class="efbl_likebox_generated_shortcode">
                                <p><?php 
esc_html_e( "Paste in the page/post content or in text widget", 'easy-facebook-likebox' );
?></p>
                                <blockquote
                                        class="efbl-likebox-shortcode-block"></blockquote>
                                <a class="btn waves-effect efbl_likebox_copy_shortcode efbl_likebox_shortcode_generated_final waves-light tooltipped"
                                   data-position="right" data-delay="50"
                                   data-tooltip="<?php 
esc_html_e( "Copy", 'easy-facebook-likebox' );
?>"
                                   href="javascript:void(0);"><i
                                            class="material-icons center">content_copy</i>
                                </a>
                            </div>

                        </div>

                        <div class="efbl_collapsible_info col s12">
                            <h5><?php 
esc_html_e( "How to use Widget?", 'easy-facebook-likebox' );
?></h5>
                            <ol>
                                <li><?php 
esc_html_e( "Go to Appearance > Widgets.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Look for Easy Facebook Likebox widget in available widgets section.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Drag and drop the widget to any of your active sidebar.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Change default values with your requirements like fanpage url and animation etc.", 'easy-facebook-likebox' );
?></li>
                                <li><?php 
esc_html_e( "Click the save button and visit your site to see likebox in widget", 'easy-facebook-likebox' );
?></li>
                            </ol>
                            <a class="waves-effect waves-light btn"
                               href="<?php 
echo  esc_url( admin_url( "widgets.php" ) ) ;
?>"><?php 
esc_html_e( "Widgets", 'easy-facebook-likebox' );
?>
                                <i class="material-icons right">link</i></a>
                        </div>


                    </div>

                    <h5><?php 
esc_html_e( "Unable to understand shortocde parameters?", 'easy-facebook-likebox' );
?></h5>
                    <p><?php 
esc_html_e( "No worries, Each shortocde parameter is explained below first read them and generate your shortocde.", 'easy-facebook-likebox' );
?></p>
                    <ul class="collapsible efbl_shortcode_accord efbl_likebox_shortcode_accord"
                        data-collapsible="accordion">
                        <li id="efbl_like_box_url_info">
                            <div class="collapsible-header">
                                <i class="material-icons">insert_link</i>
                                <span class="mif_detail_head"> <?php 
esc_html_e( "Page URL", 'easy-facebook-likebox' );
?> </span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Your Facebook fanpage URL. You can find your page URL from browser address bar when page is opened. Like https://facebook.com/easysocialfeed", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_tabs_info">
                            <div class="collapsible-header">
                                <i class="material-icons">filter_list</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Tabs", 'easy-facebook-likebox' );
?> <a
                                            href="<?php 
echo  esc_url( efl_fs()->get_upgrade_url() ) ;
?>">(<?php 
esc_html_e( "pro", 'easy-facebook-likebox' );
?>)</a></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "You can now have timeline, events and messages tabs in the likebox. Simply filter the feeds from stream", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_appid_info">
                            <div class="collapsible-header">
                                <i class="material-icons">apps</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Facebook APP ID", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "To get any type of data from Facebook server it requires Facebook developer app which is responsible of all Facebook calls. Don't worry we have approved apps from Facebook which will be usind if you don't have app registred. You can register your app from Facebook developer account and add ID here.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_width_info">
                            <div class="collapsible-header">
                                <i class="material-icons">check_box_outline_blank</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Box Width", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Enter Likebox width in pixels. Likebox will be generated according to defined width.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_height_info">
                            <div class="collapsible-header">
                                <i class="material-icons">check_box_outline_blank</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Box Height", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Enter Likebox height in pixels. Likebox will be generated according to defined height.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_locale_info">
                            <div class="collapsible-header">
                                <i class="material-icons">language</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Select Language", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "Select the language in which you want to display your feeds.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_responsive_info">
                            <div class="collapsible-header">
                                <i class="material-icons">laptop_mac</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Responsive", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked box will automatically adjust on mobile and tablet devices", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_faces_info">
                            <div class="collapsible-header">
                                <i class="material-icons">tag_faces</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Show Faces", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked show profile photos of friends who already liked the page.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_stream_info">
                            <div class="collapsible-header">
                                <i class="material-icons">filter_list</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Show posts stream", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked it will show posts of the page after likebox.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_cover_info">
                            <div class="collapsible-header">
                                <i class="material-icons">broken_image</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Hide cover", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked it will not show your Facebook page cover in likebox.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_sh_info">
                            <div class="collapsible-header">
                                <i class="material-icons">layers</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Small Header", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked it will show small header. Cover picture size will be minimized.", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                        <li id="efbl_like_box_cta_info">
                            <div class="collapsible-header">
                                <i class="material-icons">do_not_disturb</i>
                                <span class="mif_detail_head"><?php 
esc_html_e( "Hide call to action button", 'easy-facebook-likebox' );
?></span>
                            </div>
                            <div class="collapsible-body">
                                <p><?php 
esc_html_e( "If checked it will not display call to action button like Contact Us", 'easy-facebook-likebox' );
?></p>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>