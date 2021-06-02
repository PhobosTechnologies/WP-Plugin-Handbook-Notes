<?php

// Only using GET when HEAD says the data is new or should not be cached
//  will help save on expensive bandwidth and load times.

// PUT, DELETE, TRACE, and CONNECT do not have pre-built methods in WordPress

# HTTP CODE CLASSES
/*
 *  2xx	Successful Request
 *  3xx	Request Redirected to other URL
 *  4xx	Request failed: client error (invalid authentication / missing data)
 *  5xx	Request failed: server error (missing / bad conf files)
 */

# COMMON CODES
/*
 *  200 OK – Successful Request
 *  301	Permanently Moved
 *  302	Temporarily Moved
 *  403	Forbidden (invalid authentication)
 *  404	Not found
 *  500	Internal server error
 *  503	Service unavailable
 */

$url = "https://www.standard.url/format?a=1";
$args = [
	method      => 'GET',
	timeout     => 5,
	redirection => 5,
	httpversion =>1.0,
	blocking    => TRUE,
	headers     => array(),
	body        => null,
	cookies     => array()
];

$response = wp_remote_get($url, $args);

// the response will typically contain:
/**
Array(
	[headers] => Array(
		[server] => nginx
		[date] => Fri, 05 Oct 2012 04:43:50 GMT
		[content-type] => application/json; charset=utf-8
		[connection] => close
		[status] => 200 OK
		[vary] => Accept
		[x-ratelimit-remaining] => 4988
		[content-length] => 594
		[last-modified] => Fri, 05 Oct 2012 04:39:58 GMT
		[etag] => "5d5e6f7a09462d6a2b473fb616a26d2a"
		[x-github-media-type] => github.beta
		[cache-control] => public, s-maxage=60, max-age=60
		[x-content-type-options] => nosniff
		[x-ratelimit-limit] => 5000
	)
	[body] => {"type":"User","login":"blobaugh","gravatar_id":"f25f324a47a1efdf7a745e0b2e3c878f","public_gists":1,"followers":22,"created_at":"2011-05-23T21:38:50Z","public_repos":31,"email":"ben@lobaugh.net","hireable":true,"blog":"http://ben.lobaugh.net","bio":null,"following":30,"name":"Ben Lobaugh","company":null,"avatar_url":"https://secure.gravatar.com/avatar/f25f324a47a1efdf7a745e0b2e3c878f?d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png","id":806179,"html_url":"https://github.com/blobaugh","location":null,"url":"https://api.github.com/users/blobaugh"}
	[response] => Array(
		[preserved_text 5237511b45884ac6db1ff9d7e407f225 /] => 200
		[message] => OK
	)
	[cookies] => Array()
	[filename] =>
)
*/

// get just the body
$response = wp_remote_get( 'https://api.github.com/users/blobaugh' );
$body     = wp_remote_retrieve_body( $response );

// ... or this if you don't have any operations to perform ...
$body = wp_remote_retrieve_body( wp_remote_get( 'https://api.github.com/users/blobaugh' ) );

// body would be:
/**
{"type":"User","login":"blobaugh","public_repos":31,"gravatar_id":"f25f324a47a1efdf7a745e0b2e3c878f","followers":22,"avatar_url":"https://secure.gravatar.com/avatar/f25f324a47a1efdf7a745e0b2e3c878f?d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png","public_gists":1,"created_at":"2011-05-23T21:38:50Z","email":"ben@lobaugh.net","following":30,"name":"Ben Lobaugh","company":null,"hireable":true,"id":806179,"html_url":"https://github.com/blobaugh","blog":"http://ben.lobaugh.net","location":null,"bio":null,"url":"https://api.github.com/users/blobaugh"}
*/

// get response code
$response = wp_remote_get( 'https://api.github.com/users/blobaugh' );
$http_code = wp_remote_retrieve_response_code( $response );

// get specific header
$response      = wp_remote_get( 'https://api.github.com/users/blobaugh' );
$last_modified = wp_remote_retrieve_header( $response, 'last-modified' );

// grabbing all of the headers
wp_remote_retrieve_headers( $response );

// basic authentication
$args = array(
	'headers' => array(
		'Authorization' => 'Basic ' . base64_encode( YOUR_USERNAME . ':' . YOUR_PASSWORD )
	)
);
wp_remote_get( $url, $args );

// posting data to an API
$body = array(
	'name'    => 'Jane Smith',
	'email'   => 'some@email.com',
	'subject' => 'Checkout this API stuff',
	'comment' => 'I just read a great tutorial. You gotta check it out!',
);

$args = array(
	'body'        => $body,
	'timeout'     => '5',
	'redirection' => '5',
	'httpversion' => '1.0',
	'blocking'    => true,
	'headers'     => array(),
	'cookies'     => array(),
);

$response = wp_remote_post( 'http://your-contact-form.com', $args );

// bandwidth sensitive queries
/** important headers:
	x-ratelimit-limit – Number of requests allowed in a time period
	x-ratelimit-remaining – Number of remaining available requests in time period
	content-length – How large the content is in bytes. Can be useful to warn the user if the content is fairly large
	last-modified – When the resource was last modified. Highly useful to caching tools
	cache-control – How should the client handle caching
*/

$response = wp_remote_head( 'https://api.github.com/users/blobaugh' );
/**
Array(
	[headers] => Array
		(
		[server] => nginx
		[date] => Fri, 05 Oct 2012 05:21:26 GMT
		[content-type] => application/json; charset=utf-8
		[connection] => close
		[status] => 200 OK
		[vary] => Accept
		[x-ratelimit-remaining] => 4982
		[content-length] => 594
		[last-modified] => Fri, 05 Oct 2012 04:39:58 GMT
		[etag] => "5d5e6f7a09462d6a2b473fb616a26d2a"
		[x-github-media-type] => github.beta
		[cache-control] => public, s-maxage=60, max-age=60
		[x-content-type-options] => nosniff
		[x-ratelimit-limit] => 5000
	)
	[body] =>
	[response] => Array
		(
		[preserved_text 39a8515bd2dce2aa06ee8a2a6656b1de /] => 200
		[message] => OK
		)
	[cookies] => Array(
	)
	[filename] =>
)
 */

// making other requests (like DELETE)
$args     = array(
	'method' => 'DELETE',
);
$response = wp_remote_request( 'http://some-api.com/object/to/delete', $args );

# USING TRANSIENTS FOR CACHING

// caching object: setting transient (can help speed things up in certain cases)
$transient = '';    // Name of the transient for future reference
$value = '';        // Value of the transient
$expiration = '';   // How many seconds from saving the transient until it expires

$response = wp_remote_get( 'https://api.github.com/users/blobaugh' );
set_transient( 'prefix_github_userinfo', $response, 60 * 60 );

// get cached obj: getting transient
$github_userinfo = get_transient( 'prefix_github_userinfo' );

if ( false === $github_userinfo ) {
	// Transient expired, refresh the data
	$response = wp_remote_get( 'https://api.github.com/users/blobaugh' );
	set_transient( 'prefix_github_userinfo', $response, HOUR_IN_SECONDS );
}
// Use $github_userinfo as you will

// deleting transient
delete_transient( 'blobaugh_github_userinfo' );





























