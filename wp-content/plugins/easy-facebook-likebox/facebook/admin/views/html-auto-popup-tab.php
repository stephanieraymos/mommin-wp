<?php

/**
 * Admin View: Tab - PopUp
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$ESF_Admin = new ESF_Admin();
?>
<div id="efbl-auto-popup" class="col s12 efbl_tab_c slideLeft">
    <div class="efbl-popup-dep">
        <p><?php 
esc_html_e( "Hey! I have deprecated the AutoPop feature of this plugin in favor of my own and most powerful WPOptin and PopUp free plugin.", 'easy-facebook-likebox' );
?></p>
        <a href="<?php 
echo  $ESF_Admin->esf_get_plugin_install_link( 'wpoptin' ) ;
?>"><?php 
esc_html_e( "Install now free", 'easy-facebook-likebox' );
?></a>
        <p><?php 
esc_html_e( "After installing the plugin follow the steps below to add social media like box in the PopUp:", 'easy-facebook-likebox' );
?></p>
        <ol>
            <li><?php 
esc_html_e( "Go to » WPOptin » Add new", 'easy-facebook-likebox' );
?></li>
            <li><?php 
esc_html_e( "Select", 'easy-facebook-likebox' );
?>
                <b> <?php 
esc_html_e( "Social Traffic", 'easy-facebook-likebox' );
?> </b> <?php 
esc_html_e( "from goals list", 'easy-facebook-likebox' );
?>
            </li>
            <li><?php 
esc_html_e( "Select", 'easy-facebook-likebox' );
?>
                <b> <?php 
esc_html_e( "Lightbox popup", 'easy-facebook-likebox' );
?> </b> <?php 
esc_html_e( "from types list", 'easy-facebook-likebox' );
?>
            </li>
            <li><?php 
esc_html_e( "Select", 'easy-facebook-likebox' );
?>
                <b> <?php 
esc_html_e( "Facebook Likebox", 'easy-facebook-likebox' );
?> </b> <?php 
esc_html_e( "option from URL type select field", 'easy-facebook-likebox' );
?>
            </li>
            <li><?php 
esc_html_e( "Enter your Facebook page url into the ", 'easy-facebook-likebox' );
?>
                <b> <?php 
esc_html_e( "URL to like", 'easy-facebook-likebox' );
?> </b> <?php 
esc_html_e( "field", 'easy-facebook-likebox' );
?>
            </li>
            <li><?php 
esc_html_e( "Click the save button and your likebox popup is ready you can further customize the display options and design setting from related tabs.", 'easy-facebook-likebox' );
?>
                <a class="esf-small-btn"
                   href="<?php 
echo  $ESF_Admin->esf_get_plugin_install_link( 'wpoptin' ) ;
?>"><?php 
esc_html_e( "Install now free", 'easy-facebook-likebox' );
?></a>
            </li>
        </ol>

    </div>

    <h5><?php 
esc_html_e( "Want to display PopUp on your site?", 'easy-facebook-likebox' );
?></h5>
    <p><?php 
esc_html_e( "You can display Facebook Likebox/page plugin, custom Facebook Feeds or anything, for example, age verification message or cookies alert in pop up. It also supports custom HTML code. Simply Enable the popup and paste generated shortcode or anything in pop up content field.", 'easy-facebook-likebox' );
?></p>
    <form class="efbl_popup_settings" name="efbl_popup_settings" type="post">
        <div class="row checkbox-row efbl_enable_popup">
            <input class="efbl_options"
                   data-option="efbl_enable_popup" <?php 
checked( 1, $this->options( 'efbl_enable_popup' ), true );
?>
                   type="checkbox"
                   name="efbl_settings_display_options[efbl_enable_popup]"
                   id="efbl_enable_popup"/>
            <label for="efbl_enable_popup"><?php 
esc_html_e( "Enable PopUp", 'easy-facebook-likebox' );
?></label>

        </div>
        <div class="row">
            <div class="input-field col s12">
                <input name="efbl_settings_display_options[efbl_popup_interval]"
                       class="efbl_input_options"
                       value="<?php 
echo  $this->options( 'efbl_popup_interval' ) ;
?>"
                       id="efbl_popup_interval" type="number">
                <label for="efbl_popup_interval"
                       class=""><?php 
esc_html_e( "PopUp delay after page load", 'easy-facebook-likebox' );
?></label>
                <span><?php 
esc_html_e( "Delay in miliseconds. 1000 ms = 1 second.", 'easy-facebook-likebox' );
?></span>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="efbl_settings_display_options[efbl_popup_width]"
                       class="efbl_input_options" min="0"
                       value="<?php 
echo  $this->options( 'efbl_popup_width' ) ;
?>"
                       id="efbl_popup_width" type="number">
                <label for="efbl_popup_width"
                       class=""><?php 
esc_html_e( "PopUp Width", 'easy-facebook-likebox' );
?></label>
                <span><?php 
esc_html_e( "Width in pixels.", 'easy-facebook-likebox' );
?></span>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input name="efbl_settings_display_options[efbl_popup_height]"
                       class="efbl_input_options" min="0"
                       value="<?php 
echo  $this->options( 'efbl_popup_height' ) ;
?>"
                       id="efbl_popup_height" type="number">
                <label for="efbl_popup_height"
                       class=""><?php 
esc_html_e( "Auto popup height", 'easy-facebook-likebox' );
?></label>
                <span><?php 
esc_html_e( "Height in pixels.", 'easy-facebook-likebox' );
?></span>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <textarea id="efbl_popup_shortcode" class="materialize-textarea"
                          class="efbl_input_options"
                          name="efbl_settings_display_options[efbl_popup_shortcode]"><?php 
echo  $this->options( 'efbl_popup_shortcode' ) ;
?></textarea>
                <label for="efbl_popup_shortcode"><?php 
esc_html_e( "PopUp content", 'easy-facebook-likebox' );
?></label>
                <span><?php 
esc_html_e( "You can generate easy facebook like box shortcode from Widgets > Easy Facebook LikeBox.", 'easy-facebook-likebox' );
?></span>
            </div>
        </div>
        <h5><?php 
esc_html_e( "Like box pup up advanced settings", 'easy-facebook-likebox' );
?></h5>

		<?php 
?>

            <div class="row checkbox-row">
                <input name="" class="modal-trigger" href="#efbl-pages-enable"
                       type="checkbox" required value="efbl_free_enable_pages"
                       id="efbl_free_enable_pages"/>
                <label for="efbl_free_enable_pages"><?php 
esc_html_e( "Show on specific pages", 'easy-facebook-likebox' );
?></label><br>
                <i class="efbl_popup_info"><?php 
esc_html_e( "Enable this option show popup on selected pages only. PopUp will never show on un-selected pages. If you haven't selected any page it will display on all pages.", 'easy-facebook-likebox' );
?></i>
            </div>
            <div class="row checkbox-row">
                <input name="" class="modal-trigger" href="#efbl-posts-enable"
                       type="checkbox" required value="efbl_free_enable_posts"
                       id="efbl_free_enable_posts"/>
                <label for="efbl_free_enable_posts"><?php 
esc_html_e( "Show on specific posts", 'easy-facebook-likebox' );
?></label><br>
                <i class="efbl_popup_info"><?php 
esc_html_e( "Enable this option show popup on selected posts only. PopUp will never show on un-selected posts. If you haven't selected any page it will display on all posts.", 'easy-facebook-likebox' );
?></i>
            </div>

            <div class="row checkbox-row">
                <input name="" class="modal-trigger" href="#efbl-exit-intent"
                       type="checkbox" required value="efbl_free_exit_intent"
                       id="efbl_free_exit_intent"/>
                <label for="efbl_free_exit_intent"><?php 
esc_html_e( "Show on exit intent", 'easy-facebook-likebox' );
?></label>
                <br><i class="efbl_popup_info"><?php 
esc_html_e( "Enable this option show popup on when user is about to leave the site", 'easy-facebook-likebox' );
?></i>
            </div>';

		<?php 
?>

        <div class="row checkbox-row efbl_enable_home_only">

            <input class="efbl_options"
                   data-option="efbl_enable_home_only" <?php 
checked( 1, $this->options( 'efbl_enable_home_only' ), true );
?>
                   type="checkbox"
                   name="efbl_settings_display_options[efbl_enable_home_only]"
                   id="efbl_enable_home_only"/>
            <label for="efbl_enable_home_only"><?php 
esc_html_e( "Display PopUp on home page only.", 'easy-facebook-likebox' );
?></label>
        </div>

        <div class="row checkbox-row efbl_enable_if_login">
            <input class="efbl_options"
                   data-option="efbl_enable_if_login" <?php 
checked( 1, $this->options( 'efbl_enable_if_login' ), true );
?>
                   type="checkbox"
                   name="efbl_settings_display_options[efbl_enable_if_login]"
                   id="efbl_enable_if_login"/>
            <label for="efbl_enable_if_login"><?php 
esc_html_e( "Show the PopUp if the user is logged in to your site.", 'easy-facebook-likebox' );
?></label>
        </div>

        <div class="row checkbox-row efbl_enable_if_not_login">
            <input class="efbl_options"
                   data-option="efbl_enable_if_not_login" <?php 
checked( 1, $this->options( 'efbl_enable_if_not_login' ), true );
?>
                   type="checkbox"
                   name="efbl_settings_display_options[efbl_enable_if_not_login]"
                   id="efbl_enable_if_not_login"/>
            <label for="efbl_enable_if_not_login"><?php 
esc_html_e( "Show the PopUp if the user is not logged in to your site (Above option will be ignored if checked).", 'easy-facebook-likebox' );
?></label>
        </div>

        <div class="row checkbox-row efbl_do_not_show_again">
            <input class="efbl_options"
                   data-option="efbl_do_not_show_again" <?php 
checked( 1, $this->options( 'efbl_do_not_show_again' ), true );
?>
                   type="checkbox"
                   name="efbl_settings_display_options[efbl_do_not_show_again]"
                   id="efbl_do_not_show_again"/>
            <label for="efbl_do_not_show_again"><?php 
esc_html_e( "Close button act as never show again", 'easy-facebook-likebox' );
?></label>
        </div>

        <div class="row checkbox-row efbl_do_not_show_on_mobile">
            <input class="efbl_options"
                   data-option="efbl_do_not_show_on_mobile" <?php 
checked( 1, $this->options( 'efbl_do_not_show_on_mobile' ), true );
?>
                   type="checkbox"
                   name="efbl_settings_display_options[efbl_do_not_show_on_mobile]"
                   id="efbl_do_not_show_on_mobile"/>
            <label for="efbl_do_not_show_on_mobile"><?php 
esc_html_e( "Do not display on mobile devices", 'easy-facebook-likebox' );
?></label>
        </div>
    </form>
</div>