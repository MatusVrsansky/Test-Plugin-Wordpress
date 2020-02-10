<?php
/**
 * Metabox field Type
 *
 * @package Qusq_Lite
 */

?>
<select name="<?php echo esc_attr( $id ); ?>" id="<?php echo esc_attr( $id ); ?>">
	<option <?php selected( $value, '' )?> value=""><?php echo esc_html__( 'Default setting', 'qusq-lite' ); ?></option>
	<?php
	$menus = get_terms(
		'nav_menu',
		array(
			'hide_empty' => false,
			'taxonomy' => 'tax_nav_menu',
		)
	);
	foreach ( $menus as $menu ) {
		?>
		<option <?php selected( $value, $menu->term_id )?> value="<?php echo esc_attr( $menu->term_id ); ?>"><?php echo esc_html( $menu->name ); ?></option>
	<?php }	?>
</select>
