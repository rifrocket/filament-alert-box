<?php

declare(strict_types=1);

namespace RifRocket\FilamentAlertBox;

/**
 * Alert Box Manager
 *
 * Manages alerts in memory for FilamentPHP using render hooks system.
 * Provides a fluent API for creating and managing alerts across different page positions.
 *
 * @author Mohammad Arif <mohammad.arif9999@gmail.com>
 */
final class AlertBoxManager
{
    /**
     * Storage for alerts organized by position
     */
    private static array $alerts = [];

    /**
     * Default alert configuration
     */
    private const DEFAULT_CONFIG = [
        'id' => '',
        'type' => 'info',
        'title' => null,
        'description' => null,
        'style_type' => 1, // Card style (1-4)
        'closeable' => true,
        'auto_hide' => false,
        'timeout' => 5000,
        'permanent' => false,
        'noIcon' => false,
        'icon' => null,
        'icon_color' => null,
        'title_color' => null,
        'description_color' => null,
        'classes' => '',
        'style' => '',
    ];

    /**
     * Create a new alert builder instance
     */
    public static function make(?string $title = null): AlertBuilder
    {
        return new AlertBuilder($title);
    }

    /**
     * Add alert for specific render hook position
     */
    public static function addAlert(string $position, array $config): void
    {
        if (empty($position)) {
            throw new \InvalidArgumentException('Position cannot be empty');
        }

        // Validate required config fields
        if (! isset($config['type']) || ! in_array($config['type'], ['info', 'success', 'warning', 'danger', 'error'])) {
            throw new \InvalidArgumentException('Invalid alert type');
        }

        if (! isset(self::$alerts[$position])) {
            self::$alerts[$position] = [];
        }

        $alertConfig = array_merge(self::DEFAULT_CONFIG, $config);
        $alertConfig['id'] = $alertConfig['id'] ?: uniqid('alert_', true);

        // Normalize error type to danger
        if ($alertConfig['type'] === 'error') {
            $alertConfig['type'] = 'danger';
        }

        self::$alerts[$position][] = $alertConfig;
    }

    /**
     * Get alerts for specific position
     */
    public static function getAlerts(?string $position = null): array
    {
        if ($position === null) {
            return self::$alerts;
        }

        return self::$alerts[$position] ?? [];
    }

    /**
     * Get all positions that have alerts
     */
    public static function getPositionsWithAlerts(): array
    {
        return array_keys(array_filter(self::$alerts, fn ($alerts) => ! empty($alerts)));
    }

    /**
     * Check if a position has alerts
     */
    public static function hasAlerts(string $position): bool
    {
        return ! empty(self::$alerts[$position]);
    }

    /**
     * Get total count of alerts across all positions
     */
    public static function getAlertCount(?string $position = null): int
    {
        if ($position !== null) {
            return count(self::$alerts[$position] ?? []);
        }

        return array_sum(array_map('count', self::$alerts));
    }

    /**
     * Clear alerts for specific position
     */
    public static function clearAlerts(string $position): void
    {
        unset(self::$alerts[$position]);
    }

    /**
     * Clear all alerts
     */
    public static function clearAll(): void
    {
        self::$alerts = [];
    }

    // Quick static methods for common patterns (backwards compatibility)

    /**
     * Create a success alert
     */
    public static function success(string $message): AlertBuilder
    {
        return self::make($message)->success();
    }

    /**
     * Create an error alert
     */
    public static function error(string $message): AlertBuilder
    {
        return self::make($message)->danger();
    }

    /**
     * Create a warning alert
     */
    public static function warning(string $message): AlertBuilder
    {
        return self::make($message)->warning();
    }

    /**
     * Create an info alert
     */
    public static function info(string $message): AlertBuilder
    {
        return self::make($message)->info();
    }
}
