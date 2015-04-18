<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
* @package Twitch_Stream_Status
* @version 0.1.0
*/
/*
Plugin Name: Twitch Stream Status
Plugin URI: http://vxjasonxv.github.io/twitch-stream-status
Description: Lists specified broadcasters currently streaming in a sidebar widget
Version: 0.1.0

Author: Jason Salaz
Author URI: http://vxjasonxv.com

Network: false
License: GPL2 (see includes/COPYING for details)
*/

require_once dirname(__FILE__) . '/includes/twitch-api.php';
require_once dirname(__FILE__) . '/includes/twitch-admin.php';

class JSS_TSS_Twitch_Stream_Status_Widget extends WP_Widget
{
  function __construct ()
  {
    parent::__construct
    (
      'twitch_stream_status', // id
      'Twitch Stream Status', // name
      'A Twitch stream status sidebar widget' //desc
    );
  }
}

/**
 * Sidebar
 */
require_once dirname(__FILE__) . '/includes/twitch-sidebar.php';
