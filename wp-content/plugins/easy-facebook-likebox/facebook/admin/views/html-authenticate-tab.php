<?php
/**
 * Admin View: Tab - Autenticate
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$FTA = new Feed_Them_All();


$fta_settings = $FTA->fta_get_settings();

if ( isset( $_GET['access_token'] ) && ! empty( $_GET['access_token'] ) ) {
	$access_token = $_GET['access_token'];
	$access_token = preg_replace( '/[^A-Za-z0-9]/', "", $access_token );

	if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) { ?>

        <script>
          jQuery(document).ready(function($) {

            function EFBLremoveURLParameter(url, parameter) {

              var urlparts = url.split('?');

              if (urlparts.length >= 2) {

                var prefix = encodeURIComponent(parameter) + '=';

                var pars = urlparts[1].split(/[&;]/g);

                for (var i = pars.length; i-- > 0;) {

                  if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                  }
                }
                url = urlparts[0] + '?' + pars.join('&');
                return url;
              }
              else {
                return url;
              }
            }

            jQuery('#toast-container').slideUp('slow');

            Materialize.Toast.removeAll();

            /*
			* Show the dialog for Saving.
			*/
            Materialize.toast('Please wait! Authenticating...', 50000000);

            var url = window.location.href;

            url = EFBLremoveURLParameter(url, 'access_token');

            jQuery('#efbl_access_token').text('\'.$access_token.\'');

            var data = {
              'action': 'efbl_save_fb_access_token',
              'access_token': '<?php echo $access_token; ?>',
            };

            jQuery.ajax({

              url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
              type: 'post',
              data: data,
              dataType: 'json',
              success: function(response) {
                window.history.pushState('newurl', 'newurl', url);

                Materialize.Toast.removeAll();

                if (response.success) {

                  var pages_html = response.data['1'];

                  if (pages_html == null) {
                    $('#fta-auth-error').modal('open');
                    return;
                  }

                  Materialize.toast(response.data['0'], 3000);
                  jQuery('#toast-container').addClass('efbl_green');
                  jQuery('.efbl_all_pages').html(' ').html(response.data['1']);
                  jQuery('.fta_noti_holder').fadeOut('slow');

                  setTimeout(function() {
                    var fta_full_url = fta.fb_url + '#efbl-general';
                    window.location.href = '#efbl-general';
                    window.location.reload();
                  }, 2000);

                }
                else {
                  Materialize.toast(response.data, 3000);

                  jQuery('#toast-container').addClass('efbl_red');

                }
              },
            });

          });
        </script>
	<?php }
}

$app_ID = [ '405460652816219', '222116127877068' ];

$rand_app_ID = array_rand( $app_ID, '1' );

$u_app_ID = $app_ID[ $rand_app_ID ];

$authenticate_url = add_query_arg( [
	'client_id'    => $u_app_ID,
	'redirect_uri' => 'https://maltathemes.com/efbl/app-' . $u_app_ID . '/index.php',
	'scope'        => 'pages_read_engagement,pages_manage_metadata,pages_read_user_content',
	'state'        => admin_url( 'admin.php?page=easy-facebook-likebox' ),
], 'https://www.facebook.com/dialog/oauth' );


?>

<div id="efbl-authentication" class="col efbl_tab_c s12 slideLeft active">
    <h5><?php esc_html_e( "Let's connect your Facebook page(s) with the plugin.", 'easy-facebook-likebox' ); ?></h5>
    <p><?php esc_html_e( "Click the button below, log into your Facebook account and authorize the app to get access token.", 'easy-facebook-likebox' ); ?></p>
    <a class="waves-effect waves-light efbl_authentication_btn btn"
       href="<?php echo esc_url( $authenticate_url ) ?>"><img
                class="efb_icon left"
                src="<?php echo EFBL_PLUGIN_URL ?>/admin/assets/images/facebook-icon.png"/><?php esc_html_e( "Connect My Facebook Pages", 'easy-facebook-likebox' ); ?>
    </a>

    <div class="row auth-row">
        <div class="efbl_all_pages col s12">

			<?php if ( isset( $fta_settings['plugins']['facebook']['approved_pages'] ) && ! empty( $fta_settings['plugins']['facebook']['approved_pages'] ) ) { ?>

                <ul class="collection with-header">
                    <li class="collection-header">
                        <h5><?php esc_html_e( "Approved Pages", 'easy-facebook-likebox' ); ?>
                        </h5>

                        <a href="#fta-remove-at"
                           class="modal-trigger fta-remove-at-btn tooltipped"
                           data-position="left" data-delay="50"
                           data-tooltip="<?php esc_html_e( "Delete Access Token", 'easy-facebook-likebox' ); ?>">
                            <i class="material-icons">delete_forever</i>
                        </a>
                    </li>

					<?php foreach ( $fta_settings['plugins']['facebook']['approved_pages'] as $efbl_page ) {

						if ( $efbl_page['id'] ) {

							if ( isset( $efbl_page['username'] ) ) {

								$efbl_username       = $efbl_page['username'];
								$efbl_username_label = __( 'Username:', 'easy-facebook-likebox' );

							} else {

								$efbl_username       = $efbl_page['id'];
								$efbl_username_label = __( 'ID:', 'easy-facebook-likebox' );

							}

							?>

                            <li class="collection-item avatar li-<?php echo $efbl_page['id'] ?>">

                                <a href="<?php echo esc_url( 'https://web.facebook.com/' . $efbl_page['id'] . '' ) ?>"
                                   target="_blank">
                                    <img src="<?php echo efbl_get_page_logo( $efbl_page['id'] ); ?>"
                                         alt="" class="circle">
                                </a>

								<?php if ( $efbl_page['name'] ) { ?>

                                    <span class="title"><?php echo $efbl_page['name']; ?></span>

								<?php } ?>

                                <p>

									<?php if ( $efbl_page['category'] ) {
										echo $efbl_page['category'];
									} ?>
                                    <br>
									<?php if ( $efbl_username_label ) {
										echo $efbl_username_label;
									} ?>

									<?php if ( $efbl_username ) {
										echo $efbl_username; ?>

                                        <i class="material-icons efbl_copy_id tooltipped"
                                           data-position="right"
                                           data-clipboard-text="<?php echo $efbl_username ?>"
                                           data-delay="100"
                                           data-tooltip="<?php esc_html_e( "Copy", 'easy-facebook-likebox' ); ?>">content_copy</i>
									<?php } ?>
                                </p>

                            </li>


						<?php }
					} ?>

                </ul>


			<?php } ?>

        </div>
    </div>

    <p><?php esc_html_e( "Please note: This does not give us permission to manage your Facebook pages, it simply allows the plugin to see a list of the pages you approved and retrieve an Access Token.", 'easy-facebook-likebox' ); ?></p>

</div>