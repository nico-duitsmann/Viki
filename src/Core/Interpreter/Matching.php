<?php

/**
* Check if haystack starts with needle.
*
* @param string $haystack
* @param string $needle
* @return boolean
*/
function starts_with(string $haystack, string $needle): bool
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
* Check if haystack ends with needle.
*
* @param string $haystack
* @param string $needle
* @return boolean
*/
function ends_with(string $haystack, string $needle): bool
{
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}

/**
 * Check if input contains specific pattern.
 *
 * @param string $pattern
 * @param string $input
 * @return boolean
 */
function is_in(string $pattern, string $input): bool
{
    // Transform to lowercase
    $pattern = strtolower($pattern);
    $input   = strtolower($input);

    if ( $pattern == '' || $input == '' ) {
        return false;
    }

    if ( strncmp($pattern, $input, strlen($input)) === 0 ) {
        return true;
    } else {
        if ( starts_with($input, $pattern) ) {
            return true;
        } else {
            if ( stristr($input, $pattern) ) {
                return true;
            } else {
                if ( ends_with($input, $pattern) ) {
                    return true;
                } else {
                    if ( fnmatch("*$pattern*", $input) ) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}
