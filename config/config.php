<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));

// defined( 'APP_PATH' ) || define( 'APP_PATH', realpath( '.' ) );

defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/phalcon-boilerplate');

use  Phalcon\Logger;

return new \Phalcon\Config( [
	'site'          => [
		'name'        => 'Application',
		'url'         => 'https://app.vm',
		'description' => 'application',
		'keywords'    => 'application,phalcon,boilerplate',
		'project'     => 'application',
		'software'    => 'application',
		'support'     => 'gamalanpro@gmail.com'
	],
	'database' => [
        'adapter'     => 'mysql',
        'host'        => env( 'DATABASE_HOST' ),
        'username'    => env( 'DATABASE_USER' ),
        'password'    => env( 'DATABASE_PASS' ),
        'dbname'      => env( 'DATABASE_NAME' ),
        'charset'     => 'utf8',
    ],
	'application'   => [
		'appDir'         	 => APP_PATH . '/app',
		'controllersDir'     => APP_PATH . '/app/controllers/',
		'modelsDir'          => APP_PATH . '/app/models/',
		'migrationsDir'      => APP_PATH . '/app/migrations/',
		'viewsDir'           => APP_PATH . '/app/views/',
		'libraryDir'         => APP_PATH . '/app/library/',
		'cacheDir'           => BASE_PATH . '/cache/',
		'baseUri'            => env( 'BASE_URI' ),
		'staticBaseUri'      => env( 'STATIC_BASE_URI' ),
		'ketenBaseUri'       => '/',
		'ketenStaticBaseUri' => '/'
	],
	'beanstalk'     => [
		'host'                    => env( 'BEANSTALK_HOST' ),
		'port'                    => env( 'BEANSTALK_PORT' ),
		'process_sleep'           => env( 'PROCESS_IDLE' ),
		'preprocess_sleep'        => env( 'PREPROCESS_IDLE' ),
		'basic_worker_name'       => env( 'WORKER_NAME' ),
		'basic_worker_count'      => env( 'WORKER_COUNT' ),
	],
	'elasticsearch' => [
		'index' => env( 'ELASTIC_INDEX' ),
		'hosts' => [
			env( 'ELASTIC_HOST', '127.0.0.1' ) . ':' . env( 'ELASTIC_PORT', 9200 ),
		],
	],
	'error'         => [
		'logger'     => app_path( 'logs/error.log' ),
		'formatter'  => [
			'format' => env( 'LOGGER_FORMAT', '[%date%][%type%] %message%' ),
			'date'   => 'd-M-Y H:i:s',
		],
		'controller' => 'error',
		'action'     => 'route500',
	],
	'crypt'         => [
		'key'    => env( 'CRYPT_KEY' ),
		'keyapi' => env( 'CRYPT_KEY_API' )
	],
	'fb'            => [
		'app_id'       => env( 'FB_APP_ID' ),
		'app_secret'   => env( 'FB_APP_SECRET' ),
		'app_version'  => env( 'FB_APP_VERSION' ),
		'verify_token' => env( 'FB_VERIFY_TOKEN' ),
	],
	'environment'   => APPLICATION_ENV,
	'requestID'     => null,
	'sentry'        => [
		// The login information for Sentry. If one of the values is empty the logging is suppressed silently.
		'credential'   => [
			'key'       => env( 'SENTRY_APP_PUBLIC' ),
			'secret'    => env( 'SENTRY_APP_SECRET' ),
			'projectId' => env( 'SENTRY_APP_ID' ),
		],
		// The options for Raven_Client. See https://docs.sentry.io/clients/php/config/#available-settings
		'options'      => [
			'curl_method' => 'sync',
			'prefixes'    => [],
			'app_path'    => APP_PATH,
			'timeout'     => 2,
		],
		// Sentry will log errors/exceptions when the application environment set above is one of these.
		'environments' => [ 'production', 'staging' ],
		// The log levels which are forwarded to sentry.
		'levels'       => [ Logger::EMERGENCY, Logger::CRITICAL, Logger::ERROR, Logger::SPECIAL, Logger::CUSTOM ],
		// These exceptions are not reported to sentry.
		'dontReport'   => [],
	]
] );
