<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'urlredirect' => \App\Filters\UrlRedirectFilter::class,
		'RedirectNaturalTourism' => \App\Filters\RedirectNaturalTourism::class,
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'auth' => \App\Filters\UsersAuthFilter::class,
		'languagefilter' => \App\Filters\LanguageFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			'urlredirect', // Jalankan middleware sebelum setiap request
			'RedirectNaturalTourism',
			'csrf',
			'languagefilter' => ['execpt' => ['language/*']],
			'usersAuth' => [
				'except' => [
					'login/*',
					'logout/*',
					'user/*',
					'detail/*',
					'lang/*',
					'/*'
				]
			]
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];


	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['foo', 'bar']
	 *
	 * If you use this, you should disable auto-routing because auto-routing
	 * permits any HTTP method to access a controller. Accessing the controller
	 * with a method you don’t expect could bypass the filter.
	 */
	public array $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 */
	public $filters = [
		'usersAuth' => \App\Filters\UsersAuthFilter::class,
	];
}
