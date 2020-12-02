<?php
/**
 * Plugin name: megane auto update plugin
 * Description: このプラグインは自動的にアップデートされることだけを目的にしたプラグインです。
 * Version: 0.1.2
 *
 * @package megane
 * @author megane9988
 * @license GPL-2.0+
 */

namespace Megane\Plugin\autoUpdatePlugin;

use Inc2734\WP_GitHub_Plugin_Updater\Bootstrap as Updater;

define( 'MEGANE9988_FROM_GITHUB_AUTO_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'MEGANE9988_FROM_GITHUB_AUTO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

class Bootstrap {

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, '_plugins_loaded' ) );
	}

	public function _plugins_loaded() {
		add_action( 'init', array( $this, '_activate_autoupdate' ) );
	}

	/**
	 * Activate auto update using GitHub
	 *
	 * @return void
	 */
	public function _activate_autoupdate() {
		new Updater(
			plugin_basename( __FILE__ ),
			'megane9988',
			'updatefromgithubplugin',
			[ 'homepage' => 'https://megane-blog.com', ]
		);
	}
}

require_once( MEGANE9988_FROM_GITHUB_AUTO_PATH . '/vendor/autoload.php' );
new Bootstrap();
