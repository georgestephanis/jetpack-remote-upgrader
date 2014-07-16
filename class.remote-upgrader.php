<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

/**
 * Extending Automatic_Upgrader_Skin instead of using it directly, so that
 * we can more easily modify/override things later on if needed.
 */
class Jetpack_Remote_Upgrader_Skin extends Automatic_Upgrader_Skin {
	
}

class Jetpack_Remote_Upgrader {

	var $messages;

	/**
	 * Upgrade Core
	 */
	public function upgrade_core( $args = array() ) {
		$defaults = array(
			'version' => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Install a Plugin
	 */
	public function install_plugin( $args = array() ) {
		$defaults = array(
			'slug'         => null,
			'version'      => null,
			'download_url' => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Upgrade a Plugin
	 */
	public function upgrade_plugin( $args = array() ) {
		$defaults = array(
			'slug'         => null,
			'version'      => null,
			'download_url' => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Uninstall a Plugin
	 */
	public function uninstall_plugin( $args = array() ) {
		$defaults = array(
			'slug'    => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Install a Theme
	 */
	public function install_theme( $args = array() ) {
		$defaults = array(
			'slug'         => null,
			'version'      => null,
			'download_url' => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Upgrade a Theme
	 */
	public function upgrade_theme( $args = array() ) {
		$defaults = array(
			'slug'         => null,
			'version'      => null,
			'download_url' => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Uninstall a Theme
	 */
	public function uninstall_theme( $args = array() ) {
		$defaults = array(
			'slug'    => null,
		);
		$args = wp_parse_args( $args, $defaults );

		return true;
	}

	/**
	 * Clears all stored messages.
	 */
	public function clear_messages() {
		$this->messages = array();
		return $this;
	}

	/**
	 * Adds a new message to the internal log.
	 */
	public function add_message( $message ) {
		$this->messages[] = $message;
		return $this;
	}

	/**
	 * Get the internal message log.
	 */
	public function get_messages() {
		return $this->messages;
	}

	/**
	 * When upgrading manually, we don't care about VCS in parent
	 * directories, as the user explicitly said to upgrade.
	 */
	public static function is_vcs_checkout( $path ) {
		$vcs_dirs = array(
			'.svn',
			'.git',
			'.hg',
			'.bzr',
		);

		if ( @is_file( $path ) ) {
			$path = dirname( $path );
		}

		foreach ( $vcs_dirs as $vcs_dir ) {
			if ( @is_dir( rtrim( $path, '\\/' ) . "/$vcs_dir" ) ) {
				return $vcs_dir;
			}
		}

		return false;
	}

}
