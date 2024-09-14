<?php

// File: app/Helpers/TimeHelper.php

if (!function_exists('last_seen')) {
    define('TIMEZONE', 'Asia/Dhaka');
    date_default_timezone_set(TIMEZONE);

    function last_seen($date_time)
    {
        $timestamp = $date_time;
        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = $currentTime - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            if ($diff < 10 && $strTime[$i] == "second") {
                return 'Active';
            } else {
                return $diff . " " . $strTime[$i] . "(s) ago";
            }
        }
    }
}
