<?php
/**
 * Untappd Shortcodes
 * @author kraftbj
 *
 * [untappd-menu location="123" theme="123"]
 * @since  4.1.0
 * @param location int Location ID for the Untappd venue. Required.
 * @param theme    int Theme ID for the Untappd menu. Required.
 */

class Jetpack_Untappd {

	function __construct() {
		add_action( 'init', array( $this, 'action_init' ) );
	}

	function action_init() {
		add_shortcode( 'untappd-menu', array( $this, 'menu_shortcode' ) );
	}

	/**
	 * [untappd-menu] shortcode.
	 *
	 */
	static function menu_shortcode( $atts, $content = '' ) {
		// Let's bail if we don't have location or theme.
		if ( ! isset( $atts['location'] ) || ! isset( $atts['theme'] ) ) {
			if ( current_user_can( 'edit_posts') ){
				return __( 'No location or theme ID provided in the untappd-menu shortcode.', 'jetpack' );
			}
			return;
		}

		// Let's apply some defaults.
		$atts = shortcode_atts( array(
			'location' => '',
			'theme'    => '',
		), $atts, 'untappd-menu' );

		// We're going to clean the user input.
		$atts = self::santize_atts( $atts );

		static $untappd_menu = 1;

		$html  = '<div id="menu-container-untappd-' . $untappd_menu . '" class="untappd-menu"></div>';
		$html .= '<script type="text/javascript">' . PHP_EOL;
		$html .= '!function(e,n){var t=document.createElement("script"),a=document.getElementsByTagName("script")[0];' . PHP_EOL;
		$html .= 't.async=1,a.parentNode.insertBefore(t,a),t.onload=t.onreadystatechange=function(e,a){' . PHP_EOL;
		$html .= '(a||!t.readyState||/loaded|complete/.test(t.readyState))&&(t.onload=t.onreadystatechange=null,t=void 0,a||n&&n())},' . PHP_EOL;
		$html .= 't.src=e}("https://embed-menu-preloader.untappdapi.com/embed-menu-preloader.min.js",function(){' . PHP_EOL;
		$html .= 'PreloadEmbedMenu( "menu-container-untappd-' . $untappd_menu . '",' . $atts["location"] . ',' . $atts["theme"] . ' )});' . PHP_EOL;
		$html .= '</script>';

		$untappd_menu++;

		return $html;
	}

	/**
	 * Santize the atts
	 *
	 * @return array
	 */
	static function santize_atts( $atts = null ) {
		if ( ! is_array( $atts ) ){
			return;
		}

		foreach ( $atts as $k => $v ){
			$atts['k'] = intval( $v );
		}

		return $atts;
	}
}

new Jetpack_Untappd();