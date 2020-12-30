<?php

/*
* Stop execution if someone tried to get file directly.
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//======================================================================
// Admin of Facebook Module
//======================================================================

if ( !class_exists( 'Easy_Facebook_Likebox_Admin' ) ) {
    class Easy_Facebook_Likebox_Admin
    {
        var  $plugin_slug = 'easy-facebook-likebox' ;
        function __construct()
        {
            add_action( 'admin_menu', [ $this, 'efbl_menu' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'efbl_admin_style' ] );
            add_action( 'wp_ajax_efbl_save_popup_settings', [ $this, 'efbl_save_popup_settings' ] );
            add_action( 'wp_ajax_efbl_create_skin', [ $this, 'efbl_create_skin' ] );
            add_action( 'wp_ajax_efbl_create_skin_url', [ $this, 'efbl_create_skin_url' ] );
            add_action( 'wp_ajax_efbl_delete_skin', [ $this, 'efbl_delete_skin' ] );
            add_action( 'wp_ajax_efbl_del_trans', [ $this, 'efbl_delete_transient' ] );
            add_action( 'wp_ajax_efbl_save_fb_access_token', [ $this, 'efbl_save_facebook_access_token' ] );
        }
        
        /*
         * efbl_admin_style will enqueue style and js files.
         * Returns hook name of the current page in admin.
         * $hook will contain the hook name.
         */
        public function efbl_admin_style( $hook )
        {
            if ( 'easy-social-feed_page_easy-facebook-likebox' !== $hook ) {
                return;
            }
            wp_enqueue_style( $this->plugin_slug . '-admin-styles', EFBL_PLUGIN_URL . 'admin/assets/css/admin.css', [] );
            wp_enqueue_script( $this->plugin_slug . '-admin-script', EFBL_PLUGIN_URL . 'admin/assets/js/admin.js', [ 'jquery', 'materialize.min' ] );
            $FTA = new Feed_Them_All();
            $fta_settings = $FTA->fta_get_settings();
            $default_skin_id = $fta_settings['plugins']['facebook']['default_skin_id'];
            $efbl_ver = 'free';
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
                $efbl_ver = 'pro';
            }
            wp_localize_script( $this->plugin_slug . '-admin-script', 'efbl', [
                'ajax_url'        => admin_url( 'admin-ajax.php' ),
                'nonce'           => wp_create_nonce( 'efbl-ajax-nonce' ),
                'version'         => $efbl_ver,
                'default_skin_id' => $default_skin_id,
            ] );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_media();
        }
        
        /*
         * Adds Facebook sub-menu in dashboard
         */
        public function efbl_menu()
        {
            add_submenu_page(
                'feed-them-all',
                __( 'Facebook', 'easy-facebook-likebox' ),
                __( 'Facebook', 'easy-facebook-likebox' ),
                'manage_options',
                'easy-facebook-likebox',
                [ $this, 'efbl_page' ],
                1
            );
        }
        
        /*
         * efbl_page contains the html/markup of the Facebook page.
         * Returns nothing.
         */
        public function efbl_page()
        {
            /**
             * Facebook page view.
             */
            include_once EFBL_PLUGIN_DIR . 'admin/views/html-admin-page-easy-facebook-likebox.php';
        }
        
        /*
         * get saved option values
         */
        private function options( $option = null )
        {
            $FTA = new Feed_Them_All();
            $fta_settings = $FTA->fta_get_settings();
            $fta_settings = wp_parse_args( $fta_settings['plugins']['facebook'], $this->efbl_default_options() );
            return $fta_settings[$option];
        }
        
        /**
         * Provides default values for the Social Options.
         */
        function efbl_default_options()
        {
            $defaults = [
                'efbl_enable_popup'          => null,
                'efbl_popup_interval'        => null,
                'efbl_popup_width'           => null,
                'efbl_popup_height'          => null,
                'efbl_popup_shortcode'       => '',
                'efbl_enable_home_only'      => null,
                'efbl_enable_if_login'       => null,
                'efbl_enable_if_not_login'   => null,
                'efbl_do_not_show_again'     => null,
                'efbl_do_not_show_on_mobile' => null,
            ];
            return apply_filters( 'efbl_default_options', $defaults );
        }
        
        /*
         * Save Poppup settings values on ajax
         */
        function efbl_save_popup_settings()
        {
            $FTA = new Feed_Them_All();
            $fta_settings = $FTA->fta_get_settings();
            $efbl_option_value = $_POST['efbl_value'];
            $efbl_option = sanitize_text_field( $_POST['efbl_option'] );
            $efbl_popup_settings = $fta_settings['plugins']['facebook'];
            $efbl_popup_settings[$efbl_option] = $_POST['efbl_value'];
            $fta_settings['plugins']['facebook'] = $efbl_popup_settings;
            if ( wp_verify_nonce( $_POST['efbl_nonce'], 'efbl-ajax-nonce' ) ) {
                if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
                    $efbl_saved = update_option( 'fta_settings', $fta_settings );
                }
            }
            
            if ( isset( $efbl_saved ) ) {
                echo  wp_send_json_success( __( 'Updated', 'easy-facebook-likebox' ) ) ;
                die;
            } else {
                echo  wp_send_json_error( __( 'Something went wrong! Refresh the page and try Again', 'easy-facebook-likebox' ) ) ;
                die;
            }
        
        }
        
        /*
         * Deletes Facebook cached data on AJax
         */
        function efbl_delete_transient()
        {
            $value = sanitize_text_field( $_POST['efbl_option'] );
            $replaced_value = str_replace( '_transient_', '', $value );
            if ( wp_verify_nonce( $_POST['efbl_nonce'], 'efbl-ajax-nonce' ) ) {
                
                if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
                    $page_id = explode( '-', $value );
                    
                    if ( isset( $page_id['1'] ) && !empty($page_id['1']) ) {
                        $page_id = $page_id['1'];
                        $page_logo_trasneint_name = "esf_logo_" . $page_id;
                        delete_transient( $page_logo_trasneint_name );
                    }
                    
                    $efbl_deleted_trans = delete_transient( $replaced_value );
                }
            
            }
            
            if ( isset( $efbl_deleted_trans ) ) {
                echo  wp_send_json_success( [ __( 'Deleted', 'easy-facebook-likebox' ), $value ] ) ;
                die;
            } else {
                echo  wp_send_json_error( __( 'Something went wrong! Refresh the page and try Again', 'easy-facebook-likebox' ) ) ;
                die;
            }
        
        }
        
        /*
         * Get the attachment ID from the file URL
         */
        function efbl_get_image_id( $image_url )
        {
            global  $wpdb ;
            $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", $image_url ) );
            return $attachment[0];
        }
        
        /*
         * efbl_create_skin on ajax.
         * Returns the customizer URL with skin ID.
         * Create the skin for Facebook feeds
         */
        function efbl_create_skin()
        {
            $FTA = new Feed_Them_All();
            $fta_settings = $FTA->fta_get_settings();
            $form_data = $_POST['form_data'];
            parse_str( $form_data );
            $efbl_new_skins = [
                'post_title'   => sanitize_text_field( $efbl_skin_title ),
                'post_content' => sanitize_text_field( $efbl_skin_description ),
                'post_type'    => 'efbl_skins',
                'post_status'  => 'publish',
                'post_author'  => get_current_user_id(),
            ];
            if ( wp_verify_nonce( $_POST['efbl_nonce'], 'efbl-ajax-nonce' ) ) {
                if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
                    $skin_id = wp_insert_post( $efbl_new_skins );
                }
            }
            
            if ( isset( $skin_id ) ) {
                update_post_meta( $skin_id, 'layout', sanitize_text_field( $efbl_selected_layout ) );
                $thumbnail_id = $FTA->fta_get_image_id( $efbl_skin_feat_img );
                set_post_thumbnail( $skin_id, $thumbnail_id );
                $page_id = $fta_settings['plugins']['facebook']['default_page_id'];
                $page_permalink = get_permalink( $page_id );
                $customizer_url = 'customize.php';
                if ( isset( $page_permalink ) ) {
                    $customizer_url = add_query_arg( [
                        'url'              => urlencode( $page_permalink ),
                        'autofocus[panel]' => 'efbl_customize_panel',
                        'efbl_skin_id'     => $skin_id,
                        'mif_customize'    => 'yes',
                        'efbl_account_id'  => $efbl_selected_account,
                    ], $customizer_url );
                }
                echo  wp_send_json_success( admin_url( $customizer_url ) ) ;
                die;
            } else {
                echo  wp_send_json_error( __( 'Something Went Wrong! Please try again.', $FTA->plug_slug ) ) ;
                die;
            }
        
        }
        
        /*
         * efbl_delete_skin on ajax.
         * Returns the Success or Error Message.
         * Delete the skin
         */
        function efbl_delete_skin()
        {
            $FTA = new Feed_Them_All();
            $skin_id = intval( $_POST['skin_id'] );
            if ( wp_verify_nonce( $_POST['efbl_nonce'], 'efbl-ajax-nonce' ) ) {
                if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
                    $skin_deleted = wp_delete_post( $skin_id, true );
                }
            }
            
            if ( isset( $skin_deleted ) ) {
                $returned_arr = [ __( 'Skin is successfully deleted.', $FTA->plug_slug ), $skin_id ];
                echo  wp_send_json_success( $returned_arr ) ;
                die;
            } else {
                echo  wp_send_json_error( __( 'Something Went Wrong! Please try again.', $FTA->plug_slug ) ) ;
                die;
            }
            
            exit;
        }
        
        /*
         * Get the access token and save back into DB
         */
        public function efbl_save_facebook_access_token()
        {
            $access_token = $_POST['access_token'];
            $fta_api_url = 'https://graph.facebook.com/me/accounts?fields=access_token,username,id,name,fan_count,category,about&access_token=' . $access_token;
            $args = [
                'timeout'   => 150,
                'sslverify' => false,
            ];
            $fta_pages = wp_remote_get( $fta_api_url, $args );
            $fb_pages = json_decode( $fta_pages['body'] );
            $approved_pages = [];
            
            if ( $fb_pages->data ) {
                $title = __( 'Approved Pages', 'easy-facebook-likebox' );
                $efbl_all_pages_html = '<ul class="collection with-header"> <li class="collection-header"><h5>' . $title . '</h5> 
	 		<a href="#fta-remove-at" class="modal-trigger fta-remove-at-btn tooltipped" data-position="left" data-delay="50" data-tooltip="' . __( 'Delete Access Token', 'easy-facebook-likebox' ) . '"><i class="material-icons">delete_forever</i></a></li>';
                foreach ( $fb_pages->data as $efbl_page ) {
                    $page_logo_trasneint_name = "esf_logo_" . $efbl_page->id;
                    $auth_img_src = get_transient( $page_logo_trasneint_name );
                    
                    if ( !$auth_img_src || '' == $auth_img_src ) {
                        $auth_img_src = 'https://graph.facebook.com/' . $efbl_page->id . '/picture?type=large&redirect=0&access_token=' . $access_token;
                        if ( $auth_img_src ) {
                            $auth_img_src = json_decode( jws_fetchUrl( $auth_img_src ) );
                        }
                        if ( $auth_img_src->data->url ) {
                            $auth_img_src = $auth_img_src->data->url;
                        }
                        set_transient( $page_logo_trasneint_name, $auth_img_src, 30 * 60 * 60 * 24 );
                    }
                    
                    
                    if ( isset( $efbl_page->username ) ) {
                        $efbl_username = $efbl_page->username;
                        $efbl_username_label = __( 'Username:', 'easy-facebook-likebox' );
                    } else {
                        $efbl_username = $efbl_page->id;
                        $efbl_username_label = __( 'ID:', 'easy-facebook-likebox' );
                    }
                    
                    $efbl_all_pages_html .= sprintf(
                        '<li class="collection-item avatar li-' . $efbl_page->id . '">
	 				<a href="https://web.facebook.com/' . $efbl_page->id . '" target="_blank">
	 				<img src="%2$s" alt="" class="circle">
	 				</a>          
	 				<span class="title">%1$s</span>
	 				<p>%3$s <br> %5$s %4$s <i class="material-icons efbl_copy_id tooltipped" data-position="right" data-clipboard-text="%4$s" data-delay="100" data-tooltip="%6$s">content_copy</i></p>
	 				</li>',
                        $efbl_page->name,
                        $auth_img_src,
                        $efbl_page->category,
                        $efbl_username,
                        $efbl_username_label,
                        __( 'Copy', 'easy-facebook-likebox' )
                    );
                    $efbl_page = (array) $efbl_page;
                    $approved_pages[$efbl_page['id']] = $efbl_page;
                }
                $efbl_all_pages_html .= '</ul>';
            }
            
            $fta_self_url = 'https://graph.facebook.com/me?fields=id,name&access_token=' . $access_token;
            $fta_self_data = json_decode( jws_fetchUrl( $fta_self_url, $args ) );
            $FTA = new Feed_Them_All();
            $fta_settings = $FTA->fta_get_settings();
            $fta_settings['plugins']['facebook']['approved_pages'] = $approved_pages;
            $fta_settings['plugins']['facebook']['access_token'] = $access_token;
            $fta_settings['plugins']['facebook']['author'] = $fta_self_data;
            $efbl_saved = update_option( 'fta_settings', $fta_settings );
            
            if ( isset( $efbl_saved ) ) {
                echo  wp_send_json_success( [ __( 'Successfully Authenticated! Taking you to next step', 'easy-facebook-likebox' ), $efbl_all_pages_html ] ) ;
                die;
            } else {
                echo  wp_send_json_error( __( 'Something went wrong! Refresh the page and try Again', 'easy-facebook-likebox' ) ) ;
                die;
            }
        
        }
        
        /*
         * efbl_create_skin_url on ajax.
         * Returns the URL.
         */
        function efbl_create_skin_url()
        {
            $skin_id = intval( $_POST['skin_id'] );
            $selectedVal = intval( $_POST['selectedVal'] );
            $page_id = intval( $_POST['page_id'] );
            $page_permalink = get_permalink( $page_id );
            
            if ( wp_verify_nonce( $_POST['efbl_nonce'], 'efbl-ajax-nonce' ) ) {
                $customizer_url = admin_url( 'customize.php' );
                if ( isset( $page_permalink ) ) {
                    $customizer_url = add_query_arg( [
                        'url'              => urlencode( $page_permalink ),
                        'autofocus[panel]' => 'efbl_customize_panel',
                        'efbl_skin_id'     => $skin_id,
                        'mif_customize'    => 'yes',
                        'efbl_account_id'  => $selectedVal,
                    ], $customizer_url );
                }
                echo  wp_send_json_success( [ __( 'Please wait! We are generating preview for you.', 'easy-facebook-likebox' ), $customizer_url ] ) ;
                die;
            } else {
                echo  wp_send_json_error( __( 'Something Went Wrong! Please try again.', 'easy-facebook-likebox' ) ) ;
                die;
            }
        
        }
    
    }
    $Easy_Facebook_Likebox_Admin = new Easy_Facebook_Likebox_Admin();
}
