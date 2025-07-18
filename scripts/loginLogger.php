<?php

$username = $user->name;
function logLogin($username)
{
$timestamp = date('Y-m-d H:i:s');

$logLine = "$timestamp - $username\n";
file_put_contents(__DIR__ . '/logins.txt', $logLine, FILE_APPEND);
}
