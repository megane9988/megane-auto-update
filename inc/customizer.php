<?php
/**
 * ABOUT
 *
 * @package ruijinen.
 */

/**
 * Customize_register
 *
 * @param Object $wp_customize is .
 */
function my_theme_customize_register( $wp_customize ) {
	about_customizer( $wp_customize );
}
add_action( 'customize_register', 'my_theme_customize_register' );

/**
 * About_customizer
 *
 * @param Object $wp_customize is .
 */
function about_customizer( $wp_customize ) {
	$prefix       = 'about';
	$option_name  = "${prefix}_options";
	$section_name = "${prefix}_section";

	$wp_customize->add_section(
		$section_name,
		array(
			'title'           => '類人猿',
			'priority'        => 20,
			'active_callback' => function () {
				return is_page();
			},
		)
	);
	// セクション内の各フィールドオプション設定
	$fields = array(
		'about_lead_title' => array(
			'label' => '類人猿情報 : ゴーシュは町の活動写真館でセロを弾く係りでした。けれどもあんまり上手でないという評判でした。上手でないどころではなく実は仲間の楽手のなかではいちばん下手でしたから、いつでも楽長にいじめられるのでした。',
		),
	);
	// セクションにフォームコントロールを追加
	add_customizer_contol( $wp_customize, $fields, $option_name, $section_name );
}

/**
 * テーマカスタマイザーにフォームコントロールを追加する
 *
 * @param Object $wp_customize is .
 * @param Object $fields 追加するオプションの配列.
 * @param Object $option_name is.
 * @param Object $section_name 追加するセクション名.
 */
function add_customizer_contol( $wp_customize, $fields, $option_name, $section_name ) {
	foreach ( (array) $fields as $id => $value ) {
		$default = ! empty( $value['default'] ) ? $value['default'] : null;
		$wp_customize->add_setting(
			$id,
			array(
				'default'   => $default,
				'transport' => 'postMessage',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			$id,
			array(
				'selector'            => "#${id}-customizer",
				'container_inclusive' => false,
				'render_callback'     => function ( $partial = null ) {
					return get_theme_mod( $partial->id, $default );
				},
			)
		);
		$wp_customize->add_control(
			"${option_name}_${id}",
			array(
				'settings'    => $id,
				'label'       => $value['label'],
				'section'     => $section_name,
				'type'        => ! empty( $value['type'] ) ? $value['type'] : 'hidden',
				'description' => ! empty( $value['description'] ) ? $value['description'] : null,
				'choices'     => ! empty( $value['choices'] ) ? $value['choices'] : null,
			)
		);
	}
}
