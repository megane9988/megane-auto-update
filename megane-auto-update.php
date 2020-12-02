<?php
/**
 * Plugin name: megane auto update plugin
 * Description: このプラグインは自動的にアップデートされることだけを目的にしたプラグインです。
 * Version: 0.0.3
 *
 * @package megane
 * @author megane9988
 * @license GPL-2.0+
 */

require_once "vendor/autoload.php";

$updater = new Inc2734\WP_GitHub_Plugin_Updater\Bootstrap(
	plugin_basename( __FILE__ ),
	'megane9988',
	'updatefromgithubplugin'
);