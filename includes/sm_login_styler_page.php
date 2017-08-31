<?php
class SMLoginStylerSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'sm_login_styler_menu' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */

	function sm_login_styler_menu(){
		add_menu_page(
			'SM Login Page Styler',
			'SM Login Page Styler',
			'manage_options',
			'sm-login-styler',
			 array($this,'sm_login_styler_page'),
			SM_LOGIN_STYLER_URL.'assets/images/icon.png',
			6
		);
	}


	function sm_login_styler_page(){
		// Set class property
        $this->options = get_option( 'sm_login_styler' );
        ?>
        <div class="wrap">
            <h1>SM Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'sm_login_styler_option_group' );
                do_settings_sections( 'sm-login-styler' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
	}


    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'sm_login_styler_option_group', // Option group
            'sm_login_styler', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'sm_login_styler_settings_id', // ID
            'SM Login Page Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'sm-login-styler' // Page
        );  



        add_settings_field(
            'form_background_color', 
            'Form Background Color', 
            array( $this, 'form_background_color_callback' ), 
            'sm-login-styler', 
            'sm_login_styler_settings_id'
        );  

        add_settings_field(
            'form_font_color', 
            'Form Label Color', 
            array( $this, 'form_font_color_callback' ), 
            'sm-login-styler', 
            'sm_login_styler_settings_id'
        );  




        add_settings_field( 
            'logo_url', 
            "Login Logo", 
            array( $this, 'logo_upload_url') , 
            'sm-login-styler', 
            'sm_login_styler_settings_id' 
        );   

        add_settings_field(
            'title', 
            'Logo Title', 
            array( $this, 'title_callback' ), 
            'sm-login-styler', 
            'sm_login_styler_settings_id'
        );  

        add_settings_field(
            'logo_link_url', 
            'Link Url', 
            array( $this, 'logo_link_url_callback' ), 
            'sm-login-styler', 
            'sm_login_styler_settings_id'
        );  
        
        add_settings_field(
            'logo_size', 
            'Logo Size', 
            array( $this, 'logo_size_callback' ), 
            'sm-login-styler', 
            'sm_login_styler_settings_id'
        );  


        add_settings_field(
            'background_image', 
            'Background Image', 
            array( $this, 'background_image_callback' ), 
            'sm-login-styler', 
            'sm_login_styler_settings_id'
        );  
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        
        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        if( isset( $input['logo_link_url'] ) )
            $new_input['logo_link_url'] = sanitize_text_field( $input['logo_link_url'] );

        if( isset( $input['logo_size'] ) )
            $new_input['logo_size'] = abs( $input['logo_size'] );

        if( isset( $input['form_background_color'] ) )
            $new_input['form_background_color'] = sanitize_text_field( $input['form_background_color'] );

        if( isset( $input['form_font_color'] ) )
            $new_input['form_font_color'] = sanitize_text_field( $input['form_font_color'] );



        if( isset( $input['logo_url'] ) )
            $new_input['logo_url'] = sanitize_text_field( $input['logo_url'] );


        if( isset( $input['background_image'] ) )
            $new_input['background_image'] = sanitize_text_field( $input['background_image'] );




        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your login page settings below:';
    }


    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="sm_login_styler[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
    public function logo_link_url_callback()
    {
        printf(
            '<input type="text" id="logo_link_url" name="sm_login_styler[logo_link_url]" value="%s" />',
            isset( $this->options['logo_link_url'] ) ? esc_attr( $this->options['logo_link_url']) : ''
        );
    }

     public function logo_size_callback()
    {
        printf(
            '<input type="text" id="logo_size" name="sm_login_styler[logo_size]" value="%s" /><br/> Size field value will [84 to 200].',
            isset( $this->options['logo_size'] ) ? esc_attr( $this->options['logo_size']) : ''
        );
    }




    public function form_background_color_callback() { 
     
        printf(
            '<input type="text" name="sm_login_styler[form_background_color]" value="%s" class="cpa-color-picker" data-default-color="#fff" >',
            isset( $this->options['title'] )  ? $this->options['form_background_color'] : ''
        );
         
    }

    public function form_font_color_callback() { 
     
        printf(
            '<input type="text" name="sm_login_styler[form_font_color]" value="%s" class="cpa-color-picker" data-default-color="#000" >',
            isset( $this->options['title'] )  ? $this->options['form_font_color'] : ''
        );
         
    }





    function logo_upload_url(){
		$options['logo_url']=isset( $this->options['logo_url'] ) ? esc_attr( $this->options['logo_url']) : SM_LOGIN_STYLER_URL.'assets/images/LoginPageStyler.png';
		?><br>
		<label for="logo_url">
		<input id="logo_url" type="hidden" size="36" value="<?php echo $options['logo_url']; ?>" name="sm_login_styler[logo_url]" />
		</label>
		<style>
			#logo_view{
				cursor: pointer;
			}
		</style>
		<?php
		if($options['logo_url']){
			echo "<img id='logo_view' src='". $options['logo_url'] ."' style='padding:20px;' />";			
		}else{

		}
	}

	function background_image_callback(){
		$options['background_image']=isset( $this->options['background_image'] ) ? esc_attr( $this->options['background_image']) : SM_LOGIN_STYLER_URL.'assets/images/background.jpg';
		?><br>
		<label for="background_image">
		<input id="background_image" type="hidden" size="36" value="<?php echo $options['background_image']; ?>" name="sm_login_styler[background_image]" />
		</label>
		<style>
			#backgorund_image_view{
				cursor: pointer;
				max-width: 90%;
			}
            #logo_view{
            width: 250px;
            height: 250px;
        }
		</style>
		<script type="text/javascript">
		jQuery(document).ready(function() {

                jQuery('#backgorund_image_view').on("click", function() {
                    formfield = jQuery("#background_image").attr('name');
             
                    tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
                    
                    //store old send to editor function
                    window.restore_send_to_editor = window.send_to_editor;
                    
                    // Display the Image link in TEXT Field
                    window.send_to_editor = function(html) { 
                        // fileurl = jQuery('img',html).attr('src');
                        fileurl = jQuery("<div>" + html + "</div>").find('img').attr('src');
                        jQuery('#background_image').val(fileurl);
                        jQuery('#backgorund_image_view').attr('src',fileurl);
                        tb_remove(); 
                        window.send_to_editor = window.restore_send_to_editor;
                    }
                    return false;
                });

                jQuery('#logo_view').on("click", function() {
                    formfield = jQuery("#logo_url").attr('name');
             
                    tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
                    
                    //store old send to editor function
                    window.restore_send_to_editor = window.send_to_editor;
                    
                    // Display the Image link in TEXT Field
                    window.send_to_editor = function(html) { 
                        // fileurl = jQuery('img',html).attr('src');
                        fileurl = jQuery("<div>" + html + "</div>").find('img').attr('src');
                        jQuery('#logo_url').val(fileurl);
                        jQuery('#logo_view').attr('src',fileurl);
                        tb_remove(); 
                        window.send_to_editor = window.restore_send_to_editor;
                    }
                    return false;
                });

                // jQuery( '.cpa-color-picker' ).wpColorPicker();
             

		});

        jQuery(document).ready(function($){
            var myOptions = {
                // you can declare a default color here,
                // or in the data-default-color attribute on the input
                defaultColor: false,
                // a callback to fire whenever the color changes to a valid color
                change: function(event, ui){},
                // a callback to fire when the input is emptied or an invalid color
                clear: function() {},
                // hide the color picker controls on load
                hide: true,
                // show a group of common colors beneath the square
                // or, supply an array of colors to customize further
                palettes: true
            };
             
            $('.cpa-color-picker').wpColorPicker(myOptions);
        });
		</script>
		<?php
		if($options['background_image']){
			echo "<img id='backgorund_image_view' src='". $options['background_image'] ."' style='padding:20px;' />";			
		}else{
			echo "<img id='backgorund_image_view' src='". $options['logo_url'] ."' style='padding:20px;' />";	
		}
	}


}

if( is_admin() )
    $sm_settings_page = new SMLoginStylerSettingsPage();