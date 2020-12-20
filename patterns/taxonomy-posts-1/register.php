<?php
/**
 * @package rui-jin-en-pattern
 * @author mgn
 * @license GPL-2.0+
 */

$pattern_category = array( 'RJE-company' );
$pattern_title    = '任意のタクソノミーの投稿 1';
$use_block_style  = array(
    'RJE-taxonomy-posts-1',
);


foreach ( $use_block_style as $block_style_name ) {
	$this->load_style_handle[ $block_style_name ][] = $pattern_title;
}

$contents = '';
ob_start();
require RJE_PLUGIN_PATH . 'patterns/' . basename( __DIR__ ) . '/pattern.php';
$contents = ob_get_contents();
ob_end_clean();

register_block_pattern(
	'RJE-pattern/' . basename( __DIR__ ),
	array(
		'title'      => $pattern_title,
		'content'    => $contents,
		'categories' => $pattern_category,
	)
);