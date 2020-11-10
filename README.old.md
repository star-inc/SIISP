# SIISP with SIAR

This is an old method that get the list of blocked IPs from Star Inc. Restful API for public.

The list was stored in our database in the past, but we thought it was stupid, that always query from that will cause the server performance losing.

So, the way is deprecated, and it will fetch from GitHub even you are visiting via our API server.

Anyway, this is the old code that we used for protecting our services.

```php
<?php
// Star Inc. - Internet Security Protection
$blocked_list = file_get_contents("https://restapi.starinc.xyz/basic/ip/blocked");
$blocked_ips = json_decode($blocked_list);
if($blocked_ips and $blocked_ips->status === 200 and in_array($_SERVER["REMOTE_ADDR"], $blocked_ips->data)) {
    header("SIISP: Blocked");
    http_response_code(403);
    die("
        <h3>Blocked</h3>
        <p>The IP:\"$_SERVER[REMOTE_ADDR]\" has been locked due to the Security Reason.</p>
        <p>For more information, please visit <a href=\"https://security.starinc.xyz/blocked.html\">Star Inc. ISP Center</a>.</p>
        (c) 2020 <a href='https://starinc.xyz'>Star Inc.</a>
    ");
}
```

> (c) 2020 Star Inc.
