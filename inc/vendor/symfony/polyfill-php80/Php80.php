<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Polyfill\Php80;

use __PHP_Incomplete_Class;
use TypeError;
use function get_class;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_object;
use function is_resource;
use function is_string;
use function strlen;
use const PREG_BACKTRACK_LIMIT_ERROR;
use const PREG_BAD_UTF8_ERROR;
use const PREG_BAD_UTF8_OFFSET_ERROR;
use const PREG_INTERNAL_ERROR;
use const PREG_JIT_STACKLIMIT_ERROR;
use const PREG_NO_ERROR;
use const PREG_RECURSION_LIMIT_ERROR;

/**
 * @author Ion Bazan <ion.bazan@gmail.com>
 * @author Nico Oelgart <nicoswd@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
final class Php80
{
    public static function fdiv(float $dividend, float $divisor): float
    {
        return @($dividend / $divisor);
    }

    public static function get_debug_type($value): string
    {
        switch (true) {
            case null === $value:
                return 'null';
            case is_bool($value):
                return 'bool';
            case is_string($value):
                return 'string';
            case is_array($value):
                return 'array';
            case is_int($value):
                return 'int';
            case is_float($value):
                return 'float';
            case is_object($value):
                break;
            case $value instanceof __PHP_Incomplete_Class:
                return '__PHP_Incomplete_Class';
            default:
                if (null === $type = @get_resource_type($value)) {
                    return 'unknown';
                }

                if ('Unknown' === $type) {
                    $type = 'closed';
                }

                return "resource ($type)";
        }

        $class = get_class($value);

        if (!str_contains($class, '@')) {
            return $class;
        }

        return (get_parent_class($class) ?: key(class_implements($class)) ?: 'class') . '@anonymous';
    }

    public static function get_resource_id($res): int
    {
        if (!is_resource($res) && null === @get_resource_type($res)) {
            throw new TypeError(sprintf('Argument 1 passed to get_resource_id() must be of the type resource, %s given', get_debug_type($res)));
        }

        return (int)$res;
    }

    public static function preg_last_error_msg(): string
    {
        return match (preg_last_error()) {
            PREG_INTERNAL_ERROR => 'Internal error',
            PREG_BAD_UTF8_ERROR => 'Malformed UTF-8 characters, possibly incorrectly encoded',
            PREG_BAD_UTF8_OFFSET_ERROR => 'The offset did not correspond to the beginning of a valid UTF-8 code point',
            PREG_BACKTRACK_LIMIT_ERROR => 'Backtrack limit exhausted',
            PREG_RECURSION_LIMIT_ERROR => 'Recursion limit exhausted',
            PREG_JIT_STACKLIMIT_ERROR => 'JIT stack limit exhausted',
            PREG_NO_ERROR => 'No error',
            default => 'Unknown error',
        };
    }

    public static function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || str_contains($haystack, $needle);
    }

    public static function str_starts_with(string $haystack, string $needle): bool
    {
        return 0 === strncmp($haystack, $needle, strlen($needle));
    }

    public static function str_ends_with(string $haystack, string $needle): bool
    {
        if ('' === $needle || $needle === $haystack) {
            return true;
        }

        if ('' === $haystack) {
            return false;
        }

        $needleLength = strlen($needle);

        return $needleLength <= strlen($haystack) && 0 === substr_compare($haystack, $needle, -$needleLength);
    }
}
