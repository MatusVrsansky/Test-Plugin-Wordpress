<?php
/**
 * Metabox field Type
 *
 * @package Qusq_Lite
 */

$param['type'] = 'ish_color_selector';
$param['value'] = array(
	esc_html__( 'No Color', 'qusq-lite' ) => '',
) + qusq_lite_get_theme_colors_array();


$param_line = '';
$param_line .= '<div class="' . $param['type'] . '_container ish_btnlist_container ish_meta_param">';
$param_line .= '<input name="' . $id . '" id="' . esc_attr( $id ) . '" class="' . $id . ' ' . $param['type'] . '" type="hidden" value="' . $value . '"/>';
$param_line .= '<ul class="' . $param['type'] . '_list ish_btnlist_list">';

foreach ( $param['value'] as $key => $val ) {
	if ( '' === $val ) {
		$class = 'ish-icon-noneselected';
		$data_val = '';
	} else {
		$class = 'color' . $key;
		$data_val = 'color' . $key;
	}

	if ( $value === $data_val ) {
		$param_line .= '<li class="active">';
	} else {
		$param_line .= '<li>';
	}

	$text = ( 'advanced' === $val || '' === $val ) ? 'X' : $key;
	$class = ( 'advanced' === $val ) ? ' ish-icon-cog' : $class;

	$param_line .= '<a class="' . $param['type'] . '_item ish_btnlist_item ' . $class . '" data-ish-value="' . $data_val . '" href="#" title="' . esc_attr__( 'Theme Color', 'qusq-lite' ) . ' ' . esc_attr( $key ) . ' - ' . esc_attr( $val ) . '"><span>' . $text . '</span></a></li>';
}

$param_line .= '</ul>';
$param_line .= '</div>';

// Do not forget to echo the variable.
echo wp_kses_post( apply_filters( 'qusq_lite_meta_color_selector_output', $param_line ) );
