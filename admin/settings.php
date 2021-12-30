<?php

defined( 'ABSPATH' ) or die(':)');

//

if(isset($_POST['ipv-submit'])){

    if(!empty( $_POST['ipv_video_url'])){
        $url = !empty( $_POST['ipv_video_url'])? $_POST['ipv_video_url'] : null;
        $controls = !empty($_POST['ipv_controls'])? $_POST['ipv_controls'] : null;
        $mute = !empty($_POST['ipv_mute'])? $_POST['ipv_mute'] : null;
        $auto_play = !empty($_POST['ipv_auto_play'])? $_POST['ipv_auto_play'] : null; 

        $display_options = !empty($_POST['ipv_display_option']) ? $_POST['ipv_display_option'] : 'entire_website';

        $data = [
            'url' => $url,
            'controls' => $controls,
            'mute' => $mute,
            'auto_play' => $auto_play,
            'display_options' =>  $display_options,
        ];
        update_option( 'ipv-video', $data );
    }

}


//cookies
add_action( 'init', 'ipv_setcookie' );
function ipv_setcookie() {
	setcookie( 'intro-popup-video', 'intro-popup-video', time() + 24*3600);
}

function ipv_getcookie() {
	$cookie = isset( $_COOKIE['intro-popup-video'] ) ? $_COOKIE['intro-popup-video'] : '';
	return $cookie;
}

//localize scripts
add_action( 'wp_enqueue_scripts', function () {
    
    //get data from WPDB
    $data = get_option( 'ipv-video' );

   // Register our script
   wp_register_script( 'ipv-script', plugins_url( '/assets/js/ipv.js', dirname(__FILE__)), [], false, true );
   
   // Set up the required data
   $ipvData = [
      'url'            => $data['url'],
      'controls'         => $data['controls'],
      'mute'         => $data['mute'],
      'auto_play'         => $data['auto_play'],
      'display_options'         => $data['display_options'],
   ];

if(ipv_getcookie()){
   return false; 
}else {
    if ($data['display_options'] == 'entire_website'){
        
        // Localise the data, specifying our registered script and a global variable name to be used in the script tag
        wp_localize_script( 'ipv-script', 'ipvData', $ipvData);

        // Enqueue our script (this can be done before or after localisation)
        wp_enqueue_script( 'ipv-script' );
    
    }elseif($data['display_options'] == 'home_page' && is_front_page() && is_home() ){
        
        // Localise the data, specifying our registered script and a global variable name to be used in the script tag
        wp_localize_script( 'ipv-script', 'ipvData', $ipvData);
    
        // Enqueue our script (this can be done before or after localisation)
        wp_enqueue_script( 'ipv-script' );
        
    }elseif($data['display_options'] == 'home_page' && is_front_page(  )){
        
    // Localise the data, specifying our registered script and a global variable name to be used in the script tag
    wp_localize_script( 'ipv-script', 'ipvData', $ipvData);

    // Enqueue our script (this can be done before or after localisation)
    wp_enqueue_script( 'ipv-script' );
        
    }elseif($data['display_options'] == 'post_page' && is_home()){
        
    // Localise the data, specifying our registered script and a global variable name to be used in the script tag
    wp_localize_script( 'ipv-script', 'ipvData', $ipvData);

    // Enqueue our script (this can be done before or after localisation)
    wp_enqueue_script( 'ipv-script' );
    }else{
        return false;
    }
}


} );

//General Settig page 
function intro_popup_video_general_settings_page(){

    //get data from WPDB
    $data = get_option( 'ipv-video' );
    ?>
<div class="ipv-wrap">
    <div class="ipv-col">
        <h1>Welcome to Intro Popup Video</h1>

        <form action="" method="post">
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="ipv_video_url">Video URL</label></th>
                        <td>
                            <label for="ipv_video_url" style="display:block;">
                                <input style="width:100%;" class="ipv_video_url" type="url" id="ipv_video_url"
                                    name="ipv_video_url" value="<?php echo $data['url']; ?>">
                                <p class="description">
                                    Enter a video URL to display it as "Video Popup" when page loading. Enter YouTube,
                                    Vimeo, or MP4 video link only. SoundCloud is not supported.
                                </p>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ipv_controls">Controls</label></th>
                        <td>
                            <label for="ipv_controls" style="display:block;">
                                <input class="ipv_controls" type="checkbox" id="ipv_controls" name="ipv_controls"
                                    value="1" <?php echo $data['controls'] ? 'checked' : ''; ?>>
                                Enable Controls
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ipv_auto_play">AutoPlay</label></th>
                        <td>
                            <label for="ipv_auto_play" style="display:block;">
                                <input class="ipv_auto_play" type="checkbox" id="ipv_auto_play" name="ipv_auto_play"
                                    value="1" <?php echo $data['auto_play'] ? 'checked' : ''; ?>>
                                Enable Auto play
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ipv_mute">Mute</label></th>
                        <td>
                            <label for="ipv_mute" style="display:block;">
                                <input class="ipv_mute" type="checkbox" id="ipv_mute" name="ipv_mute" value="1"
                                    <?php echo $data['mute'] ? 'checked' : ''; ?>>
                                Enable Mute
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="ipv_display_option">Display Option</label></th>
                        <td>
                            <select name='ipv_display_option'>
                                <option value='entire_website'
                                    <?php echo $data['display_options'] == 'entire_website' ? 'selected' : ''; ?>>Entire
                                    Website.</option>
                                <option value='home_page'
                                    <?php echo $data['display_options'] == 'home_page' ? 'selected' : ''; ?>>
                                    Homepage only.</option>
                                <option value='post_page'
                                    <?php echo $data['display_options'] == 'post_page' ? 'selected' : ''; ?>>Posts page
                                    only.</option>
                            </select>
                            <p class="description">
                                Pop-up Video will be displayed once per visitor, and the Pop-up Video will be displayed
                                again to the same visitor after the 24 hours.
                            </p>
                        </td>
                    </tr>

                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="ipv-submit" id="ipv-submit" class="button button-primary"
                    value="Save Changes">
            </p>
        </form>

    </div>
    <div class="ipv-col">
    </div>
</div>
<?php
}