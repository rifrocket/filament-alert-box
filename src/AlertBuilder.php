<?php

declare(strict_types=1);

namespace RifRocket\FilamentAlertBox;

use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

/**
 * Alert Builder
 *
 * Provides a fluent API for building alerts with chainable methods.
 * Supports multiple layout types and positioning via Filament render hooks.
 *
 * @author Mohammad Arif <mohammad.arif9999@gmail.com>
 */
final class AlertBuilder
{
    /**
     * Alert configuration
     */
    private array $definedColors = [];

    private array $config = [
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
     * Render hook position
     */
    private string $position = PanelsRenderHook::PAGE_HEADER_WIDGETS_AFTER;

    /**
     * Valid alert types
     */
    private const VALID_TYPES = ['info', 'success', 'warning', 'danger', 'error'];

    /**
     * Valid card styles (1-4)
     */
    private const VALID_STYLES = [1, 2, 3, 4];

    public function __construct(?string $title = null)
    {
        // Safely get Filament colors with fallback
        try {
            $this->definedColors = Filament::getCurrentPanel()?->getColors() ?? [];
        } catch (\Exception $e) {
            $this->definedColors = [];
        }

        $this->defineColors();
        $this->config['id'] = uniqid('alert_', true);
        $this->config['style_type'] = 1; // Default card style

        if ($title !== null && $title !== '') {
            $this->config['title'] = $title;
        }
    }

    /**
     * Set the alert title
     */
    public function title(string $title): self
    {
        if (empty($title)) {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        $this->config['title'] = $title;

        return $this;
    }

    /**
     * Set the alert description
     */
    public function description(string $description): self
    {
        $this->config['description'] = $description;

        return $this;
    }

    /**
     * Set the alert message (alias for description)
     */
    public function message(string $message): self
    {
        return $this->description($message);
    }

    /**
     * Set card style type (1-4)
     */
    public function cardStyle(int $style): self
    {
        if (! in_array($style, self::VALID_STYLES, true)) {
            throw new InvalidArgumentException(
                sprintf('Card style must be between 1 and 4, got %d', $style)
            );
        }

        $this->config['style_type'] = $style;

        return $this;
    }

    /**
     * Card Style 1: Simple Banner
     */
    public function bannerStyle(): self
    {
        $this->config['style_type'] = 1;

        return $this;
    }

    /**
     * Card Style 2: Card with Border
     */
    public function cardWithBorder(): self
    {
        $this->config['style_type'] = 2;

        return $this;
    }

    /**
     * Card Style 3: Modern Card
     */
    public function modernCard(): self
    {
        $this->config['style_type'] = 3;

        return $this;
    }

    /**
     * Card Style 4: Minimalist
     */
    public function minimalistStyle(): self
    {
        $this->config['style_type'] = 4;

        return $this;
    }

    /**
     * Set alert icon
     */
    public function icon(string $icon): self
    {
        if (empty($icon)) {
            throw new InvalidArgumentException('Icon cannot be empty');
        }

        $this->config['icon'] = $icon;

        return $this;
    }

    /**
     * Remove/disable the alert icon
     */
    public function noIcon(bool $state = true): self
    {
        $this->config['icon'] = null;
        $this->config['noIcon'] = $state;
        $this->config['icon_color'] = null;

        return $this;
    }

    /**
     * Set icon color
     */
    public function iconColor(string $color): self
    {
        $this->config['icon_color'] = $this->validateColor($color);

        return $this;
    }

    /**
     * Set title color
     */
    public function titleColor(string $color): self
    {
        $this->config['title_color'] = $this->validateColor($color);

        return $this;
    }

    /**
     * Set description color
     */
    public function descriptionColor(string $color): self
    {
        $this->config['description_color'] = $this->validateColor($color);

        return $this;
    }

    /**
     * Validate color value (CSS color, hex, rgb, hsl, or named colors)
     */
    private function validateColor(string $color): string
    {
        if (empty($color)) {
            throw new InvalidArgumentException('Color cannot be empty');
        }

        // Allow common CSS color formats: hex, rgb, rgba, hsl, hsla, named colors
        if (preg_match('/^(#[0-9a-fA-F]{3,8}|rgb|hsl|[a-zA-Z]+)/', $color)) {
            return $color;
        }

        throw new InvalidArgumentException("Invalid color format: {$color}");
    }

    /**
     * Set alert as success type
     */
    public function success(): self
    {
        $this->config['type'] = 'success';
        if (! $this->config['icon']) {
            $this->config['icon'] = 'heroicon-o-check-circle';
        }
        $this->config['title_color'] = $this->config['title_color'] ?? ($this->definedColors['success']['title'] ?? '#047857');
        $this->config['description_color'] = $this->config['description_color'] ?? ($this->definedColors['success']['description'] ?? '#10b981');
        $this->config['icon_color'] = $this->config['icon_color'] ?? ($this->definedColors['success']['icon'] ?? '#10b981');

        return $this;
    }

    /**
     * Set alert as danger/error type
     */
    public function danger(): self
    {
        $this->config['type'] = 'danger';
        if (! $this->config['icon']) {
            $this->config['icon'] = 'heroicon-o-x-circle';
        }
        $this->config['title_color'] = $this->config['title_color'] ?? ($this->definedColors['danger']['title'] ?? '#b91c1c');
        $this->config['description_color'] = $this->config['description_color'] ?? ($this->definedColors['danger']['description'] ?? '#ef4444');
        $this->config['icon_color'] = $this->config['icon_color'] ?? ($this->definedColors['danger']['icon'] ?? '#ef4444');

        return $this;
    }

    /**
     * Set alert as error type (alias for danger)
     */
    public function error(): self
    {
        return $this->danger();
    }

    /**
     * Set alert as warning type
     */
    public function warning(): self
    {
        $this->config['type'] = 'warning';
        if (! $this->config['icon']) {
            $this->config['icon'] = 'heroicon-o-exclamation-triangle';
        }
        $this->config['title_color'] = $this->config['title_color'] ?? ($this->definedColors['warning']['title'] ?? '#b45309');
        $this->config['description_color'] = $this->config['description_color'] ?? ($this->definedColors['warning']['description'] ?? '#f59e0b');
        $this->config['icon_color'] = $this->config['icon_color'] ?? ($this->definedColors['warning']['icon'] ?? '#f59e0b');

        return $this;
    }

    /**
     * Set alert as info type
     */
    public function info(): self
    {
        $this->config['type'] = 'info';
        if (! $this->config['icon']) {
            $this->config['icon'] = 'heroicon-o-information-circle';
        }
        $this->config['title_color'] = $this->config['title_color'] ?? ($this->definedColors['info']['title'] ?? '#1d4ed8');
        $this->config['description_color'] = $this->config['description_color'] ?? ($this->definedColors['info']['description'] ?? '#3b82f6');
        $this->config['icon_color'] = $this->config['icon_color'] ?? ($this->definedColors['info']['icon'] ?? '#3b82f6');

        return $this;
    }

    /**
     * Make alert closeable
     */
    public function canBeClose(bool $closeable = true): self
    {
        $this->config['closeable'] = $closeable;

        return $this;
    }

    /**
     * Set auto disappear with timeout in seconds
     */
    public function autoDisappear(int $seconds): self
    {
        if ($seconds <= 0) {
            throw new InvalidArgumentException('Timeout must be greater than 0');
        }

        $this->config['auto_hide'] = true;
        $this->config['timeout'] = $seconds * 1000; // Convert to milliseconds
        $this->config['permanent'] = false;

        return $this;
    }

    /**
     * Make alert permanent (won't auto-hide)
     */
    public function permanent(bool $permanent = true): self
    {
        $this->config['permanent'] = $permanent;
        if ($permanent) {
            $this->config['auto_hide'] = false;
        }

        return $this;
    }

    /**
     * Add custom CSS classes
     */
    public function classes(string $classes): self
    {
        $this->config['classes'] = $classes;

        return $this;
    }

    /**
     * Add custom inline styles
     */
    public function style(string $style): self
    {
        $this->config['style'] = $style;

        return $this;
    }

    /**
     * Set position
     */
    public function position(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Set position using PanelsRenderHook constants
     */
    public function renderHook(string $hook): self
    {
        $this->position = $hook;

        return $this;
    }

    /**
     * Quick position methods
     */
    public function pageHeaderAfter(): self
    {
        $this->position = PanelsRenderHook::PAGE_HEADER_WIDGETS_AFTER;

        return $this;
    }

    public function pageStart(): self
    {
        $this->position = PanelsRenderHook::PAGE_START;

        return $this;
    }

    public function sidebarNavEnd(): self
    {
        $this->position = PanelsRenderHook::SIDEBAR_NAV_END;

        return $this;
    }

    public function topBarStart(): self
    {
        $this->position = PanelsRenderHook::TOPBAR_START;

        return $this;
    }

    public function pageEnd(): self
    {
        $this->position = PanelsRenderHook::PAGE_END;

        return $this;
    }

    public function footer(): self
    {
        $this->position = PanelsRenderHook::FOOTER;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * Show the alert (finalize and render)
     */
    public function show(): void
    {
        // Use the position directly
        AlertBoxManager::addAlert($this->getPosition(), $this->config);
    }

    /**
     * Get the configuration array
     */
    public function toArray(): array
    {
        return $this->config;
    }

    private function defineColors(): void
    {
        $this->definedColors = Config::get('alert-box.colors', []);
    }

    /**
     * Get defined colors for a specific color name
     */
    private function getDefinedColors(string $colorName): array
    {
        return $this->definedColors[$colorName] ?? [];
    }
}
