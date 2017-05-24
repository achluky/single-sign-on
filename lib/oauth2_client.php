<?php 

class Oauth2_client {

    private static $_instance;
    public $client_id       = 'OAUTH_CLIENT_ID'; 
    public $client_secret   = 'OAUTH_CLIENT_SECREET'; 
    public $redirect_uri    = 'APP_CLIENT_URL_CALLBACK';
    public $scope    		= 'SCOPE';
    
    public static function getInstance() {
        if(!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct(){
    }

    public function user_authentication( $provider_auth_uri, $more_args = array(), $return_uri = false ){
        $args['client_id']      = $this->client_id;
        $args['redirect_uri']   = $this->redirect_uri;
        if( ! empty($more_args) )
            foreach($more_args as $key => $val)
                $args[$key] = $val;
        $url = $provider_auth_uri.'?'.http_build_query($args);

        if($return_uri)
            return $url;
        header('Location:'.$url);
        exit;
    }

    public function get_access_token( $provider_token_uri, $code, $http_method = 'GET', $more_args = array() ){
        $args['client_id']      = $this->client_id;
        $args['client_secret']  = $this->client_secret;
        $args['code']           = $code;
        $args['redirect_uri']   = $this->redirect_uri;

        if( ! empty($more_args) )
            foreach($more_args as $key => $val)
                $args[$key] = $val;
        $url = $provider_token_uri.'?'.http_build_query($args);
        return array('url'=>$url, 'args'=>$args);
    }

    public function access_user_resources( $provider_uri, $acces_token, $http_method = 'GET', $more_args = array() ){

        $args['access_token']  = $acces_token;
        $args['scope']  = $this->scope;

        if( ! empty($more_args) )
            foreach($more_args as $key => $val)
                $args[$key] = $val;

        $url = $provider_uri.'?'.http_build_query($args);
        // echo $url;
        return $this->CI->rest->send_request($url, $http_method, $args);
    }
}



$oauth = oauth2_client::getInstance();
