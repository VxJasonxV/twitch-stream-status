<?php
defined('ABSPATH') or die("No script kiddies please!");

require_once dirname(__FILE__) . '/twitch-api.php';

class options_page
{
  function __construct()
  {
    add_action( 'admin_menu', array( $this, 'jss_tss_register_settings' ) );
  }

  function jss_tss_register_settings()
  {
    add_options_page
    (
      'Twitch Multi-Caster Options',             // Page Title ( $page_title )
      'Twitch',                                  // Menu Title ( $menu_title )
      'manage_options',                          // Capability ( $capability )
      'twitch',                                  // Menu Slug  ( $menu_slug )
      array( $this, 'jss_tss_settings_page' )    // function for this option page ( $function )
    );

    add_settings_section
    (
      'jss-tss-settings-group-main',              // id attribute ( $id )
      'Twitch Plugin Settings',                   // Section Title ( $title )
      null,                                       // function for this settings group ( $callback )
      'twitch'                                    // Menu this options group will be displayed in ( $page )
    );

    register_setting
    (
      'jss-tss-settings-options',                // settings group name ( $option_group )
      'twitch-stream-status-casters',            // option name ( $option_name )
      array( $this, 'jss_tss_validate_caster')   // callback function to sanitize input ( $sanitize_callback )
    );
    add_settings_field
    (
      'jss-tss-settings-caster',                 // id attribute ( $id )
      'Twitch Channel Name',                     // Field Title ( $title )
      array( $this, 'jss_tss_edit_caster' ),     // Function to display / edit inputs. Name and id on input should match $id in this field ( $callback )
      'twitch',                                  // Page to display this field, should match $menu_slug ( $page )
      'jss-tss-settings-group-main'              // Section to display this field on ( $section )
    );
  }

  function jss_tss_edit_caster()
  {
    $v = get_option('twitch-stream-status-casters');
    if(!empty($v))
    {
      $casters = explode(',', $v);
      foreach ( $casters as $c )
      {
        echo "<input id='twitch-stream-status-casters' name='twitch-stream-status-casters[]' size='30' type='text' placeholder='Twitch Username' value='{$c}' /><br />";
      }
    }
    echo "<input id='twitch-stream-status-casters' name='twitch-stream-status-casters[]' size='30' type='text' placeholder='Twitch Username' />";
  }

  function jss_tss_validate_caster($input)
  {
    $sanitized_casters = array();
    foreach ( $input as $c )
    {
      $user = trim($c);
      $twitch_status = jss_tss_retrieve_user_status($user);
      if ($twitch_status['response']['code'] == '404')
      {
        continue;
      }
      array_push($sanitized_casters, $user);
    }
    return join(',', $sanitized_casters);
  }

  function jss_tss_settings_page()
  {
    if ( !current_user_can( 'manage_options' ) )
    {
      wp_die( 'You do not have sufficient permissions to access this page.' );
    }
?>
    <div class="wrap">
    <form method="post" action="options.php">
<?php
    settings_fields( 'jss-tss-settings-options' );    // Settings group name, should match the group name in register_setting() ( $option_group )
    do_settings_sections( 'twitch' );                 // Settings section name, should match the slug name of the page with settings sections, match the name used in add_settings_section ( $page )
?>
<table class="form-table">
  <tbody>
    <tr>
      <th scope="row">Adding a User</th>
      <td>
        <p>Adding a Caster and clicking Save Changes will save the Caster and add a new empty field.</p>
      </td>
    </tr>
    <tr>
      <th scope="row">Removing a User</th>
      <td>
        <p>Empty the text field for one or multiple users, they will be removed after clicking Save Changes.</p>
      </td>
    </tr>
  </tbody>
</table>
<?php
    submit_button();
?>
    </form>
  </div>
<?php
  }
}

new options_page;
