<?php
/**
 * Plugin Name: Habakiri Copyright Manager
 * Plugin URI: https://github.com/inc2734/habakiri-copyright-manager
 * Description: You can setting copyright text on Habakiri theme.
 * Version: 1.0.1
 * Author: Takashi Kitajima
 * Author URI: http://2inc.org
 * Created : June 19, 2015
 * Modified: September 14, 2015
 * Text Domain: habakiri-copyright-manager
 * Domain Path: /languages/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
include_once( plugin_dir_path( __FILE__ ) . 'classes/class.config.php' );
include_once( plugin_dir_path( __FILE__ ) . 'classes/options-habakiri-copyright-manager.php' );
include_once( plugin_dir_path( __FILE__ ) . 'classes/class.github-updater.php' );
new Habakiri_Plugin_GitHub_Updater( 'habakiri-copyright-manager', __FILE__, 'inc2734' );

class Habakiri_Copyright_Manager {

	/**
	 * __construct
	 */
	public function __construct() {
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'init'          , array( $this, 'init' ) );
	}

	/**
	 * アンインストール時の処理
	 */
	public static function uninstall() {
		delete_option( Habakiri_Copyright_Manager_Config::NAME );
	}

	/**
	 * 言語ファイルの読み込み
	 */
	public function plugins_loaded() {
		load_plugin_textdomain(
			Habakiri_Copyright_Manager_Config::DOMAIN,
			false,
			basename( dirname( __FILE__ ) ) . '/languages'
		);
	}

	public function init() {
		if ( is_admin() ) {
			$Options = new Habakiri_Copyright_Manager_Options();
			add_action( 'admin_menu', array( $Options, 'admin_menu' ) );
			add_action( 'admin_init', array( $Options, 'register_setting' ) );
		}

		add_filter(
			'habakiri_copyright',
			array( $this, 'habakiri_copyright' )
		);
	}

	/**
	 * 保存された Copyright を返す
	 *
	 * @param string $copyright
	 */
	public function habakiri_copyright( $copyright ) {
		return esc_html( Habakiri_Copyright_Manager_Options::get( 'copyright' ) );
	}
}

$theme = wp_get_theme();
if ( $theme->template === 'habakiri' ) {
	$Habakiri_Share_Buttons = new Habakiri_Copyright_Manager();
}
