<?php
/**
 * Metabox field Type
 *
 * @package Qusq_Lite
 */

?>
<select name="<?php echo esc_attr( $id ); ?>" id="<?php echo esc_attr( $id ); ?>">
	<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) : ?>
		<option <?php selected( $value, $sidebar['id'] )?> value="<?php echo esc_attr( $sidebar['id'] ); ?>"><?php echo esc_attr( $sidebar['name'] ); ?></option>
	<?php endforeach ?>
</select>
