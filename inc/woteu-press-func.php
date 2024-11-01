<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function wot_api($value, $mode)	{
        switch($mode)	{
                case 'get_acc_id';
                    $res = get_response('https://api.worldoftanks.eu/wot/account/list/?application_id='.$GLOBALS['app_id'].'&search='.$value.'&limit=1');
                    $output =  $res['data'][0]['account_id'];               
                break;
                case 'basic':	
                    $api_stat = 'https://api.worldoftanks.eu/wot/account/info/?application_id='.$GLOBALS['app_id'].'&account_id='.$value;
                    $output = get_response($api_stat);
                break;
                case 'tanks':	
                    $api_stat = 'https://api.worldoftanks.eu/wot/account/tanks/?application_id='.$GLOBALS['app_id'].'&account_id='.$value;
                    $output = get_response($api_stat);
                break;
                case 'vehicles';
                    $api_stat = 'https://api.worldoftanks.eu/wot/encyclopedia/vehicles/?application_id='.$GLOBALS['app_id'].'&tank_id='.$value;
                    $output = get_response($api_stat);   
                break;    
        }
        
        return $output;
}

function get_response($url)	{
        $response = wp_remote_get($url);
        return json_decode($response['body'], true);
}
add_action( 'plugins_loaded', 'text_domain_parse' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function text_domain_parse()	{
            load_plugin_textdomain($GLOBALS['text_domain'] , false, dirname(plugin_basename( __FILE__ )).'/languages');
}
