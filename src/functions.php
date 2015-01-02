<?php
/**
 * Escape user submitted data, before encode decode it to prevent duplicated escapes
 *
 * @param string $value
 * @return string
 */
function E($value)
{
    return htmlspecialchars(htmlspecialchars_decode($value, ENT_COMPAT), ENT_COMPAT, 'UTF-8');
}

/**
 * @copyright 2010 MAPIX Technologies Ltd, UK, http://mapix.com/
 * @license http://en.wikipedia.org/wiki/BSD_licenses BSD License
 * @package Smarty
 * @subpackage PluginsModifier
 */
function seconds_to_words($seconds)
{
    if ($seconds < 0) {
        throw new Exception("Can't do negative numbers!");
    }

    if ($seconds == 0) {
        return "zero seconds";
    }

    $days = floor($seconds / 86400);
    $seconds = $seconds - ($days * 86400);
    $hours = floor($seconds / 3600);
    $seconds = $seconds - ($hours * 3600);
    $minutes = floor($seconds / 60);
    $seconds = $seconds - ($minutes * 60);
    $out = "";
    if ($days > 0) {
        $out .= $days . " day" . ($days > 1 ? "s" : "") . " ";
    }
    if ($hours > 0) {
        $out .= $hours . " hour" . ($hours > 1 ? "s" : "") . " ";
    }
    if ($minutes > 0) {
        $out .= $minutes . " min" . ($minutes > 1 ? "s" : "") . " ";
    }
    if ($seconds > 0) {
        $out .= $seconds . " sec" . ($seconds > 1 ? "s" : "");
    }
    return trim($out);
}
