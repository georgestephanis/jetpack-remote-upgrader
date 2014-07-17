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
			'locale'  => get_locale(),
		);
		$args = wp_parse_args( $args, $defaults );
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

		require_once( ABSPATH . 'wp-admin/includes/update.php' );
		$update = find_core_update( $args['version'], $args['locale'] );

		if ( $update ) {
			$target_dir = ABSPATH;

			if ( ! $this->can_install_or_upgrade( $target_dir ) ) {
				$this->add_message( __( 'Can\'t upgrade. See log for why.' ) );
				return false;
			}

			$skin     = new Jetpack_Remote_Upgrader_Skin();
			$upgrader = new Core_Upgrader( $skin );
			$result   = $upgrader->upgrade( $update );

			if ( is_wp_error( $result ) ) {
				if ( $errors = $result->get_error_messages() ) {
					foreach ( $errors as $error_message ) {
						$this->add_message( $error_message );
					}
				}
				return false;
			}
		} else {
			$this->add_message( sprintf( __( '`%s` did not find an update for core.' ), "find_core_update( '{$args['version']}', '{$args['locale']}' )" ) );
			return false;
		}

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
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

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
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

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
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

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
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

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
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

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
		$this->add_message( __FUNCTION__ );
		$this->add_message( '$args = ' . json_encode( $args ) );

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
	 * Whether the Jetpack Upgrader is disabled.
	 *
	 * @param $path string The directory or file
	 * @return boolean
	 */
	public static function can_install_or_upgrade( $path ) {
		$can = true;

		if ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS ) {
			$this->add_message( __( 'DISALLOW_FILE_MODS is set, so we cannot modify the filesystem.' ) );
			$can = false;
		}

		if ( $vcs = self::is_vcs_checkout( $path ) ) {
			$this->add_message( sprintf( __( '%1$s is under %2$s version control.' ), $path, $vcs ) );
			$can = false;
		}

		$skin = new Jetpack_Remote_Upgrader_Skin( array( 'context' => $path ) );
		if ( ! $skin->request_filesystem_credentials() ) {
			$this->add_message( sprintf( __( '`%1$s` returned no credentials for `%2$s`' ), 'request_filesystem_credentials()', $path ) );
			$can = false;
		}

		return $can;
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
