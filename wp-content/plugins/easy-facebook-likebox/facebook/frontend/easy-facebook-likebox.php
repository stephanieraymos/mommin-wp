<?php

/**
 * Plugin Name.
 *
 * @package   EasyFacebookLikeBox
 * @author    Danish Ali Malik
 * @license   GPL-2.0+
 * @link      https://easysocialfeed.com
 * @copyright 2019 MaltaThemes
 */
/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 *
 * @package EasyFacebookLikeBox
 * @author  Danish Ali Malik
 */
// Include and instantiate the class.
require_once 'includes/Mobile_Detect.php';
$mDetect = new EFBL_Mobile_Detect();
class Easy_Facebook_Likebox
{
    /**
     * Plugin version, used for cache-busting of style and script file
     * references.
     *
     * @since   1.1.0
     *
     * @var     string
     */
    const  VERSION = '6.0.2' ;
    /**
     *
     * Unique identifier for your plugin.
     *
     *
     * The variable name is used as the text domain when internationalizing
     *     strings of text. Its value should match the Text Domain file header
     *     in the main plugin file.
     *
     * @since    1.1.0
     *
     * @var      string
     */
    protected  $plugin_slug = 'easy-facebook-likebox' ;
    /**
     * Instance of this class.
     *
     * @since    1.1.0
     *
     * @var      object
     */
    protected static  $instance = null ;
    /**
     * Instance of the like box render funcion
     *
     * @since    1.1.0
     *
     * @var      object
     */
    public  $likebox_instance = 1 ;
    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     1.1.0
     */
    public function __construct()
    {
        // Load plugin text domain
        add_action( 'wp_footer', [ $this, 'efbl_display_popup' ], 50 );
        // Activate plugin when new blog is added
        add_action( 'wpmu_new_blog', [ $this, 'activate_new_site' ] );
        // Load public-facing style sheet and JavaScript.
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_shortcode( 'efb_likebox', [ $this, 'efb_likebox_shortcode' ] );
        add_shortcode( 'efb_pageplugin', [ $this, 'efb_pageplugin_shortcode' ] );
        add_shortcode( 'efb_feed', [ $this, 'efb_feed_shortcode' ] );
        add_action( 'wp_ajax_efbl_generate_popup_html', [ $this, 'efbl_generate_popup_html' ] );
        add_action( 'wp_ajax_nopriv_efbl_generate_popup_html', [ $this, 'efbl_generate_popup_html' ] );
        add_action( 'wp_ajax_easy-facebook-likebox-customizer-style', [ $this, 'efbl_load_customizer_css' ] );
        add_action( 'wp_ajax_nopriv_easy-facebook-likebox-customizer-style', [ $this, 'efbl_load_customizer_css' ] );
    }
    
    /**
     * Fired when the plugin is activated.
     *
     * @param boolean $network_wide True if WPMU superadmin uses
     *                                       "Network Activate" action, false if
     *                                       WPMU is disabled or plugin is
     *                                       activated on an individual blog.
     *
     * @since    1.1.0
     *
     */
    public static function activate( $network_wide )
    {
        
        if ( function_exists( 'is_multisite' ) && is_multisite() ) {
            
            if ( $network_wide ) {
                // Get all blog ids
                $blog_ids = self::get_blog_ids();
                foreach ( $blog_ids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    self::single_activate();
                }
                restore_current_blog();
            } else {
                self::single_activate();
            }
        
        } else {
            self::single_activate();
        }
    
    }
    
    /**
     * Fired when the plugin is deactivated.
     *
     * @param boolean $network_wide True if WPMU superadmin uses
     *                                       "Network Deactivate" action, false
     *     if WPMU is disabled or plugin is deactivated on an individual blog.
     *
     * @since    1.1.0
     *
     */
    public static function deactivate( $network_wide )
    {
        
        if ( function_exists( 'is_multisite' ) && is_multisite() ) {
            
            if ( $network_wide ) {
                // Get all blog ids
                $blog_ids = self::get_blog_ids();
                foreach ( $blog_ids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    self::single_deactivate();
                }
                restore_current_blog();
            } else {
                self::single_deactivate();
            }
        
        } else {
            self::single_deactivate();
        }
    
    }
    
    /**
     * Fired when a new site is activated with a WPMU environment.
     *
     * @param int $blog_id ID of the new blog.
     *
     * @since    1.1.0
     *
     */
    public function activate_new_site( $blog_id )
    {
        if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
            return;
        }
        switch_to_blog( $blog_id );
        self::single_activate();
        restore_current_blog();
    }
    
    /**
     * Get all blog ids of blogs in the current network that are:
     * - not archived
     * - not spam
     * - not deleted
     *
     * @return   array|false    The blog ids, false if no matches.
     * @since    1.1.0
     *
     */
    private static function get_blog_ids()
    {
        global  $wpdb ;
        // get an array of blog ids
        $sql = "SELECT blog_id FROM {$wpdb->blogs}\n\t\t\tWHERE archived = '0' AND spam = '0'\n\t\t\tAND deleted = '0'";
        return $wpdb->get_col( $sql );
    }
    
    /**
     * Fired for each blog when the plugin is activated.
     *
     * @since    1.1.0
     */
    private static function single_activate()
    {
        // @TODO: Define activation functionality here
        $install_date = get_option( 'efbl_installDate', false );
        /*
         * Save the plugin current version.
         */
        update_option( 'efbl_version', VERSION );
        /*
         * Save the plugin install time and date.
         */
        $install_date = add_option( 'efbl_installDate', date( 'Y-m-d h:i:s' ) );
        /*
         * Save the plugin type version.
         */
        update_option( 'efbl_version_type', 'pro' );
    }
    
    /**
     * Fired for each blog when the plugin is deactivated.
     *
     * @since    1.1.0
     */
    private static function single_deactivate()
    {
        // @TODO: Define deactivation functionality here
    }
    
    /**
     * Register and enqueue public-facing style sheet.
     *
     * @since    1.1.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style( $this->plugin_slug . '-custom-fonts', FTA_PLUGIN_URL . 'frontend/assets/css/esf-custom-fonts.css', [] );
        if ( efl_fs()->is_free_plan() ) {
            wp_enqueue_style(
                $this->plugin_slug . '-popup-styles',
                plugins_url( 'assets/css/magnific-popup.css', __FILE__ ),
                [],
                self::VERSION
            );
        }
        wp_enqueue_style(
            $this->plugin_slug . '-frontend',
            plugins_url( 'assets/css/easy-facebook-likebox-frontend.css', __FILE__ ),
            [],
            self::VERSION
        );
        wp_enqueue_style(
            $this->plugin_slug . '-customizer-style',
            admin_url( 'admin-ajax.php' ) . '?action=' . $this->plugin_slug . '-customizer-style',
            $this->plugin_slug . '-frontend',
            self::VERSION
        );
    }
    
    /**
     * Register and enqueues public-facing JavaScript files.
     *
     * @since    1.1.0
     */
    public function enqueue_scripts()
    {
        
        if ( efl_fs()->is_free_plan() ) {
            wp_enqueue_script(
                $this->plugin_slug . '-popup-script',
                plugins_url( 'assets/js/jquery.magnific-popup.min.js', __FILE__ ),
                [ 'jquery' ],
                self::VERSION
            );
            wp_enqueue_script(
                $this->plugin_slug . '-cookie-script',
                plugins_url( 'assets/js/jquery.cookie.js', __FILE__ ),
                [ 'jquery' ],
                self::VERSION
            );
        }
        
        wp_enqueue_script(
            $this->plugin_slug . '-public-script',
            plugins_url( 'assets/js/public.js', __FILE__ ),
            [ 'jquery', $this->plugin_slug . '-popup-script', $this->plugin_slug . '-cookie-script' ],
            self::VERSION
        );
        $efbl_is_fb_pro = false;
        if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            $efbl_is_fb_pro = true;
        }
        wp_localize_script( $this->plugin_slug . '-public-script', 'public_ajax', [
            'ajax_url'       => admin_url( 'admin-ajax.php' ),
            'efbl_is_fb_pro' => $efbl_is_fb_pro,
        ] );
        // plan end
    }
    
    /*
     * Include customizer style file
     */
    public function efbl_load_customizer_css()
    {
        header( "Content-type: text/css; charset: UTF-8" );
        require EFBL_PLUGIN_DIR . 'frontend/assets/css/easy-facebook-likebox-customizer-style.css.php';
        exit;
    }
    
    public function efb_likebox_shortcode( $atts, $content = "" )
    {
        return $this->render_fb_page_plugin( $atts );
    }
    
    public function efb_pageplugin_shortcode( $atts, $content = "" )
    {
        return $this->render_fb_page_plugin( $atts );
    }
    
    public function efb_feed_shortcode( $atts, $content = "" )
    {
        return $this->render_fbfeed_box( $atts );
    }
    
    public function render_fbfeed_box( $atts )
    {
        $defaults = '';
        $instance = wp_parse_args( (array) $atts, $defaults );
        ob_start();
        include 'views/feed.php';
        $returner = ob_get_contents();
        ob_end_clean();
        return $returner;
    }
    
    /**
     *          This fucntion will render the facebook page plugin
     *
     *
     * @since    4.0
     */
    public function render_fb_page_plugin( $options )
    {
        $efbl_tabs = null;
        extract( $options, EXTR_SKIP );
        if ( !isset( $tabs ) ) {
            $tabs = '';
        }
        if ( empty($fb_appid) ) {
            $fb_appid = '395202813876688';
        }
        if ( empty($locale) ) {
            $locale = 'en_US';
        }
        if ( !empty($locale_other) ) {
            $locale = $locale_other;
        }
        $page_name_id = efbl_parse_url( $fanpage_url );
        if ( !isset( $show_stream ) ) {
            $show_stream = 0;
        }
        if ( !isset( $show_faces ) ) {
            $show_faces = 0;
        }
        if ( !isset( $hide_cover ) ) {
            $hide_cover = 0;
        }
        if ( !isset( $responsive ) ) {
            $responsive = 0;
        }
        if ( !isset( $hide_cta ) ) {
            $hide_cta = 0;
        }
        if ( !isset( $small_header ) ) {
            $small_header = 0;
        }
        $show_stream = ( $show_stream == 1 ? 'data-show-posts=true' : 'data-show-posts=false' );
        $show_faces = ( $show_faces == 1 ? 'data-show-facepile=true' : 'data-show-facepile=false' );
        $hide_cover = ( $hide_cover == 1 ? 'data-hide-cover="true"' : 'data-hide-cover=false' );
        $responsive = ( $responsive == 1 ? 'data-adapt-container-width=true' : 'data-adapt-container-width=false' );
        $hide_cta = ( $hide_cta == 1 ? 'data-hide-cta=true' : 'data-hide-cta=false' );
        $small_header = ( $small_header == 1 ? 'data-small-header="true"' : 'data-small-header="false"' );
        $efbl_tabs = null;
        if ( !isset( $animate_effect ) ) {
            $animate_effect = "fadeIn";
        }
        if ( !isset( $box_height ) ) {
            $box_height = '';
        }
        if ( !isset( $box_width ) ) {
            $box_width = '';
        }
        $preLoader = plugins_url( 'assets/images/loader.gif', __FILE__ );
        $returner = '<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.async=true; 
					  js.src = "//connect.facebook.net/' . $locale . '/all.js#xfbml=1&appId=' . $fb_appid . '";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, \'script\', \'facebook-jssdk\'));</script>';
        $likebox_instance = $this->likebox_instance;
        $returner .= ' <div class="efbl-like-box ' . $likebox_instance . '">
							<div class="fb-page" data-animclass="';
        if ( $animate_effect ) {
            $returner .= '' . $animate_effect . '';
        }
        $returner .= '" data-href="https://www.facebook.com/' . $page_name_id . '" ' . $hide_cover . ' data-width="' . $box_width . '"  ' . $efbl_tabs . ' data-height="' . $box_height . '" ' . $show_faces . '  ' . $show_stream . ' ' . $responsive . ' ' . $hide_cta . ' ' . $small_header . '>
							</div> 
							
						</div>
					';
        return $returner;
        $this->likebox_instance++;
    }
    
    function efbl_generate_popup_html()
    {
        $rand_id = $_GET['rand_id'];
        $returner = null;
        $returner = '<div id="efblcf_holder" class="white-popup efbl-feed-popup-holder" data-rand_id="' . $rand_id . '">
	
			<div class="efbl_popup_wraper">
			
				<div class="efbl_popup_left_container">	
				  <img src="" class="efbl_popup_image" />
				  <iframe src="" class="efbl_popup_if_video" ></iframe>
				  <video src="" class="efbl_popup_video" id="html_video" controls></video>
				  <div class="efbl-popup-nav">
				  	<a class="efbl-popup-prev"><i class="icon icon-esf-angle-left" aria-hidden="true"></i></a>
					<a class="efbl-popup-next"><i class="icon icon-esf-angle-right" aria-hidden="true"></i></a>	
				  </div>
				</div>
				
				 <div class="efbl_popupp_footer">
				 </div>
				  <div class="efbl_popup_footer_logo" style="margin: 10px auto !important;border-radius: 10px !important;background-color: rgba(0, 0, 0, 0.35) !important;width: 210px !important;padding: 5px  8px !important;cursor: pointer !important;opacity: .6;-webkit-transition: all ease-in-out .5s;-moz-transition: all ease-in-out .5s;-o-transition: all ease-in-out .5s;transition: all ease-in-out .5s;text-align: center;position: absolute !important;display: block !important;visibility: visible !important;z-index: 99 !important;left: 50%;transform: translate(-50%, 0); -webkit-transform: translate(-50%, 0); -moz-transform: translate(-50%, 0); -o-transform: translate(-50%, 0);">
                    <div data-class="efbl_redirect_home" style="display: block !important;visibility: visible !important;z-index: 99 !important;opacity: 1 !important;"><img style="float: left;width: 25px !important;height: auto !important;margin: 0 auto !important;display: block !important;visibility: visible !important;z-index: 99 !important;opacity: 1 !important;box-shadow: none !important;border-radius: 3px !important;" src="' . FTA_PLUGIN_URL . 'admin/assets/images/espf-icon.png" /><span style="font-size: 12px;color: #fff;float: left;margin-top: 4px;margin-left: 5px;display: block !important;visibility: visible !important;z-index: 99 !important;opacity: 1 !important;">Powered by Easy Social Feed</span></div>
                 </div>
				 
			</div>	 
				 
		</div>';
        echo  $returner ;
        die;
    }
    
    function efbl_display_popup()
    {
        global  $mDetect ;
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
        $options = $fta_settings['plugins']['facebook'];
        //Return if not enable
        if ( isset( $options['efbl_enable_popup'] ) ) {
            if ( $options['efbl_enable_popup'] != 1 ) {
                return;
            }
        }
        //check if to display to logged in users
        if ( isset( $options['efbl_enable_home_only'] ) ) {
            if ( $options['efbl_enable_home_only'] == 1 ) {
                //Do not show if not home page
                
                if ( is_home() || is_front_page() ) {
                    //do nothing
                } else {
                    return;
                }
            
            }
        }
        //check if to display to logged in users
        if ( isset( $options['efbl_enable_if_login'] ) ) {
            if ( $options['efbl_enable_if_login'] == 1 ) {
                //Do not show when user is not logged in
                if ( !is_user_logged_in() ) {
                    return;
                }
            }
        }
        //check if to display to not-logged in users
        if ( isset( $options['efbl_enable_if_not_login'] ) ) {
            if ( $options['efbl_enable_if_not_login'] == 1 ) {
                // echo "<pre>";
                // print_r($options);
                // exit;
                //Do not show when user is logged in
                if ( is_user_logged_in() ) {
                    return;
                }
            }
        }
        //check if to display to not-logged in users
        if ( isset( $options['efbl_do_not_show_on_mobile'] ) ) {
            if ( $options['efbl_do_not_show_on_mobile'] == 1 ) {
                // do not show on mobile
                if ( $mDetect->isMobile() && !$mDetect->isTablet() ) {
                    return;
                }
            }
        }
        include 'views/public.php';
    }
    
    /* efbl_load_more_feeds method ends here. */
    public function efbl_load_more_feeds()
    {
    }

}
$efbl = new Easy_Facebook_Likebox();