<?php
/**
 * Metabox field Type
 *
 * @package Qusq_Lite
 */

$args = array(
	'wpautop' => true,
	'textarea_name' => $id,
);
wp_editor( $value, $wp_editor_id, $args );
