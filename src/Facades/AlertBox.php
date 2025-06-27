<?php

namespace RifRocket\FilamentAlertBox\Facades;

use RifRocket\FilamentAlertBox\AlertBoxManager;
use RifRocket\FilamentAlertBox\AlertBuilder;

/**
 * @method static AlertBuilder make(string $title = null)
 * @method static AlertBuilder success(string $message)
 * @method static AlertBuilder error(string $message)
 * @method static AlertBuilder warning(string $message)
 * @method static AlertBuilder info(string $message)
 * @method static array getAlerts(string $position = null)
 * @method static void clearAlerts(string $position)
 * @method static void clearAll()
 * @method static void addAlert(string $position, array $config)
 * @method static array getPositionsWithAlerts()
 * @method static bool hasAlerts(string $position)
 * @method static int getAlertCount(string $position = null)
 */
class AlertBox
{
    public static function __callStatic($method, $arguments)
    {
        return AlertBoxManager::$method(...$arguments);
    }
}
