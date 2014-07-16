<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

/**
 * Extending Automatic_Upgrader_Skin instead of using it directly, so that
 * we can more easily modify/override things later on if needed.
 */
class Jetpack_Remote_Upgrader_Skin extends Automatic_Upgrader_Skin {
	
}

class Jetpack_Remote_Upgrader {

	/**
	 * Upgrade Core
	 */
	public function upgrade_core( $args = array() ) {
		return true;
	}

	/**
	 * Install a Plugin
	 */
	public function install_plugin( $args = array() ) {
		return true;
	}

	/**
	 * Upgrade a Plugin
	 */
	public function upgrade_plugin( $args = array() ) {
		return true;
	}

	/**
	 * Uninstall a Plugin
	 */
	public function uninstall_plugin( $args = array() ) {
		return true;
	}

	/**
	 * Install a Theme
	 */
	public function install_theme( $args = array() ) {
		return true;
	}

	/**
	 * Upgrade a Theme
	 */
	public function upgrade_theme( $args = array() ) {
		return true;
	}

	/**
	 * Uninstall a Theme
	 */
	public function uninstall_theme( $args = array() ) {
		return true;
	}

}
