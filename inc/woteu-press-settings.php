<?php
add_action( 'admin_menu', 'woteu_press_admin_menu' );
function woteu_press_admin_menu() {
    add_options_page( 'WOTEU Press', 'WOTEU Press', 'manage_options', 'woteu-press', 'woteu_press_options_page' );
}

add_action( 'admin_init', 'woteu_press_admin_init' );
function woteu_press_admin_init() {
    register_setting( 'woteu-press-settings-group', 'woteu-press-nickname','woteu_press_settings_validate' );
    register_setting( 'woteu-press-settings-group', 'woteu-press-acc_id','woteu_press_id_validate' );
    add_settings_section( 'section-one', 'Section One', 'woteu_press_callback', 'woteu-press' );
    add_settings_field( 'field-one', 'Nickname', 'woteu_press_field_one_callback', 'woteu-press', 'section-one' );
}

function woteu_press_callback() {
    echo 'Some help text goes here.';
}

function woteu_press_field_one_callback() {
    $nickname = esc_attr( get_option( 'woteu-press-nickname' ) );
    $acc_id = esc_attr( get_option( 'woteu-press-acc_id' ) );
    echo "<input type='text' name='woteu-press-nickname' value='$nickname' />";
    echo "<br>";
    echo "<input type='text' name='woteu-press-acc_id' value='$acc_id' disabled/>";
}

function woteu_press_options_page() {
    ?>
    <div class="wrap">
        <h2>My Plugin Options</h2>
        <form action="options.php" method="POST">
            <?php wp_nonce_field( 'edit_setting_'.'12' ); ?>
            <?php settings_fields( 'woteu-press-settings-group' ); ?>
            <?php do_settings_sections( 'woteu-press' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function woteu_press_settings_sanitize( $input ) {
    $output = absint( $input );
    return $output;
}

function woteu_press_settings_validate( $input ) {
    $output = get_option( 'woteu-press-nickname' );
            
    // checken voordat we iets doen   
    $output = wot_api($input,'get_acc_id');
    
    if (is_numeric( $output ) )
        {
            $output = $input;
        }
        else {
            add_settings_error( 'woteu-press-setting', 'No User Found', 'No User Found' );
        }
  
    return $output;
}
function woteu_press_id_validate() {
    $nick = get_option( 'woteu-press-nickname' );
        // checken voordat we iets doen   
    $output = wot_api($nick,'get_acc_id');
    
    if (is_numeric( $output ) )
        {
            return $output;
        }
        else {
            add_settings_error( 'woteu-press-setting', 'No User Found', 'No User Found' );
        }
  
    return $output;
}

    
?>