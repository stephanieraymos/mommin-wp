<?php
/**
 * Admin View: Page - Facebook
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$FTA = new Feed_Them_All();

$ESF_Admin = new ESF_Admin();

$fta_settings = $FTA->fta_get_settings();

$app_ID = [ '405460652816219', '222116127877068' ];

$rand_app_ID = array_rand( $app_ID, '1' );

$u_app_ID = $app_ID[ $rand_app_ID ];

$auth_url = esc_url( add_query_arg( [
	'client_id'    => $u_app_ID,
	'redirect_uri' => 'https://maltathemes.com/efbl/app-' . $u_app_ID . '/index.php',
	'scope'        => 'manage_pages',
	'state'        => admin_url( 'admin.php?page=easy-facebook-likebox' ),
], 'https://www.facebook.com/dialog/oauth' ) );

?>
    <div class="esf_loader_wrap">
        <div class="esf_loader_inner">
            <div class="loader efbl_loader"></div>
        </div>
    </div>
<div class="fta_wrap_outer" <?php if( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ){?> style="width: 78%" <?php } ?>>
    <div class="efbl_wrap z-depth-1">
        <div class="efbl_wrap_inner">

            <div class="efbl_tabs_holder">
                <div class="efbl_tabs_header">
                    <ul id="efbl_tabs" class="tabs">
                        <li class="tab col s3">
                            <a class="active" href="#efbl-authentication">
                                <span><?php esc_html_e( "1", 'easy-facebook-likebox' ); ?>. <?php esc_html_e( "Authenticate", 'easy-facebook-likebox' ); ?></span>
                            </a>
                        </li>
                        <li class="tab col s3">
                            <a class="active" href="#efbl-general">
                                <span><?php esc_html_e( "2", 'easy-facebook-likebox' ); ?>. <?php esc_html_e( "Use (Display)", 'easy-facebook-likebox' ); ?></span>
                            </a>
                        </li>
                        <li class="tab col s3">
                            <a class="active" href="#efbl-skins">
                                <span><?php esc_html_e( "3", 'easy-facebook-likebox' ); ?>. <?php esc_html_e( "Customize (skins)", 'easy-facebook-likebox' ); ?></span>
                            </a>
                        </li>
                        <li class="tab col s3">
                            <a class="active" href="#efbl-auto-popup">
                                <span><?php esc_html_e( "Auto PopUp", 'easy-facebook-likebox' ); ?></span>
                            </a>
                        </li>
                        <li class="tab col s3">
                            <a class="active" href="#efbl-cached">
                                <span><?php esc_html_e( "Clear Cache", 'easy-facebook-likebox' ); ?></span>
                            </a>
                        </li>
                        <li class="indicator"></li>
                    </ul>

					<?php if ( ( $fta_settings['plugins']['instagram']['status'] ) && ( 'activated' == $fta_settings['plugins']['instagram']['status'] ) ) { ?>

                        <div class="efbl_tabs_right">
                            <a class=""
                               href="<?php echo esc_url( admin_url( 'admin.php?page=mif' ) ) ?>"><?php esc_html_e( "Instagram", 'easy-facebook-likebox' ); ?></a>
                        </div>

					<?php } ?>
                </div>
            </div>
            <div class="efbl_tab_c_holder">
				<?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-authenticate-tab.php'; ?>
				<?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-how-to-use-tab.php'; ?>
				<?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-skins-tab.php'; ?>
				<?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-auto-popup-tab.php'; ?>
				<?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-clear-cache-tab.php'; ?>
            </div>
        </div>
    </div>

    <?php if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {

        $banner_info = $ESF_Admin->esf_upgrade_banner(); ?>

        <div class="espf-upgrade z-depth-2">
            <h2><?php  esc_html_e( $banner_info['name'] ); ?>
                <b><?php  esc_html_e( $banner_info['bold'] ); ?></b></h2>
            <p><?php  esc_html_e( $banner_info['fb-description'] ); ?></p>
            <p><?php  esc_html_e( $banner_info['discount-text'] ); ?> <code><?php  esc_html_e( $banner_info['coupon'] ); ?></code>
            </p>
            <a href="<?php echo esc_url( efl_fs()->get_upgrade_url() ) ?>"
               class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e( $banner_info['button-text'] ); ?>
            </a>
        </div>

    <?php } ?>

</div>

<?php if ( efl_fs()->is_free_plan() || efl_fs()->is_plan( 'instagram_premium', true ) ) {

	$mt_plugins = $ESF_Admin->mt_plugins_info();
	?>
    <div class="fta-other-plugins-sidebar">
		<?php if ( $mt_plugins ) { ?>

            <div class="fta-other-plugins-wrap z-depth-1">

                <div class="fta-other-plugins-head">
                    <h5><?php esc_html_e( 'Love this plugin?', 'easy-facebook-likebox' ); ?></h5>
                    <p><?php esc_html_e( 'Then why not to try our other awesome and FREE plugins.', 'easy-facebook-likebox' ); ?></p>
                </div>

                <div class="fta-plugins-carousel">
                    <div class="carousel carousel-slider center">

						<?php foreach ( $mt_plugins as $slug => $mt_plugin ) {

							$install_link = $ESF_Admin->mt_plugin_install_link( $slug ); ?>

                            <div class="carousel-item"
                                 href="<?php esc_attr_e( $slug ); ?>">

								<?php if ( $mt_plugin->name ) { ?>

                                    <h2><?php esc_html_e( $mt_plugin->name ); ?></h2>

								<?php } ?>

								<?php if ( $mt_plugin->description ) { ?>

                                    <p><?php echo nl2br( esc_html( $mt_plugin->description ) ); ?></p>

								<?php } ?>

								<?php if ( $mt_plugin->active_installs ) { ?>

                                    <p><?php if ( strpos( $mt_plugin->active_installs, 'Just' ) !== false ) {
											esc_html_e( $mt_plugin->active_installs );
										} else {
											esc_html_e( 'Active Installs: ', 'easy-facebook-likebox' );
											esc_html_e( $mt_plugin->active_installs );
										} ?></p>

								<?php } ?>

                                <span title="<?php esc_html_e( '5-Star Rating', 'easy-facebook-likebox' ) ?>"
                                      class="stars">★ ★ ★ ★ ★ </span>

                                <div class="fta-carousel-actions">
                                    <a href="<?php echo esc_url( $install_link ); ?>"><?php if ( filter_var( $install_link, FILTER_VALIDATE_URL ) === false ) {
											esc_html_e( 'Already Installed', 'easy-facebook-likebox' );
										} else {
											esc_html_e( 'Install Now Free', 'easy-facebook-likebox' );
										} ?></a>

                                    <a class="right"
                                       href="https://wordpress.org/plugins/<?php esc_attr_e( $slug ); ?>"
                                       target="_blank"><?php esc_html_e( 'More Info', 'easy-facebook-likebox' ) ?></a>
                                </div>

                            </div>
						<?php } ?>

                    </div>
                </div>
            </div>

		<?php } ?>

        <div class="fta-other-plugins-wrap z-depth-1 fta-partners-wrap">

            <div class="fta-other-plugins-head">
                <h5><?php esc_html_e( 'Our Partners', 'easy-facebook-likebox' ); ?></h5>
            </div>
            <div class="fta-plugins-carousel">
                <img src="<?php echo FTA_PLUGIN_URL ?>/admin/assets/images/cloudways-logo.png"/>
                <p><?php esc_html_e( "We simplify hosting experiences because we believe in empowering individuals, teams and businesses. We set high standards of performance, commit to complete freedom of choice coupled with simplicity and agility in every process.", 'easy-facebook-likebox' ); ?></p>
                <p><?php esc_html_e( "Backed by an innovative approach, our platform is built on best-of-breed technologies and industry-leading infrastructure providers that creates smooth managed cloud hosting experiences. And, we do this by investing in the right talent and by organizing the perfect teams.", 'easy-facebook-likebox' ); ?></p>

                <div class="fta-carousel-actions">
                    <a href="https://www.cloudways.com/en/?id=571774" rel="noopener noreferrer" target="_blank"><?php esc_html_e( "More Info", 'easy-facebook-likebox' ); ?></a>

                </div>
            </div>

        </div>
    </div>

    </div>
<?php } ?>

    <!-- Popup starts<!-->
    <div id="fta-auth-error" class="modal">
        <div class="modal-content">
            <span class="mif-close-modal modal-close"><i
                        class="material-icons dp48">close</i></span>
            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">error_outline</i> </span>
                <p><?php esc_html_e( "Sorry, Plugin is unable to get the pages data. Please delete the access token and select pages in the second step of authentication to give the permission.", 'easy-facebook-likebox' ); ?></p>

                <a class="waves-effect waves-light efbl_authentication_btn btn"
                   href="<?php echo $auth_url ?>"><img class="efb_icon left"
                                                       src="<?php echo EFBL_PLUGIN_URL ?>/admin/assets/images/facebook-icon.png"/><?php esc_html_e( "Connect My Facebook Pages", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>
    <!-- Popup ends<!-->

    <!-- Popup starts<!-->
    <div id="fta-remove-at" class="modal">
        <div class="modal-content">
            <span class="mif-close-modal modal-close"><i
                        class="material-icons dp48">close</i></span>
            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">error_outline</i> </span>
                <h5><?php esc_html_e( "Are you sure?", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "Do you really want to delete the access token? It will delete all the pages data, access tokens and premissions given to the app.", 'easy-facebook-likebox' ); ?></p>
                <a class="waves-effect waves-light btn modal-close"
                   href="javascript:void(0)"><?php esc_html_e( "Cancel", 'easy-facebook-likebox' ); ?></a>
                <a class="waves-effect waves-light btn efbl_delete_at_confirmed modal-close"
                   href="javascript:void(0)"><?php esc_html_e( "Delete", 'easy-facebook-likebox' ); ?></a>
            </div>
        </div>

    </div>
    <!-- Popup ends<!-->

    <!-- Remove Skin Popup starts<!-->
    <div id="efbl-remove-skin"
         class="modal efbl-remove-skin efbl-confirm-modal">
        <div class="modal-content">
            <span class="mif-close-modal modal-close"><i
                        class="material-icons dp48">close</i></span>
            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">error_outline</i> </span>
                <h5><?php esc_html_e( "Are you sure?", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "Do you really want to delete the skin? It will delete all the settings values of the skin.", 'easy-facebook-likebox' ); ?></p>
                <a class="waves-effect waves-light btn modal-close"
                   href="javascript:void(0)"><?php esc_html_e( "Cancel", 'easy-facebook-likebox' ); ?></a>
                <a class="waves-effect waves-light btn efbl_skin_delete modal-close"
                   href="javascript:void(0)"><?php esc_html_e( "Delete", 'easy-facebook-likebox' ); ?></a>
            </div>
        </div>

    </div>
    <!-- Remove Skin Popup ends<!-->

<?php if ( efl_fs()->is_free_plan() ) { ?>
    <!-- Filter Modal Structure -->
    <div id="efbl-filter-upgrade" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We're sorry, posts filter is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?>
                    <a target="_blank"
                       href="https://easysocialfeed.com/custom-facebook-feed"><?php esc_html_e( "Check out the demo", 'easy-facebook-likebox' ); ?></a>
                </p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Filter Modal Structure Ends-->

    <!-- Grid Layout Modal Structure -->
    <div id="efbl-free-grid-upgrade" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We are sorry grid layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?>
                    <a target="_blank"
                       href="https://easysocialfeed.com/custom-facebook-feed/grid"><?php esc_html_e( "Check out the demo", 'easy-facebook-likebox' ); ?></a>
                </p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Grid Layout Structure Ends-->

    <!-- Grid Layout Modal Structure -->
    <div id="efbl-free-masonry-upgrade" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We are sorry masonry layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?>
                    <a target="_blank"
                       href="https://easysocialfeed.com/custom-facebook-feed/masonry"><?php esc_html_e( "Check out the demo", 'easy-facebook-likebox' ); ?></a>
                </p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Grid Layout Structure Ends-->

    <!-- Carousel Layout Modal Structure -->
    <div id="efbl-free-carousel-upgrade" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We are sorry carousel layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?>
                    <a target="_blank"
                       href="https://easysocialfeed.com/custom-facebook-feed/carousel"><?php esc_html_e( "Check out the demo", 'easy-facebook-likebox' ); ?></a>
                </p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Carousel Layout Structure Ends-->

    <!-- Other page Modal Structure -->
    <div id="efbl-other-pages-upgrade" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We're sorry, ability to display posts from other pages not managed by you is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?></p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Other page Modal Structure Ends-->

    <!-- Tabs Modal Structure -->
    <div id="efbl-tabs-upgrade" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We are sorry showing tabs in likebox feature is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?></p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Filter Tabs Structure Ends-->

    <!-- Select pages Modal Structure -->
    <div id="efbl-pages-enable" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We are sorry showing popup on specific pages feature is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?></p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Select pages Structure Ends-->

    <!-- Select posts Structure -->
    <div id="efbl-posts-enable" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We're sorry, ability to display posts from other pages not managed by you is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?></p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

    <!-- Select posts Structure Ends-->

    <!-- exit intent  Structure -->
    <div id="efbl-exit-intent" class="fta-upgrade-modal modal">
        <div class="modal-content">

            <div class="mif-modal-content"><span class="mif-lock-icon"><i
                            class="material-icons dp48">lock_outline</i> </span>
                <h5><?php esc_html_e( "Premium Feature", 'easy-facebook-likebox' ); ?></h5>
                <p><?php esc_html_e( "We are sorry showing popup on exit intent feature is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox' ); ?></p>
                <p><?php esc_html_e( 'Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox' ); ?></p>
                <hr/>
                <a href="<?php echo efl_fs()->get_upgrade_url() ?>"
                   class="waves-effect waves-light btn"><i
                            class="material-icons right">lock_open</i><?php esc_html_e( "Upgrade to pro", 'easy-facebook-likebox' ); ?>
                </a>

            </div>
        </div>

    </div>

<?php } ?>