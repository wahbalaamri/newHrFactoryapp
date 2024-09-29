<?php

if (!function_exists('isArabic')) {
    function isArabic($string) {
        return preg_match('/\p{Arabic}/u', $string);
    }
}
