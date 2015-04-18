<?php
defined('ABSPATH') or die("No script kiddies please!");

function jss_tss_retrieve_user_status($user)
{
  $url = "https://api.twitch.tv/kraken/users/${user}";
  $args = array
  (
    'timeout'     => 5,
    'redirection' => 1,
    'httpversion' => '1.0',
    'user-agent'  => "WordPress/${wp_version}; " . get_bloginfo( 'url' ) . '; Twitch Multicaster Status Widget/0.1 (vxjasonxv@gmail.com)',
    'blocking'    => true,
    'headers'     => array(),
    'cookies'     => array(),
    'body'        => null,
    'compress'    => false,
    'decompress'  => true,
    'sslverify'   => true,
    'stream'      => false,
    'filename'    => null
  );

  return wp_remote_get($url, $args);
}

function jss_tss_retrieve_stream_status($user)
{
  $url = "https://api.twitch.tv/kraken/streams/${user}";
  $args = array
  (
    'timeout'     => 5,
    'redirection' => 1,
    'httpversion' => '1.0',
    'user-agent'  => "WordPress/${wp_version}; " . get_bloginfo( 'url' ) . '; Twitch Multicaster Status Widget/0.1 (vxjasonxv@gmail.com)',
    'blocking'    => true,
    'headers'     => array(),
    'cookies'     => array(),
    'body'        => null,
    'compress'    => false,
    'decompress'  => true,
    'sslverify'   => true,
    'stream'      => false,
    'filename'    => null
  );

  return wp_remote_get($url, $args);
}
