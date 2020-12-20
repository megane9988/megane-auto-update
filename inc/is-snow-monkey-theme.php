<?php
/**
 * @package rui-jin-en-pattern
 * @author mgn
 * @license GPL-2.0+
 */

/**
 * Snow Monkey 以外のテーマを利用している場合は有効化してもカスタマイズが反映されないようにする
 */
$theme = wp_get_theme( get_template() );
if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
	function add_alert_need_theme_snow_monkey() {
		?>
<div class="error">
	<p><?php esc_html_e( '[RUI-JIN-EN Pattern Library] This Plugin needs the premium theme Snow Monkey.', 'rui-jin-en-pattern' ); ?></p>
</div>
		<?php
	};
	add_action( 'admin_notices', 'add_alert_need_theme_snow_monkey' );

	return;
}
