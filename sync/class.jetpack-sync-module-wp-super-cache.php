<?php

class Jetpack_Sync_Module_WP_Super_Cache extends Jetpack_Sync_Module {

	static $wp_super_cache_constants = array(
		'WPLOCKDOWN',
		'WPSC_DISABLE_COMPRESSION',
		'WPSC_DISABLE_LOCKING',
		'WPSC_DISABLE_HTACCESS_UPDATE',
		'ADVANCEDCACHEPROBLEM',
	);

	static $wp_super_cache_callables = array(
		'wp_super_cache_globals' => array( 'Jetpack_Sync_Module_WP_Super_Cache', 'get_wp_super_cache_globals' ),
	);

	public function name() {
		return 'wp-super-cache';
	}

	public static function get_wp_super_cache_globals() {
		global $wp_cache_mod_rewrite;
		global $cache_enabled;
		global $super_cache_enabled;
		global $ossdlcdn;
		global $cache_rebuild_files;
		global $wp_cache_mobile;
		global $wp_super_cache_late_init;
		global $wp_cache_anon_only;
		global $wp_cache_not_logged_in;
		global $wp_cache_clear_on_post_edit;
		global $wp_cache_mobile_enabled;
		global $wp_super_cache_debug;
		global $cache_max_time;
		global $wp_cache_refresh_single_only;
		global $wp_cache_mfunc_enabled;
		global $wp_supercache_304;
		global $wp_cache_no_cache_for_get;
		global $wp_cache_mutex_disabled;
		global $cache_jetpack;
		global $cache_domain_mapping;

		return array(
			'wp_cache_mod_rewrite' => $wp_cache_mod_rewrite,
			'cache_enabled' => $cache_enabled,
			'super_cache_enabled' => $super_cache_enabled,
			'ossdlcdn' => $ossdlcdn,
			'cache_rebuild_files' => $cache_rebuild_files,
			'wp_cache_mobile' => $wp_cache_mobile,
			'wp_super_cache_late_init' => $wp_super_cache_late_init,
			'wp_cache_anon_only' => $wp_cache_anon_only,
			'wp_cache_not_logged_in' => $wp_cache_not_logged_in,
			'wp_cache_clear_on_post_edit' => $wp_cache_clear_on_post_edit,
			'wp_cache_mobile_enabled' => $wp_cache_mobile_enabled,
			'wp_super_cache_debug' => $wp_super_cache_debug,
			'cache_max_time' => $cache_max_time,
			'wp_cache_refresh_single_only' => $wp_cache_refresh_single_only,
			'wp_cache_mfunc_enabled' => $wp_cache_mfunc_enabled,
			'wp_supercache_304' => $wp_supercache_304,
			'wp_cache_no_cache_for_get' => $wp_cache_no_cache_for_get,
			'wp_cache_mutex_disabled' => $wp_cache_mutex_disabled,
			'cache_jetpack' => $cache_jetpack,
			'cache_domain_mapping' => $cache_domain_mapping,
		);
	}

	public function init_listeners( $callable ) {
		$this->sync_wp_super_cache();
	}

	public function init_full_sync_listeners( $callable ) {
		$this->sync_wp_super_cache();
	}

	public function sync_wp_super_cache() {
		add_filter( 'jetpack_sync_constants_whitelist', array( $this, 'add_wp_super_cache_constants_whitelist' ), 10 );
		add_filter( 'jetpack_sync_callable_whitelist', array( $this, 'add_wp_super_cache_callable_whitelist' ), 10 );
	}

	public function add_wp_super_cache_constants_whitelist( $list ) {
		return array_merge( $list, self::$wp_super_cache_constants );
	}

	public function add_wp_super_cache_callable_whitelist( $list ) {
		return array_merge( $list, self::$wp_super_cache_callables );
	}
}