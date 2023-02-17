<?php
if (!function_exists('secondsToJrTime')) {
    function secondsToJrTime(int $seconds, string $glue = ''): string
    {
        return (new \Flynn314\DateTime\JrTime())->format($seconds, $glue);
    }
}