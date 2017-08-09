<?php
/**
 * @package Floatin_Facebook_Page
 * @version 1.0
 */
/*
Plugin Name: Floating Facebook Page
Plugin URI: http://wordpress.org/plugins/floating-facebook-page/
Description: Simple way to add a facebook page to your website.
Author: RianGraphics
Version: 1.0
Author URI: http://www.riangraphics.com/
*/

add_action( 'admin_menu', 'floating_facebook_page_menu' );

function floating_facebook_page_menu() {
	add_menu_page( 'Floating Facebook Page', 'Floaing Facbook Page', 'manage_options', 'floating-facebook-page.php', 'floating_facebook_page', plugin_dir_url( __FILE__ ) . 'img/icon.png', 6  );
    
add_action( 'admin_init', 'register_floating_facebook_page_settings' );

}

function register_floating_facebook_page_settings() {
    
        
    $settingsArray = array (
        'facebook_url'
    );

    foreach ($settingsArray as $setting) {
        register_setting( 'floating-facebook-page-settings-group', $setting);
    }
	//register our settings
    register_setting( 'floating-facebook-page-settings-group', 'floating_facebook_page_enable' );
}

function floating_facebook_page() {
?>
<div class="wrap">
<h2>Floating Facebook Page</h2>
<form method="post" action="options.php">
    <?php settings_fields( 'floating-facebook-page-settings-group' ); ?>
    <?php do_settings_sections( 'floating-facebook-page-settings-group' ); ?>
    <table class="form-table multi-field-wrapper">
        <tr valign="top">
        <th scope="row">Enable/Disable</th>
        <td><input name="floating_facebook_page_enable" type="checkbox" value="1" <?php checked( '1', get_option( 'floating_facebook_page_enable' ) ); ?> />
            </td>
        </tr>
        <tr valign="top">
        <th scope="row">Facebook page URL</th>
        <td><input name="facebook_url" type="text" value="<?php echo esc_attr( get_option( 'facebook_url' ) ); ?>" />
            </td>
        </tr>
        </tbody>
    </table>
    <?php submit_button(); ?>

</form>
</div>
<?php } 


function facebook_page() {
    $mytruef = get_option( 'floating_facebook_page_enable' );
    $url = get_option( 'facebook_url' );
	if(!is_admin() && $mytruef == 1 ) {
        
    echo "
    <div class='mypinf'>
    <i id='mrightf' class='fa fa-angle-down' aria-hidden='true'></i>
    <i id='mleftf' class='fa fa-angle-up display' aria-hidden='true'></i>
    <i class='fa fa-facebook-official' aria-hidden='true'></i> Facebook
    </div>
    <div id='rg-facebook'>
    <div id='fb-root'></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.8&appId=137531223039732';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div class='fb-page' data-href='$url' data-tabs='timeline' data-width='300' data-height='400' data-small-header='true' data-adapt-container-width='true' data-hide-cover='false' data-show-facepile='true'><blockquote cite='$url' class='fb-xfbml-parse-ignore''><a href='$url'>Titolo Pagina</a></blockquote></div>
    </div>
    ";
  }
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'wp_footer', 'facebook_page' );

// We need some CSS to position the paragraph
function facebook_page_css() {
$mytruef = get_option( 'floating_facebook_page_enable' );
if( $mytruef == 1 ) {
	echo '
<style type="text/css">
    .display {display:none;}
    .mypinf {
    width: auto;
    font-size: 16px;
    border: 2px solid #fff;
    color: #fff;
    position: fixed;
    top: 30%;
    background: #3b5998;
    padding: 8px;
    z-index: 999999;
    }    
	#rg-facebook {
    display:none;
    width: 300px;
    margin: 0px;
    height: 60%;
    position: fixed;
    z-index: 99999;
    left: -300px;
    top: 30%;
	}
    .rg-facebook-toggle {
    display:block!important;
    left: 40px!important;
	}
    .rg-label {
    font-weight: 700;
    font-size: 16px;
    }
	</style>
	';
}
}

add_action( 'wp_head', 'facebook_page_css' );

function facebook_page_js() {
$mytruef = get_option( 'floating_facebook_page_enable' );
if( $mytruef == 1 ) {
	echo '
	<script>
    jQuery( ".mypinf" ).click(function() {
  jQuery( "#rg-facebook" ).toggleClass( "rg-facebook-toggle" );
  jQuery( "#mrightf" ).toggleClass( "display" );
  jQuery( "#mleftf" ).toggleClass( "display" );
});
	</script>
	';
}
}

add_action( 'wp_footer', 'facebook_page_js' );

?>
