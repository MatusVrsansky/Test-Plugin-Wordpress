<?php
/**
 * Metabox field Type
 *
 * @package Qusq_Lite
 */

$random_select = false;
$i = 0;

if ( empty( $value ) || '' === $value ) {
	$random_select = rand( 0, count( $options ) - 1 );
}
?>
<?php
foreach ( $options as $opt_value => $opt_name ) {

	if ( false !== $random_select && $i === $random_select ) {
		$value = $opt_value;
	} ?>
	<label>
		<input type="radio" name="<?php echo esc_attr( $id ); ?>" id="<?php echo esc_attr( $id ); ?>_<?php echo esc_attr( $opt_value ); ?>" value="<?php echo esc_attr( $opt_value ); ?>" <?php checked( $value, $opt_value )?> />
		<?php echo esc_html( $opt_name ) . '&nbsp;&nbsp;'?>
	</label>
	<?php $i++; ?>
<?php } ?>
