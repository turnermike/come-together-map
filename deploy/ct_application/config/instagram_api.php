<?php

/*
|--------------------------------------------------------------------------
| Instagram
|--------------------------------------------------------------------------
|
| Instagram client details
|
*/

$config['instagram_client_name']	= 'Come Together Map';
$config['instagram_client_id']		= '417329a9b38146aeb13cef2e0c5b36e7';
$config['instagram_client_secret']	= 'ced6c6e2576e4840a556b45368fcea06';
$config['instagram_callback_url']	= 'http://cometogethermap.dev';
$config['instagram_website']		= 'http://cometogethermap.dev';
$config['instagram_description']	= 'Bluejays hashtag geo tracker.';

/**
 * Instagram provides the following scope permissions which can be combined as likes+comments
 * 
 * basic - to read any and all data related to a user (e.g. following/followed-by lists, photos, etc.) (granted by default)
 * comments - to create or delete comments on a user’s behalf
 * relationships - to follow and unfollow users on a user’s behalf
 * likes - to like and unlike items on a user’s behalf
 * 
 */
// $config['instagram_scope'] = 'basic';
// // There was issues with some servers not being able to retrieve the data through https
// // If you have this problem set the following to FALSE 
// // See https://github.com/ianckc/CodeIgniter-Instagram-Library/issues/5 for a discussion on this
// $config['instagram_ssl_verify']   = TRUE;