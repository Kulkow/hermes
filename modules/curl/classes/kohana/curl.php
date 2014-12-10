<?php defined('SYSPATH') or die('No direct script access.');

   /**
    *   Curl wrapper ...
    *
    *   Usage:
    *
    *   \Curl::Init(array
    *   (
                'timeout'   =>  20,
    *           'redirect'  =>  2,
    *           'agent'     =>  '...',
    *           'referer'   =>  '...',
    *           'charset'   =>  'UTF-8',
    *           'encoding'  =>  'gzip/deflate',
    *   ));
    *
    *   $content = \Curl::get( 'http://site.com/' );
    *
    *   $response = \Curl::getResponse();
    *
    *   -----------------------------------------
    *
    *   @author nick-on
    *   @version 1.0
    */

    class Kohana_Curl  {
        private static $conn        = false;

        private static $ready       = false;

        private static $config      = array ();

        public static $request      = array ();

        public static $response     = array ();

        public static $headers      = array ();

        public static $cookies      = array ();

        public static $content      = '';

        public static $raw          = '';

        public static $https        = false;

        private static $request_count = 0;

        /**
         *   Curl init ...
         *
         *   @param array $custom_config
         *   @return bool
         */

        public static function Init ( $custom_config = array () )
        {
            self::$conn = curl_init();

            if ( ! is_resource( self::$conn ))
            {
                return false;
            }

            $config = array
            (
                'timeout'       =>  20,
                'redirect'      =>  3,
                'agent'         =>  'Mozilla/5.0 (Windows NT 5.1; rv:12.0) Gecko/20100101 Firefox/12.0',
                'referer'       =>  '',
                'charset'       =>  'UTF-8',
                'encoding'      =>  'gzip/deflate',
            );

            if ( is_array ( $custom_config ) AND count ( $custom_config ) != 0 )
            {
                foreach ( $custom_config as $name => $value )
                {
                    $config[ $name ] = $value;
                }
            }

            self::$config = $config;

            curl_setopt_array( self::$conn, array
            (
                CURLOPT_HEADER              =>  true,
                CURLOPT_AUTOREFERER         =>  true,
                CURLOPT_RETURNTRANSFER      =>  true,
                CURLOPT_UNRESTRICTED_AUTH   =>  true,
                CURLINFO_HEADER_OUT         =>  true,
                CURLOPT_COOKIESESSION       =>  true,
                CURLOPT_FORBID_REUSE        =>  true,
                CURLOPT_FRESH_CONNECT       =>  true,
                CURLOPT_FOLLOWLOCATION      =>  true,
                CURLOPT_HTTP_VERSION        =>  CURL_HTTP_VERSION_1_1,
                CURLOPT_TIMEOUT             =>  $config[ 'timeout' ],
                CURLOPT_CONNECTTIMEOUT      =>  $config[ 'timeout' ],
                CURLOPT_MAXREDIRS           =>  $config[ 'redirect' ],
                CURLOPT_ENCODING            =>  $config[ 'encoding' ],
                CURLOPT_REFERER             =>  $config[ 'referer' ],
                CURLOPT_USERAGENT           =>  $config[ 'agent' ],
                CURLOPT_VERBOSE             =>  1,
            ));
            self::$ready = true;
            return true;
        }

        /**
         *   Curl close ...
         */

        public static function close ()
        {
            if ( self::$conn )
            {
                curl_close( self::$conn );
            }
        }

        /**
         *   Set request headers ...
         *
         *   @param string|array $name
         *   @param bool $value
         */

        public static function setHeader ( $name, $value = false )
        {
            if (is_array($name))
            {
                foreach ( $name as $key => $value )
                {
                    self::setHeader( $key, $value );
                }
            }
            else self::$headers[ $name ] = $value;
        }

        /**
         *   Set request cookies ...
         *
         *   @param string|array $name
         *   @param bool $value
         */

        public static function setCookie($name,$value = false )
        {
            if (is_array($name))
            {
                foreach($name as $key => $value)
                {
                    self::setCookie($key, $value);
                }
            }
            else self::$cookies[$name] = $value;
        }

        /**
         *   Set cookie file ...
         *
         *   @param $file_name
         *   @return bool
         */
        public static function setCookieFile ($file_name)
        {
            if (!self::$ready)
            {
                return false;
            }

            curl_setopt_array(self::$conn,array
            (
                CURLOPT_COOKIEJAR   =>  $file_name,
                CURLOPT_COOKIEFILE  =>  $file_name,
            ));
        }

        /**
         *   Set proxy ...
         *
         *   @param $host
         *   @param $port
         *   @param bool $user
         *   @param bool $password
         *   @param int $proxy_type  HTTP_PROXY_HTTP|HTTP_PROXY_SOCK4|HTTP_PROXY_SOCK5
         *   @return bool
         */

        public static function setProxy ( $host, $port, $user = false, $password = false, $proxy_type = HTTP_PROXY_HTTP )
        {
            if ( ! self::$ready )
            {
                return false;
            }

            curl_setopt_array( self::$conn, array
            (
                CURLOPT_PROXY               =>  $host . ':' . $port,
                CURLOPT_PROXYPORT           =>  $port,
                CURLOPT_HTTPPROXYTUNNEL     =>  true,
            ));

            switch ( $proxy_type )
            {
                case HTTP_PROXY_SOCKS5 :
                    curl_setopt( self::$conn, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5 );
                    break;
                case HTTP_PROXY_SOCKS4 :
                    curl_setopt( self::$conn, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4 );
                    break;

                case HTTP_PROXY_HTTP :
                    curl_setopt( self::$conn, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
                    break;

               default :
                    return false;
                    break;
            }

            if ( $user != '' AND $password != '' )
            {
                curl_setopt_array ( self::$conn, array
                (
                    CURLOPT_PROXYAUTH       =>  $user . ':' . $password,
                    CURLOPT_PROXYUSERPWD    =>  $user . ':' . $password,
                ));
            }

            return true;
        }

        /**
         *   Set basic authorization data ...
         *
         *   @param $user
         *   @param $password
         *   @return bool
         */
        public static function setAuth ( $user, $password )
        {
            if (! self::$ready)
            {
                return false;
            }
            if (trim($user) == '' OR trim($password) == '')
            {
                return false;
            }

            curl_setopt( self::$conn, CURLOPT_USERPWD, $user . ':' . $password );

            return true;
        }

        /**
         *   Make request ...
         *
         *   @param $url
         *   @param bool $no_body
         *   @return bool|mixed
         */

        private static function request($url,$no_body = false)
        {
            if (!self::$ready)
            {
                return false;
            }

            self::$content      = '';
            self::$raw          = '';
            self::$response     = array ();
            self::$https        = false;
            curl_setopt( self::$conn, CURLOPT_NOBODY, $no_body );
            // Set HTTPS vars ...
            if ( stristr( $url, 'https'))
            {
                curl_setopt_array ( self::$conn, array
                (
                    CURLOPT_SSLVERSION      =>  3,
                    CURLOPT_SSL_VERIFYPEER  =>  false,
                    CURLOPT_SSL_VERIFYHOST  =>  false,
                ));

                self::$https = true;
            }

            // Set headers ...

            if (count(self::$headers) != 0)
            {
                $headers = array ();

                foreach (self::$headers as $name => $value)
                {
                    $headers[] = $name.': '.$value;
                }
                curl_setopt( self::$conn, CURLOPT_HTTPHEADER, $headers );
            }

            // Set cookies ...

            if ( count ( self::$cookies ) != 0 )
            {
                $cookies = array ();

                foreach ( self::$cookies as $name => $value )
                {
                    $cookies[] = $name . ': ' . $value;
                }

                $cookies = implode( '; ', $cookies );

                curl_setopt( self::$conn, CURLOPT_COOKIE, $cookies );
            }

            // Set url ...

            curl_setopt ( self::$conn, CURLOPT_URL, $url );

            // Get response ...

            $response = curl_exec( self::$conn );

            self::$request = curl_getinfo( self::$conn, CURLINFO_HEADER_OUT );

            if ( $response )
            {
                $sections      = explode ( "\r\n\r\n", $response, self::$request_count + 2 );

                self::$content = array_pop( $sections );

                self::$raw     = $response;

                $request_count = self::$request_count + 1;

                for ( $pos = 0; $pos < $request_count; $pos ++ )
                {
                    $headers = explode ( "\r\n", $sections[ $pos ] );

                    list
                        (
                        self::$response[ $pos ][ 'http' ][ 'Version' ],
                        self::$response[ $pos ][ 'http' ][ 'Status' ],
                        self::$response[ $pos ][ 'http' ][ 'Title' ],

                        ) = explode( ' ', array_shift( $headers ), 3 );

                    foreach ( $headers as $header )
                    {
                        list ( $name, $value ) = explode( ': ', $header );

                        // Get response cookies ...
                        if ( $name == 'Set-Cookie' )
                        {
                            $header = str_replace( 'Set-Cookie: ', '', $header );
                            $params = explode ( '; ', $header );

                            list ( $name, $value ) = explode( '=', array_shift( $params ));

                            $value = $value != 'deleted' ? $value : '';

                            self::$response[ $pos ][ 'cookies' ][ $name ] = $value;
                        }
                        // Get response headers ...
                        else self::$response[ $pos ][ 'headers' ][ $name ] = $value;
                    }
                }

                return self::$content;
            }
            else return false;
        }

        /**
         *   Make GET request ...
         *
         *   @param $url
         *   @return bool|mixed
         */

        public static function get($url)
        {
            return self::request( $url );
        }

        /**
         *   getJSON AJAX request
         *
         *   @param $url
         *   @return bool|mixed
         */

        public static function getJSON ( $url )
        {
            self::setHeader( array
                (
                    'X-Requested-With'  =>  'XMLHttpRequest',
                    'Accept'            =>  'application/json, text/javascript, */*',
                    'Content-Type'      =>  'application/x-www-form-urlencoded',
                )
            );

            $content = self::get ( $url );

            if ( $content == '' OR $content == false )
            {
                return false;
            }

            return json_decode( $content, true );
        }

        /**
         *   Get XML page as array
         *
         *   @param $url
         *   @return array
         */

        public static function getXML ( $url )
        {
            $content = self::get( $url );

            $content = simplexml_load_string ( $content );

            $content = json_encode ( $content );

            return json_decode( $content, true );
        }

        public static function postXML ( $url, $post = array () )
        {
            $content = self::post( $url, $post );

            $content = simplexml_load_string ( $content );

            $content = json_encode ( $content );

            return json_decode( $content, true );
        }


        /**
         *   Make POST request ...
         *
         *   @param $url
         *   @param array $post
         *   @return bool|mixed
         */

        public static function post ( $url, $post = array ())
        {
            if ( ! self::$ready )
            {
                return false;
            }

            if ( is_array( $post ))
            {
                $post = http_build_query ( $post, '', '&' );
            }

            curl_setopt_array( self::$conn, array
            (
                CURLOPT_POST        =>  true,

                CURLOPT_POSTFIELDS  =>  $post,
            ));

            return self::request ( $url );
        }

        /**
         *   Make HEAD request ...
         *
         *   @param $url
         *   @return bool|mixed
         */

        public static function head ( $url )
        {
            if ( ! self::$ready )
            {
                return false;
            }

            return self::request ( $url, true );
        }

        /**
         *   File upload ...
         *
         *   Usage
         *
         *   \Curl::upload ( 'http://site.com/' array
         *   (
         *           'field_name'    =>  'value',
         *
         *           'file'          =>  '/var/www/uploads/file.zip',
         *   ));
         *
         *   @param $url
         *   @param array $post
         *   @return bool|mixed
         */

        public static function upload ($url, $post = array())
        {
            if (!self::$ready OR ! is_array($post))
            {
                return false;
            }

            foreach ($post as $name => $value)
            {
                if (stristr($value, DIRECTORY_SEPARATOR))
                {
                    if (file_exists($value) AND is_file($value))
                    {
                        $post[ $name ] = '@' . $value;
                    }
                }
            }
            return self::post( $post );
        }

        /**
         *   Get request ...
         *
         *   @return array|bool
         */

        public static function getRequest ()
        {
            return isset ( self::$request ) ? self::$request : false;
        }

        /**
         *   Get response ...
         *
         *   @return array|bool
         */

        public static function getResponse ()
        {
            return isset ( self::$response ) ? self::$response : false;
        }

        /**
         *   Get content ...
         *
         *   @return string
         */

        public static function getContent ()
        {
            return self::$content;
        }

        /**
         *   Get raw data ..
         *
         *   @return string
         */

        public static function getRaw ()
        {
            return self::$raw;
        }

        /**
         *   Get response cookies ...
         *
         *   @return array
         */

        public static function getCookies ()
        {
            $response = end ( self::$response );
            return isset ( $response[ 'cookies' ] ) ? $response[ 'cookies' ] : array ();
        }

    }

?>