<?php namespace yxorP\inc\snag;
class ErrorTypes
{
    protected static array $ERROR_TYPES = [E_ERROR => ['name' => 'PHP Fatal Error', 'severity' => 'error',], E_WARNING => ['name' => 'PHP Warning', 'severity' => 'warning',], E_PARSE => ['name' => 'PHP Parse Error', 'severity' => 'error',], E_NOTICE => ['name' => 'PHP Notice', 'severity' => 'info',], E_CORE_ERROR => ['name' => 'PHP Core Error', 'severity' => 'error',], E_CORE_WARNING => ['name' => 'PHP Core Warning', 'severity' => 'warning',], E_COMPILE_ERROR => ['name' => 'PHP Compile Error', 'severity' => 'error',], E_COMPILE_WARNING => ['name' => 'PHP Compile Warning', 'severity' => 'warning',], E_USER_ERROR => ['name' => 'User Error', 'severity' => 'error',], E_USER_WARNING => ['name' => 'User Warning', 'severity' => 'warning',], E_USER_NOTICE => ['name' => 'User Notice', 'severity' => 'info',], E_STRICT => ['name' => 'PHP Strict', 'severity' => 'info',], E_RECOVERABLE_ERROR => ['name' => 'PHP Recoverable Error', 'severity' => 'error',], E_DEPRECATED => ['name' => 'PHP Deprecated', 'severity' => 'info',], E_USER_DEPRECATED => ['name' => 'User Deprecated', 'severity' => 'info',],];

    public static function isFatal($code): bool
    {
        return static::getSeverity($code) === 'error';
    }

    public static function getSeverity($code): mixed
    {
        if (array_key_exists($code, static::$ERROR_TYPES)) {
            return static::$ERROR_TYPES[$code]['severity'];
        }
        return 'error';
    }

    public static function getName($code): mixed
    {
        if (array_key_exists($code, static::$ERROR_TYPES)) {
            return static::$ERROR_TYPES[$code]['name'];
        }
        return 'Unknown';
    }

    public static function getLevelsForSeverity($severity): int|string
    {
        $levels = 0;
        foreach (static::$ERROR_TYPES as $level => $info) {
            if ($info['severity'] == $severity) {
                $levels |= $level;
            }
        }
        return $levels;
    }

    public static function getAllCodes(): array
    {
        return array_keys(self::$ERROR_TYPES);
    }

    public static function codeToString($code): string
    {
        return match ($code) {
            E_ERROR => 'E_ERROR',
            E_WARNING => 'E_WARNING',
            E_PARSE => 'E_PARSE',
            E_NOTICE => 'E_NOTICE',
            E_CORE_ERROR => 'E_CORE_ERROR',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_ERROR => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED',
            default => 'Unknown',
        };
    }
}