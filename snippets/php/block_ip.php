<?php

/**
 * SIISP - Basic IP Protection
 *
 * @version 2020.2.2
 * @link https://github.com/star-inc/SIISP
 * @copyright (c) 2020 Star Inc.
 */
$visitor_ip = $_SERVER["REMOTE_ADDR"];
$blocked_list = file_get_contents("https://opensource.starinc.xyz/SIISP/data/ip/blocked.json");
if ($blocked_list) {
    $blocked_ips = array_filter(
        json_decode($blocked_list, true),
        function ($object) {
            return $object["forever"] || ($object["timestamp"] + 86400 > time());
        }
    );
    if (array_key_exists($visitor_ip, $blocked_ips)) {
        $year = date("Y") ?: "2020";
        $blocked_reason = $blocked_ips[$visitor_ip]["reason"];
        $blocked_timestamp = $blocked_ips[$visitor_ip]["forever"] ? "*" : $blocked_ips[$visitor_ip]["timestamp"];
        header("SIISP: Blocked");
        header("SIISP-Block-IP: $visitor_ip");
        header("SIISP-Block-Reason: $blocked_reason");
        header("SIISP-Block-Timestamp: $blocked_timestamp");
        $visitor_ip = htmlspecialchars($visitor_ip);
        $blocked_reason = htmlspecialchars($blocked_reason);
        http_response_code(403);
        die("
            <h3>Blocked</h3>
            <p>The IP:\"$visitor_ip\" has been locked due to the security reason:\"$blocked_reason\".</p>
            <p>For more information, please visit <a href=\"https://security.starinc.xyz/blocked.html\">Star Inc. ISP Center</a>.</p>
            (c) $year <a href='https://starinc.xyz'>Star Inc.</a>
        ");
    }
}
