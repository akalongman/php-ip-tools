<?php
/*
 * This file is part of the IPTools package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Longman\IPTools;

/**
 * Class to determine if an IP is located in a specific range as
 * specified via several alternative formats.
 *
 * @package    IPTools
 * @author     Avtandil Kikabidze <akalongman@gmail.com>
 * @copyright  Avtandil Kikabidze <akalongman@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @link       http://www.github.com/akalongman/php-ip-tools
 */
class Ip
{

    /**
     * Checks if an IP is valid.
     *
     * @param string $ip IP
     * @return boolean true if IP is valid, otherwise false.
     */
    public static function isValid($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }


    /**
     * Checks if an IP is part of an IP range.
     *
     * @param string $ip IPv4
     * @param mixed $range IP range specified in one of the following formats:
     * Wildcard format:     1.2.3.*
     * CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
     * Start-End IP format: 1.2.3.0-1.2.3.255
     * @return boolean true if IP is part of range, otherwise false.
     */
    public static function match($ip, $ranges)
    {
        if (is_array($ranges)) {
            foreach ($ranges as $range) {
                $match = self::compare($ip, $range);
                if ($match) {
                    return true;
                }
            }
        } else {
            return self::compare($ip, $ranges);
        }
        return false;
    }

    /**
     * Checks if an IP is part of an IP range.
     *
     * @param string $ip IPv4
     * @param string $range IP range specified in one of the following formats:
     * Wildcard format:     1.2.3.*
     * CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
     * Start-End IP format: 1.2.3.0-1.2.3.255
     * @return boolean true if IP is part of range, otherwise false.
     */
    public static function compare($ip, $range)
    {
        if (!self::isValid($ip)) {
            throw new \InvalidArgumentException('Input IP is invalid!');
        }

        if (strpos($range, '/') !== false) {
            list($range, $netmask) = explode('/', $range, 2);
            if (strpos($netmask, '.') !== false) {
                $netmask     = str_replace('*', '0', $netmask);
                $netmask_dec = ip2long($netmask);
                return ((ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec));
            } else {
                $x = explode('.', $range);
                while (count($x) < 4) {
                    $x[] = '0';
                }

                list($a, $b, $c, $d) = $x;
                $range               = sprintf("%u.%u.%u.%u", empty($a) ? '0' : $a, empty($b) ? '0' : $b, empty($c) ? '0' : $c, empty($d) ? '0' : $d);
                $range_dec           = ip2long($range);
                $ip_dec              = ip2long($ip);
                $wildcard_dec        = pow(2, (32 - $netmask)) - 1;
                $netmask_dec         = ~$wildcard_dec;

                return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
            }
        } else if (strpos($range, '*') !== false) {
            if (strpos($range, '*') !== false) {
                $lower = str_replace('*', '0', $range);
                $upper = str_replace('*', '255', $range);
                $range = $lower . '-' . $upper;
            }
            if (strpos($range, '-') !== false) {
                list($lower, $upper) = explode('-', $range, 2);
                $lower_dec           = (float) sprintf("%u", ip2long($lower));
                $upper_dec           = (float) sprintf("%u", ip2long($upper));
                $ip_dec              = (float) sprintf("%u", ip2long($ip));
                return (($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec));
            }
        } else {
            return ($ip === $range);
        }
        return false;
    }
}
