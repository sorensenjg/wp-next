<?php

class WP_Next_Api { 
	
	private $plugin_name;
	private $version; 

	public $api_namespace = 'wp-next/';
	public $api_version = 'v1'; 

	protected static $settings = [
		'wp_next_frontend_url'	=> 'http://localhost:3000',
		'wp_next_preview_token'	=> '',
	];

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version; 

		add_action( 'admin_init', [ $this, 'register_settings' ] ); 

	} 

	public function register_routes() {

		$namespace = $this->api_namespace . $this->api_version;  

		register_rest_route( $namespace, '/settings', array(
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_settings' ),
				'permission_callback' => array( $this, 'get_settings_permission' )
			),
		) );

		register_rest_route( $namespace, '/setting/(?P<slug>(.*)+)', array( 
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_setting' ),
				'permission_callback' => array( $this, 'get_settings_permission' )
			),
			array(
				'methods'  => WP_REST_Server::EDITABLE,
				'callback' => array( $this, 'update_setting' ), 
				'permission_callback' => array( $this, 'get_settings_permission' )
			),
		) );

	}

	public function get_settings_permission() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to manage options.', $this->plugin_name ), array( 'status' => 401 ) );
		}

		return true;

	}

	
	public function register_settings() {

		foreach ( self::$settings as $key => $value ){
			add_option( $key , $value );
		}
		
		// get_option( 'wp_next_frontend_url' );
		// update_option( 'wp_next_frontend_url' , 'http://localhost:3000' );
		// delete_option( 'wp_next_frontend_url' );

	}

	public function generate_preview_token( $key ) {
		
		if( $key == 'wp_next_preview_token' ) {
			$saved = get_option( $key, [] );  

			if( is_array( $saved ) || empty( $saved ) ) {

				$hash = bin2hex( random_bytes(20) );
				update_option( $key, $hash );

			}

		}

	}

	public function get_settings( WP_REST_Request $request ) {

		$all_saved = new stdClass();

		foreach ( self::$settings as $key => $value ) {
			$saved = get_option( $key, [] );   

			$this->generate_preview_token( $key );

			if( ! is_array( $saved ) || ! empty( $saved ) ) {
				$all_saved->$key = $saved; 
			} else {
				$all_saved->$key = $value;
			}
		}

		return wp_parse_args( $all_saved, self::$settings );

	}

	public function get_setting( WP_REST_Request $request ) {

		$params = $request->get_params();

		if ( ! isset( $params['slug'] ) || empty( $params['slug'] ) ) {
			return new WP_Error( 'no-param', __( 'No slug param' ) );
		}

		$converted_slug = $this->_convert_slug( $params['slug'] );

		$opt_value = get_site_option( $converted_slug );

		if ( ! $opt_value ) {
			return new WP_Error( 'option-not-found', __( 'Option not found' ) );
		}

		return $opt_value;

	}

	public function update_setting( WP_REST_Request $request ) {

		$params = $request->get_params();

		if ( ! isset( $params['slug'] ) || empty( $params['slug'] ) ) {
			return new WP_Error( 'no-param', __( 'No slug param' ) );
		}

		$body = $request->get_body();

		if ( empty( $body ) ) {
			return new WP_Error( 'no-body', __( 'Request body empty' ) );
		}

		$decoded_body = json_decode( $body );

		if ( $decoded_body ) {
			if ( isset( $decoded_body->key, $decoded_body->value ) ) {

				if ( ! get_site_option( $decoded_body->key ) ) {
					return false;
				}

				if ( update_option( $decoded_body->key, $decoded_body->value ) ) {
					return true;
				}
			}
		}

		return false;

	}

	public function isStringEmpty( $string ) {

		$string = trim( $string );
		
		if( isset( $string ) === true && $string === '') {
			return true;
		} else {
			return false;
		}
	
	}

	public function generateRandomString( $length = 10 ) { 
		
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		return $randomString;

	}

	public function console_log( $output, $with_script_tags = true ) {

		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
		
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}

		echo $js_code; 

	}

}
