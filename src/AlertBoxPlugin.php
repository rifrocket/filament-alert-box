<?php

namespace RifRocket\FilamentAlertBox;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Config;

class AlertBoxPlugin implements Plugin
{
    protected bool $enabled = true;
    public string $view = 'alert-box::layouts.unified-alert';

    public function getId(): string
    {
        return 'alert-box';
    }

    public function register(Panel $panel): void
    {
        if (!$this->enabled) {
            return;
        }

        // Register a single render hook that dynamically renders alerts based on position
        $this->registerDynamicRenderHooks($panel);
        $this->defineColors();
    }

    public function boot(Panel $panel): void
    {
        //
    }

    /**
     * Register dynamic render hooks for all possible positions
     */
    protected function registerDynamicRenderHooks(Panel $panel): void
    {
        $hooks = [
            PanelsRenderHook::PAGE_HEADER_WIDGETS_AFTER,
            PanelsRenderHook::PAGE_START,
            PanelsRenderHook::SIDEBAR_NAV_END,
            PanelsRenderHook::TOPBAR_START,
            PanelsRenderHook::PAGE_END,
            PanelsRenderHook::FOOTER,
        ];

        foreach ($hooks as $hook) {
            $panel->renderHook(
                $hook,
                function () use ($hook) {
                    $alerts = AlertBoxManager::getAlerts($hook);
                    if (empty($alerts)) {
                        return '';
                    }

                    // Use single unified Blade file for all layout types
                    return \view($this->view, [
                        'alerts' => $alerts,
                        'position' => $hook, // Pass position to help determine layout type
                    ]);
                },
                
            );
        }
    }

    /**
     * Enable or disable the plugin
     */
    public function enabled(bool $enabled = true): static
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Disable the plugin
     */
    public function disable(bool $disable = true): static
    {
        $this->enabled = !$disable;
        return $this;
    }

    /**
     * Create a new instance of the plugin
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * Set the view for the alert box layout
     */
    public function view(string $view): self
    {
        $this->view = $view;
        return $this;
    }


    /**
     * Define default colors for alert types
     */
    public function defineColors(array $colors = []): self
    {
        Config::set('alert-box.colors', $colors ?: [
            'success' => [
                'title'       => '#047857',
                'description' => '#10b981',
                'icon'        => '#10b981',
            ],
            'danger' => [
                'title'       => '#b91c1c',
                'description' => '#ef4444',
                'icon'        => '#ef4444',
            ],
            'warning' => [
                'title'       => '#b45309',
                'description' => '#f59e0b',
                'icon'        => '#f59e0b',
            ],
            'info' => [
                'title'       => '#1d4ed8',
                'description' => '#3b82f6',
                'icon'        => '#3b82f6',
            ],
        ]);
        return $this;
    }
}
