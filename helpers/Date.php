<?php

use_helper('I18n');

/**
 * Date Helper.
 */

function distance_of_time_in_words($from_time, $to_time = null)
{
    $to_time = $to_time ? $to_time: $_SERVER['REQUEST_TIME'];

    $distance_in_minutes = floor(abs($to_time - $from_time) / 60);

    if ($distance_in_minutes <= 1)
        return __('less than a minute');
    else if ($distance_in_minutes >= 2 && $distance_in_minutes <= 44)
        return sprintf(__('%d minutes'), $distance_in_minutes);
    else if ($distance_in_minutes >= 45 && $distance_in_minutes <= 89)
        return __('about 1 hour');
    else if ($distance_in_minutes >= 90 && $distance_in_minutes <= 1439)
        return sprintf(__('about %d hours'), round($distance_in_minutes / 60));
    else if ($distance_in_minutes >= 1440 && $distance_in_minutes <= 2879)
        return __('1 day');
    else if ($distance_in_minutes >= 2880 && $distance_in_minutes <= 43199)
        return sprintf(__('%d days'), round($distance_in_minutes / 1440));
    else if ($distance_in_minutes >= 43200 && $distance_in_minutes <= 86399)
        return __('about 1 month');
    else if ($distance_in_minutes >= 86400 && $distance_in_minutes <= 525959)
        return sprintf(__('about %d months'), round($distance_in_minutes / 43200));
    else if ($distance_in_minutes >= 525960 && $distance_in_minutes <= 1051919)
        return __('about 1 year');
    else
        return sprintf(__('over %d years'), round($distance_in_minutes / 525960));
}

// Like distance_of_time_in_words, but where to_time is fixed to time()
function time_ago_in_words($from_time, $include_seconds = false)
{
    return distance_of_time_in_words($from_time, $_SERVER['REQUEST_TIME'], $include_seconds);
}
