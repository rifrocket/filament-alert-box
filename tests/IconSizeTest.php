<?php

declare(strict_types=1);

namespace RifRocket\FilamentAlertBox\Tests;

use InvalidArgumentException;
use RifRocket\FilamentAlertBox\AlertBuilder;

class IconSizeTest extends TestCase
{
    public function test_default_icon_size_is_medium(): void
    {
        $alert = new AlertBuilder('Test Alert');
        $config = $alert->toArray();
        
        $this->assertEquals('m', $config['icon_size']);
    }

    public function test_can_set_icon_size_using_method(): void
    {
        $alert = new AlertBuilder('Test Alert');
        $alert->iconSize('lg');
        $config = $alert->toArray();
        
        $this->assertEquals('lg', $config['icon_size']);
    }

    public function test_can_set_icon_size_using_convenience_methods(): void
    {
        $testCases = [
            ['iconXS', 'xs'],
            ['iconS', 's'],
            ['iconM', 'm'],
            ['iconLG', 'lg'],
            ['iconXL', 'xl'],
        ];

        foreach ($testCases as [$method, $expectedSize]) {
            $alert = new AlertBuilder('Test Alert');
            $alert->$method();
            $config = $alert->toArray();
            
            $this->assertEquals($expectedSize, $config['icon_size'], "Method {$method} should set size to {$expectedSize}");
        }
    }

    public function test_invalid_icon_size_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Icon size must be one of: xs, s, m, lg, xl, got invalid');
        
        $alert = new AlertBuilder('Test Alert');
        $alert->iconSize('invalid');
    }

    public function test_icon_size_is_case_insensitive(): void
    {
        $alert = new AlertBuilder('Test Alert');
        $alert->iconSize('XL');
        $config = $alert->toArray();
        
        $this->assertEquals('xl', $config['icon_size']);
    }

    public function test_no_icon_resets_size_to_default(): void
    {
        $alert = new AlertBuilder('Test Alert');
        $alert->iconSize('xl');
        $alert->noIcon(true);
        $config = $alert->toArray();
        
        $this->assertEquals('m', $config['icon_size']);
    }

    public function test_method_chaining_works_with_icon_sizes(): void
    {
        $alert = new AlertBuilder('Test Alert');
        $result = $alert->success()->iconLG()->description('Test description');
        
        $this->assertInstanceOf(AlertBuilder::class, $result);
        
        $config = $alert->toArray();
        $this->assertEquals('success', $config['type']);
        $this->assertEquals('lg', $config['icon_size']);
        $this->assertEquals('Test description', $config['description']);
    }
}
