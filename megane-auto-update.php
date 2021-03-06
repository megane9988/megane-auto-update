<?php
/**
 * Plugin name: megane auto update plugin
 * Description: This plugin is a plugin with the sole purpose of being automatically updated.
 * Version: 1.0.3
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Requires Snow Monkey: 11.1.0
 *
 * @package megane
 * @author megane9988
 * @license GPL-2.0+
 */


namespace Megane\Plugin\autoUpdatePlugin;

use Inc2734\WP_GitHub_Plugin_Updater\Bootstrap as Updater;

// パスを定数化
define( 'MEGANE9988_FROM_GITHUB_AUTO_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'MEGANE9988_FROM_GITHUB_AUTO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );


require_once MEGANE9988_FROM_GITHUB_AUTO_PATH . '/inc/customizer.php';

class Bootstrap {
//必ず実施する項目として_plugins_loadedを実施
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, '_plugins_loaded' ) );
	}
	// 実施する項目
	public function _plugins_loaded() {
		//翻訳ファイルの読み込み
		load_plugin_textdomain( 'megane-auto-update', false, basename( __DIR__ ) . '/languages' );
		
		//アップデート通知機能の読み込みによる、アップデートの有無の確認
		add_action( 'init', array( $this, '_activate_autoupdate' ) );
		
		//Snow Monkey テーマが有効化されてない場合に、アラートを出す
		$theme = wp_get_theme( get_template() );
		if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
			add_action(
				'admin_notices',
				function() {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php esc_html_e( '[megane auto update plugin] Needs the Snow Monkey.', 'megane-auto-update' ); ?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

		$data = get_file_data(
			__FILE__,
			array(
				'RequiresSnowMonkey' => 'Requires Snow Monkey',
			)
		);

		if (
			isset( $data['RequiresSnowMonkey'] ) &&
			version_compare( $theme->get( 'Version' ), $data['RequiresSnowMonkey'], '<' )
		) {
			add_action(
				'admin_notices',
				function() use ( $data ) {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php
							echo esc_html(
								sprintf(
									// translators: %1$s: version
									__(
										'[megane auto update plugin] Needs the Snow Monkey %1$s or more.',
										'megane-auto-update'
									),
									'v' . $data['RequiresSnowMonkey']
								)
							);
							?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

	}

	/**
	 * Activate auto update using GitHub 自動アップデートの参照先の設定
	 *
	 * @return void
	 */
	public function _activate_autoupdate() {
		new Updater(
			plugin_basename( __FILE__ ),
			'megane9988',
			'megane-auto-update'
		);
	}
}



//Snow Monkey テーマが有効かの判別と、有効でない場合の処理
require_once MEGANE9988_FROM_GITHUB_AUTO_PATH . '/inc/is-snow-monkey-theme.php';

//Snow Monkey Blocks プラグインが有効かの判別と、有効でない場合の処理
require_once MEGANE9988_FROM_GITHUB_AUTO_PATH . '/inc/is-snow-monkey-blocks-plugin.php';

//ブロックスタイル及びブロックパターンの設定の読み込み
require_once MEGANE9988_FROM_GITHUB_AUTO_PATH . '/inc/load-register-block.php';

//コンポーザーの読み込み
require_once MEGANE9988_FROM_GITHUB_AUTO_PATH . '/vendor/autoload.php';

//このファイルに定義されているプログラムの実行
new Bootstrap();
