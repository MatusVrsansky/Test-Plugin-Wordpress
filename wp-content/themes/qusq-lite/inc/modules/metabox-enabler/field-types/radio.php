<?php
/**
 * Metabox field Type
 *
 * @package Qusq_Lite
 */

?>
<span id="<?php echo esc_attr( $id ); ?>">

	<?php
	// Ensure first item is selected if value is empty.
	if ( '' === $value && is_array( $options ) && ! empty( $options ) ) {
		$keys = array_keys( $options );
		$value = $keys[0];
	}
	?>

	<?php foreach ( $options as $opt_value => $opt_name ) : ?>
		<label>
			<input type="radio" name="<?php echo esc_attr( $id ); ?>" id="<?php echo esc_attr( $id ); ?>_<?php echo esc_attr( $opt_value ); ?>" value="<?php echo esc_attr( $opt_value ); ?>" <?php checked( $value, $opt_value )?> />
			<?php echo esc_html( $opt_name ) . '&nbsp;&nbsp;'?>
		</label>
	<?php endforeach ?>
</span>
