<?php

class Smashing_Fields_Plugin {
    public function __construct() {
        // Hook into the admin menu
        add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );

        // Add Settings and Fields
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );
    }

    public function create_plugin_settings_page() {
        // Add the menu item and page
        $page_title = 'Test Plugin Settings Page';
        $menu_title = 'Test Plugin';
        $capability = 'manage_options';
        $slug = 'test_plugin_settings_page';
        $callback = array( $this, 'plugin_settings_page_content' );
        $icon = 'dashicons-admin-plugins';
        $position = 100;

        add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }

    public function plugin_settings_page_content() {?>
        <div class="wrap">
            <h2>Test Plugin Settings Page</h2><?php
            if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ){
                $this->admin_notice();
            } ?>
            <form method="POST" action="options.php">
                <?php
                settings_fields( 'test_plugin_settings_page' );
                do_settings_sections( 'test_plugin_settings_page' );
                submit_button();
                ?>
            </form>
        </div> <?php
    }

    public function admin_notice() { ?>
        <div class="notice notice-success is-dismissible">
            <p>Your settings have been updated!</p>
        </div><?php
    }

    public function setup_sections() {
        add_settings_section( 'our_first_section', 'Set the slider view for the featured category', array( $this, 'section_callback' ), 'test_plugin_settings_page' );
        add_settings_section( 'our_second_section', 'Set the number of items to display', array( $this, 'section_callback' ), 'test_plugin_settings_page' );
    }

    public function section_callback( $arguments ) {
        switch( $arguments['id'] ){
            case 'our_first_section':
            case 'our_second_section':
                echo '';
                break;
        }
    }

    public function setup_fields() {
        $fields = array(
            array(
                'uid' => 'featured_category_slider',
                'label' => 'Do you want to display slider?',
                'section' => 'our_first_section',
                'type' => 'select',
                'options' => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'default' => 'no'
            ),
            array(
                'uid' => 'featured_category_slider_number_posts',
                'label' => 'The default number of displayed items is 2',
                'section' => 'our_second_section',
                'type' => 'radio',
                'options' => array(
                    'two' => '2',
                    'three' => '3',
                    'four' => '4',
                ),
                    'default' => array('two')
            ),
        );
        foreach( $fields as $field ){

            add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'test_plugin_settings_page', $field['section'], $field );
            register_setting( 'test_plugin_settings_page', $field['uid'] );
        }
    }

    public function field_callback( $arguments ) {
        $value = get_option( $arguments['uid'] );

        if( ! $value ) {
            $value = $arguments['default'];
        }

        switch( $arguments['type'] ){
            case 'select':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
                }
                break;
            case 'radio':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value[ array_search( $key, $value, true ) ], $key, false ), $label, $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
        }
    }

}
new Smashing_Fields_Plugin();