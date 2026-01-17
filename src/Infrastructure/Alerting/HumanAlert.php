<?php
declare(strict_types=1);

namespace DCIEN\Infrastructure\Alerting;

final class HumanAlert
{
    private static bool $emitted = false;
    private static bool $confirmed = false;
    private static array $trail = [];

    public static function emit(string $event): void
    {
        self::$emitted = true;
        self::$trail[] = 'event';
        self::$trail[] = 'alert';
        self::$trail[] = 'confirmation';
    }

    public static function isEmitted(): bool
    {
        return self::$emitted;
    }

    public static function isConfirmed(): bool
    {
        return self::$confirmed;
    }

    public static function confirm(): void
    {
        self::$confirmed = true;
        self::$trail[] = 'confirmation';
    }

    public static function trail(): array
    {
        return self::$trail;
    }
}
