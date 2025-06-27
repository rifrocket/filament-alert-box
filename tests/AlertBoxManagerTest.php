<?php

declare(strict_types=1);

namespace RifRocket\FilamentAlertBox\Tests;

use PHPUnit\Framework\TestCase;
use RifRocket\FilamentAlertBox\AlertBoxManager;
use RifRocket\FilamentAlertBox\AlertBuilder;

class AlertBoxManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clear alerts before each test
        AlertBoxManager::clearAll();
    }

    public function test_can_create_alert_builder(): void
    {
        $builder = AlertBoxManager::make('Test Title');
        
        $this->assertInstanceOf(AlertBuilder::class, $builder);
    }

    public function test_can_create_alert_without_title(): void
    {
        $builder = AlertBoxManager::make();
        
        $this->assertInstanceOf(AlertBuilder::class, $builder);
    }

    public function test_alert_count_increases_after_adding(): void
    {
        $initialCount = AlertBoxManager::getAlertCount();
        
        AlertBoxManager::make('Test')->success()->show();
        
        $this->assertEquals($initialCount + 1, AlertBoxManager::getAlertCount());
    }

    public function test_can_clear_all_alerts(): void
    {
        // Add some alerts
        AlertBoxManager::make('Test 1')->success()->show();
        AlertBoxManager::make('Test 2')->danger()->show();
        
        $this->assertGreaterThan(0, AlertBoxManager::getAlertCount());
        
        AlertBoxManager::clearAll();
        
        $this->assertEquals(0, AlertBoxManager::getAlertCount());
    }
}
