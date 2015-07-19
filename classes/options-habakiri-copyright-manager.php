<?php
/**
 * Name       : Habakiri_Copyright_Manager_Options
 * Version    : 1.0.0
 * Author     : Takashi Kitajima
 * Author URI : http://2inc.org
 * Create     : July 19, 2015
 * Modified   :
 * License    : GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
class Habakiri_Copyright_Manager_Options {

	/**
	 * 管理メニューに追加
	 */
	public function admin_menu() {
		$hook = add_options_page(
			__( 'Copyright Setting', 'habakiri-copyright-manager' ),
			__( 'Copyright Setting', 'habakiri-copyright-manager' ),
			'manage_options',
			basename( __FILE__ ),
			array( $this, 'display' )
		);
	}

	/**
	 * name 属性が habakiri_copyright_manager の項目だけ許可。
	 * さらに $this->valdidate でフィルタリング
	 */
	public function register_setting() {
		register_setting(
			Habakiri_Copyright_Manager_Config::NAME . '-group',
			Habakiri_Copyright_Manager_Config::NAME,
			array( $this, 'validate' )
		);
	}

	/**
	 * バリデーション
	 *
	 * @param arary $values 送信された全データ
	 * @return array
	 */
	public function validate( $values ) {
		return $values;
	}

	/**
	 * 管理画面を表示
	 */
	public function display() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Copyright Setting', 'habakiri-copyright-manager' ); ?></h2>

			<form method="post" action="options.php">
				<?php settings_fields( Habakiri_Copyright_Manager_Config::NAME . '-group' ); ?>
				<table class="form-table">
					<tr>
						<th><?php esc_html_e( 'Copyright text', 'habakiri-copyright-manager' ); ?></th>
						<td>
							<input type="text" name="<?php echo esc_attr( Habakiri_Copyright_Manager_Config::NAME ); ?>[copyright]" value="<?php echo esc_attr( self::get( 'copyright' ) ); ?>" class="regular-text" />
							<p class="description">
								<?php esc_html_e( 'html is escaped.', 'habakiri-copyright-manager' ); ?>
							</p>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'habakiri-copyright-manager' ) ?>" />
				</p>
			</form>
		<!-- end .wrap --></div>
		<?php
	}

	/**
	 * 設定値を返す
	 *
	 * @param string $key
	 * @return null|string|array
	 */
	public static function get( $key ) {
		$option = get_option( Habakiri_Copyright_Manager_Config::NAME );
		if ( is_array( $option ) && array_key_exists( $key, $option ) ) {
			return $option[$key];
		}
	}
}
