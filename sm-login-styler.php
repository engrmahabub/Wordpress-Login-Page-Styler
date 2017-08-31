<?php 
/*
Plugin Name: SM Login Styler
Plugin URI: http://www.mahabub.me/
Author: Mahabubur Rahman
Author URI: http://www.mahabub.me/
Version: 1.0.0
Description: Wordpress plugin for <strong>customize login form.</strong>.
*/

define('SM_LOGIN_STYLER_PATH',plugin_dir_path( __FILE__ ));
define('SM_LOGIN_STYLER_URL',plugin_dir_url( __FILE__ ));

function sm_login_styler_scripts_enqueue() {
	wp_register_style( 'sm-styler-page', SM_LOGIN_STYLER_URL.'/assets/css/styler-page.css', false, null, 'all' );
	wp_enqueue_style( 'sm-styler-page' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );
   wp_enqueue_script( 'script_handle', SM_LOGIN_STYLER_URL.'/assets/js/sm-styler-page.js', array( 'wp-color-picker' ), false, true );
}

add_action( 'admin_enqueue_scripts', 'sm_login_styler_scripts_enqueue' );


require(SM_LOGIN_STYLER_PATH.'includes/sm_login_styler_page.php'); 


// $options = get_option( 'sm_login_styler' );

function sm_login_logo() { 
	$options = get_option( 'sm_login_styler' );
	$logo_url=isset( $options['logo_url'] ) ? esc_attr( $options['logo_url']) : SM_LOGIN_STYLER_URL.'assets/images/LoginPageStyler.png';
	$form_background_color=isset( $options['form_background_color'] ) ? esc_attr( $options['form_background_color']) : '#fff';
	$form_font_color=isset( $options['form_font_color'] ) ? esc_attr( $options['form_font_color']) : '#000';
	$logo_size=isset( $options['logo_size'] ) ? esc_attr( $options['logo_size']) : '84';
	?>
	<style type="text/css">
    	#login h1 a, .login h1 a {
        	background-image: url(<?= $logo_url; ?>);
		    padding: 0px;
		    width: <?= $logo_size; ?>px;
		    height: <?= $logo_size; ?>px;
	        background-size: <?= $logo_size; ?>px;
    	}

    	.login form{
    		border-radius: 5px;
    		background: <?=$form_background_color;?>;
    	}

    	.login form lable{
    		color:<?=$form_font_color;?>;
    	}

    	.login form input[type=text],
    	.login form input[type=password]{
    		border-radius: 5px;
    	}

    	.login form input[type=submit]{
	        background: #008E1F;
			border-color: #007E1F;
		    color: #fff;
    	}

    	.login form input[type=submit]:hover{
            background: #04B52B;
    		border-color: #04A52B;
		    color: #fff;
    	}


	</style>
	<?php 
}
add_action( 'login_enqueue_scripts', 'sm_login_logo' );

function sm_login_styler_background_image(){
	$options = get_option( 'sm_login_styler' );
	$background_image=isset( $options['background_image'] ) ? esc_attr( $options['background_image']) : SM_LOGIN_STYLER_URL.'assets/images/background.jpg';
	?>
	<style type="text/css">
		body.login {
		    background-image: url(<?php echo $background_image; ?>);
		    background-size: 100% 100%;
		    background-repeat: no-repeat;
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'sm_login_styler_background_image' );
function sm_login_logo_url() {
	$options = get_option( 'sm_login_styler' );
	if($options['logo_link_url']){
		return $options['logo_link_url'];
	}else{
    	return home_url();		
	}
}
add_filter( 'login_headerurl', 'sm_login_logo_url' );

function sm_login_logo_url_title() {
	$options = get_option( 'sm_login_styler' );
	if($options['title']){
		return $options['title'];
	}else{
    	return 'Your Site Name and Info';		
	}
}
add_filter( 'login_headertitle', 'sm_login_logo_url_title' );


