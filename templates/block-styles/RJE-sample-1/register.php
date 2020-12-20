<?php
/**
 * @package rui-jin-en-pattern
 * @author mgn
 * @license GPL-2.0+
 */

$override_block_name = 'snow-monkey-blocks/directory-structure';
$block_style_label   = 'サンプル 1';


register_block_style(
	$override_block_name,
	array(
		'name'  => basename( __DIR__ ),
		'label' => $block_style_label,
	)
);
wp_register_style( basename( __DIR__ ) . '-front', plugins_url( '', __FILE__ ) . '/style.css', $this->style_front_deps, filemtime( plugin_dir_path( __FILE__ ) . 'style.css' ) );
wp_register_style( basename( __DIR__ ) . '-editor', plugins_url( '', __FILE__ ) . '/style.css', $this->style_editor_deps, filemtime( plugin_dir_path( __FILE__ ) . 'style.css' ) );