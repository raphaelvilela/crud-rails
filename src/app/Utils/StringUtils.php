<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 15/03/2018
 * Time: 21:54
 */

namespace App\Utils;


class StringUtils
{

    public static function resizeString($long_string, $max_size)
    {
        // this regular expression will split $long_string on any sub-string of
        // 1-or-more non-word characters (spaces or punctuation)
        if (preg_match_all("/.{1,{$max_size}}(?=\W+)/", $long_string, $lines) !== False) {
            return $lines[0][0];
        }
    }

}