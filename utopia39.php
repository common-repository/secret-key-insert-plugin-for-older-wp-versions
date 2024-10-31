<?php
/*==============================================================================
Plugin Name: utopia39 - Add/Change SECRET_KEY in wp-config.php for WP 2.5.x installs
Version: 1.03
Plugin URI: http://www.ActiveBlogging.com/
Description: Adds or changes the random SECRET_KEY in your WordPress wp-config.php file, if file permissions allow it. NOT needed on new installs unless you want to change the key; it's useful on upgrades where you're reusing the old wp-config.php file. Just activate. On success the plugin will add the key, log you out, and then deactivate itself. On failure, it will give you a random key to add by hand. Note: if any problems, just delete this file or rename it and refresh your browser.
Author: David Pankhurst
Author URI: http://www.ActiveBlogging.com/
Copyright: Copyright (c) 2008 David Pankhurst - Licensed Under Artistic License 2.0 (http://www.gnu.org/philosophy/license-list.html#GPLCompatibleLicenses)
==============================================================================*/
if (!defined('ABSPATH'))
  die;
global $wp_version;
$u39_version=explode('.',$wp_version);
if ( $u39_version[0]<2 || (2==$u39_version[0]&&$u39_version[1]<5) )
  die('This plugin does not need to be run for WordPress versions before 2.5');
static $u39_plugin='';
$u39_plugin=ABSPATH . PLUGINDIR;
$u39_plugin=substr(__FILE__,strlen($u39_plugin)+1);
$u39_pluginList=get_option('active_plugins');
if ( is_array($u39_pluginList) && in_array($u39_plugin,$u39_pluginList) )
  add_action('admin_head','utopia39_unhookUs');
else
  utopia39_addSecretKey();
//------------------------------------------------------------------------------
function utopia39_addSecretKey()
{
  $file= ABSPATH . "wp-config.php";
  $lines=@implode('',@file($file));
  $key='';  
  $pool="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}|:<>?-=[];,.";
  $limit=strlen($pool)-1;
  $len=mt_rand(23,37);
  // generate new key
  while (--$len)
    $key .= $pool[mt_rand(0,$limit)];
  // add or replace?
  $regex='@([\n\r]+\s*define\s*\(\s*[\'"]SECRET_KEY[\'"]\s*,\s*)([\'"])[^\n\r]*(\2\s*\)\s*;)@si';
  if ( preg_match($regex,$lines,$matches) )
  {
    // current - insert new key only
    $line=$matches[1].$matches[2].$key.$matches[3];
    $lines=preg_replace($regex,$line,$lines);
  }
  else
  {
    // new - insert after DB_COLLATE line
    $line="define('SECRET_KEY', '$key');";
    $regex='@(DB_COLLATE[^\n\r]*)([\n\r]+)@si';
    $lines=preg_replace($regex,'$1$2'.$line.'$2',$lines);
  }
  // write out
  $success=FALSE;
  if (is_writable($file))
  {
    if ($handle=fopen($file,'wb'))
    {
      if (fwrite($handle,$lines))
        $success=TRUE;
      fclose($handle); 
    } 
  }
  if (!$success)
    die('wp-config.php cannot be written to - please set permissions to allow writing or edit it yourself and add this line:<br>'.htmlentities($line,ENT_QUOTES,'UTF-8'));
}
//------------------------------------------------------------------------------
function utopia39_unhookUs()
{
  global $u39_plugin;
	deactivate_plugins($u39_plugin,TRUE);
}
//------------------------------------------------------------------------------
?>
