<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * @package Twitch
 */

require_once ABSPATH . '/wp-includes/widgets.php';
require_once dirname(__FILE__) . '/twitch-api.php';

function jss_tss_sidebar_widget($params, $live)
{
?>
<div class="Side-Column-Box">
<h3>
  <span>Live Broadcasts</span>
</h3>
<div>
<ul id="live-broadcasts" style="list-style: none;">
<?php
  foreach ($live as $c)
  {
?>
  <li class="live-broadcasts">
    <a href="http://www.twitch.tv/<?php echo $c['caster']; ?>"><?php echo $c['caster']; ?></a>
<?php
  echo $c['game'];
?>
  </li>
<?php
  }
?>
</ul>
</div>
</div>
<?php
}

$casters_setting = get_option('twitch-stream-status-casters');
if( !empty($casters_setting) )
{
  $live = array();
  $casters = explode(',', $casters_setting);
  foreach ($casters as $c)
  {
    $data = jss_tss_retrieve_stream_status($c);
    $s = json_decode($data['body']);

    if( $s->{'stream'} == NULL )
    { continue; }

    if( $s->{'stream'}->{'game'} != NULL )
    {
      $game = ' playing ' . $s->{'stream'}->{'game'};
    }
    else
    {
      $game = ' is currently live';
    }
    array_push($live, array('caster' => $c, 'game' => $game));
    $i++;
  }

  if(!empty($live))
  {
    wp_register_sidebar_widget(
      'jss_tss_sidebar_widget',                           // $id (id)
      'Twitch Broadcasts',                                // $name (displayed title)
      'jss_tss_sidebar_widget',                           // $output_callback (function to run when widget is called)
      array(                                              // $options (widget options)
        'description' => 'Displays live broadcasts.'
      ),
      $live
    );
  }
}
