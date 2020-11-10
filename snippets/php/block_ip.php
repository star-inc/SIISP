<?php

/**
 * SIISP - Basic IP Protection
 * 
 * @version 2020.1
 * @link https://github.com/star-inc/siisp
 * @copyright (c) 2020 Star Inc.
 */
$visitor_ip = $_SERVER["REMOTE_ADDR"];
$blocked_list = file_get_contents("https://opensource.starinc.xyz/siisp/data/ip/blocked.json");
if ($blocked_ips = json_decode($blocked_list) and array_key_exists($visitor_ip, $blocked_ips)) {
    $year = date("Y") ?: "2020";
    header("SIISP: Blocked");
    http_response_code(403);
    die("
        <h3>Blocked</h3>
        <p>The IP:\"$visitor_ip\" has been locked due to the Security Reason.</p>
        <p>For more information, please visit <a href=\"https://security.starinc.xyz/blocked.html\">Star Inc. ISP Center</a>.</p>
        (c) $year <a href='https://starinc.xyz'>Star Inc.</a>
    ");
}
