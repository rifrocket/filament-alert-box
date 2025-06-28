{{-- 
    Unified Alert Layout - Pure Tailwind CSS Card-based Alert System with Dark Mode Support
    
    Features:
    - Full dark/light mode compatibility using Tailwind CSS dark: variants
    - Automatic theme detection via Tailwind's dark mode classes
    - FilamentPHP compatible color schemes
    - Maintains all existing functionality while adding theme support
    
    Dark Mode Implementation:
    - Uses Tailwind's dark: prefix for all color variants
    - Provides appropriate contrast ratios for both themes
    - Supports all alert types (success, warning, error, info) in both modes
    - Close button hover states adapted for both themes
--}}
@if (!empty($alerts))
    @foreach ($alerts as $alert)
        @php
            // Get card style type (1-4)
            $styleType = $alert['style_type'] ?? 1;
            $alertType = $alert['type'] ?? 'info';

            // Set color scheme based on alert type with dark mode support
            $colorScheme = match ($alertType) {
                'success' => [
                    'bg' => 'green',
                    'text' => 'green',
                    'border' => 'green',
                    'lightBg' => 'bg-green-50',
                    'darkBg' => 'dark:bg-green-900/20',
                    'lightText' => 'text-green-800',
                    'darkText' => 'dark:text-green-200',
                    'lightBorder' => 'border-green-200',
                    'darkBorder' => 'dark:border-green-800',
                    'lightIconBg' => 'bg-green-100',
                    'darkIconBg' => 'dark:bg-green-800/50',
                    'lightIcon' => 'text-green-500',
                    'darkIcon' => 'dark:text-green-400',
                    'lightDesc' => 'text-green-700',
                    'darkDesc' => 'dark:text-green-300',
                ],
                'warning' => [
                    'bg' => 'yellow',
                    'text' => 'yellow',
                    'border' => 'yellow',
                    'lightBg' => 'bg-yellow-50',
                    'darkBg' => 'dark:bg-yellow-900/20',
                    'lightText' => 'text-yellow-800',
                    'darkText' => 'dark:text-yellow-200',
                    'lightBorder' => 'border-yellow-200',
                    'darkBorder' => 'dark:border-yellow-800',
                    'lightIconBg' => 'bg-yellow-100',
                    'darkIconBg' => 'dark:bg-yellow-800/50',
                    'lightIcon' => 'text-yellow-500',
                    'darkIcon' => 'dark:text-yellow-400',
                    'lightDesc' => 'text-yellow-700',
                    'darkDesc' => 'dark:text-yellow-300',
                ],
                'error', 'danger' => [
                    'bg' => 'red',
                    'text' => 'red',
                    'border' => 'red',
                    'lightBg' => 'bg-red-50',
                    'darkBg' => 'dark:bg-red-900/20',
                    'lightText' => 'text-red-800',
                    'darkText' => 'dark:text-red-200',
                    'lightBorder' => 'border-red-200',
                    'darkBorder' => 'dark:border-red-800',
                    'lightIconBg' => 'bg-red-100',
                    'darkIconBg' => 'dark:bg-red-800/50',
                    'lightIcon' => 'text-red-500',
                    'darkIcon' => 'dark:text-red-400',
                    'lightDesc' => 'text-red-700',
                    'darkDesc' => 'dark:text-red-300',
                ],
                default => [
                    'bg' => 'blue',
                    'text' => 'blue',
                    'border' => 'blue',
                    'lightBg' => 'bg-blue-50',
                    'darkBg' => 'dark:bg-blue-900/20',
                    'lightText' => 'text-blue-800',
                    'darkText' => 'dark:text-blue-200',
                    'lightBorder' => 'border-blue-200',
                    'darkBorder' => 'dark:border-blue-800',
                    'lightIconBg' => 'bg-blue-100',
                    'darkIconBg' => 'dark:bg-blue-800/50',
                    'lightIcon' => 'text-blue-500',
                    'darkIcon' => 'dark:text-blue-400',
                    'lightDesc' => 'text-blue-700',
                    'darkDesc' => 'dark:text-blue-300',
                ],
            };

            // Set container classes based on style type with dark mode support
            $containerClasses = match ($styleType) {
                1 => "p-4 {$colorScheme['lightBg']} {$colorScheme['darkBg']} border-l-4 {$colorScheme['lightBorder']} {$colorScheme['darkBorder']}", // Banner Style
                2 => "p-4 {$colorScheme['lightBg']} {$colorScheme['darkBg']} border {$colorScheme['lightBorder']} {$colorScheme['darkBorder']} rounded-lg", // Card with Border
                3 => "p-4 bg-white dark:bg-gray-800 border {$colorScheme['lightBorder']} {$colorScheme['darkBorder']} rounded-lg", // Modern Card
                default => "p-4 {$colorScheme['lightBg']} {$colorScheme['darkBg']} rounded-lg", // Minimalist
            };

            // Icon size configuration
            $iconSize = $alert['icon_size'] ?? 'm';
            $iconDimensions = match ($iconSize) {
                'xs' => ['icon' => 'w-3 h-3', 'wrapper' => 'p-1', 'button' => 'w-3 h-3'],
                's' => ['icon' => 'w-4 h-4', 'wrapper' => 'p-1.5', 'button' => 'w-4 h-4'],
                'm' => ['icon' => 'w-6 h-6', 'wrapper' => 'p-2', 'button' => 'w-5 h-5'],
                'lg' => ['icon' => 'w-8 h-8', 'wrapper' => 'p-3', 'button' => 'w-6 h-6'],
                'xl' => ['icon' => 'w-10 h-10', 'wrapper' => 'p-4', 'button' => 'w-7 h-7'],
                default => ['icon' => 'w-6 h-6', 'wrapper' => 'p-2', 'button' => 'w-5 h-5'],
            };

            $iconWrapperClasses = "flex-shrink-0 {$colorScheme['lightIconBg']} {$colorScheme['darkIconBg']} {$iconDimensions['wrapper']} rounded-full";
            $iconSizeClasses = "{$iconDimensions['icon']} {$colorScheme['lightIcon']} {$colorScheme['darkIcon']}";
            $iconColorClasses = $alert['icon_color'] ? "color: {$alert['icon_color']}" : '';
            $titleSize = 'text-base';
            $titleClasses = "{$titleSize} font-medium {$colorScheme['lightText']} {$colorScheme['darkText']}";
            $titleColorStyle = $alert['title_color'] ? "color: {$alert['title_color']}" : '';
            $descriptionClasses = "text-sm {$colorScheme['lightDesc']} {$colorScheme['darkDesc']} opacity-90 mt-1";
            $descriptionStyle = $alert['description_color'] ? "color: {$alert['description_color']}" : '';
            $buttonColorClasses = "{$colorScheme['lightIcon']} {$colorScheme['darkIcon']} hover:{$colorScheme['lightText']} hover:{$colorScheme['darkText']}";
            $spacingClasses = $styleType === 4 ? 'space-x-2' : 'space-x-3';
            $buttonIconSize = $iconDimensions['button'];
        @endphp

        {{-- Alert Card with explicit Tailwind classes --}}
        <div class="mb-4 {{ $alert['classes'] }}" id="alert-{{ $alert['id'] }}" style="{{ $alert['style'] }}"
            @if ($alert['auto_hide'] && !$alert['permanent']) x-data="{ show: true }"
                x-init="setTimeout(() => show = false, {{ $alert['timeout'] }})"
                x-show="show"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @endif>

            {{-- Single unified container with dynamic classes --}}
            <div class="{{ $containerClasses }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center {{ $spacingClasses }}">
                        {{-- Icon --}}
                        @if (!$alert['noIcon'] && $alert['icon'])
                            <div class="{{ $iconWrapperClasses }}">
                                <x-filament::icon :icon="$alert['icon']" class="{{ $iconSizeClasses }}" style="{{ $iconColorClasses }}" />
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="flex-1">
                            @if ($alert['title'])
                                @if ($styleType === 4)
                                    <span class="{{ $titleClasses }} text-lg font-bold" style="{{ $titleColorStyle }}" >
                                        {{ $alert['title'] }}:
                                    </span>
                                @else
                                    <h3 class="{{ $titleClasses }} text-lg font-bold " style="{{ $titleColorStyle }}" >
                                        {{ $alert['title'] }}
                                    </h3>
                                @endif
                            @endif

                            @if ($alert['description'])
                                @if ($styleType === 4)
                                    <span class="{{ $descriptionClasses }}" style="{{ $descriptionStyle }}" >
                                        {{ $alert['description'] }}
                                    </span>
                                @else
                                    <p class="{{ $descriptionClasses }}" style="{{ $descriptionStyle }}" >
                                        {{ $alert['description'] }}
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Close button (always on the right) --}}
                    @if ($alert['closeable'])
                        <div class="flex-shrink-0 ml-4">
                            <button type="button"
                                class="transition-colors duration-200 p-1 rounded-md hover:bg-black hover:bg-opacity-5 dark:hover:bg-white dark:hover:bg-opacity-10 {{ $buttonColorClasses }}"
                                onclick="this.closest('[id^=alert-]').remove()" aria-label="Close alert">
                                <x-filament::icon icon="heroicon-m-x-mark" class="{{ $buttonIconSize }}" />
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif
