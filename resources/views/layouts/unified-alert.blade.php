{{-- Unified Alert Layout - Pure Tailwind CSS Card-based Alert System --}}
@if (!empty($alerts))
    @foreach ($alerts as $alert)
        @php
            // Get card style type (1-4)
            $styleType = $alert['style_type'] ?? 1;
            $alertType = $alert['type'] ?? 'info';

            // Set color scheme based on alert type
            $colorScheme = match ($alertType) {
                'success' => [
                    'bg' => 'green',
                    'text' => 'green',
                    'border' => 'green',
                ],
                'warning' => [
                    'bg' => 'yellow',
                    'text' => 'yellow',
                    'border' => 'yellow',
                ],
                'error', 'danger' => [
                    'bg' => 'red',
                    'text' => 'red',
                    'border' => 'red',
                ],
                default => [
                    'bg' => 'blue',
                    'text' => 'blue',
                    'border' => 'blue',
                ],
            };

            // Set container classes based on style type
            $containerClasses = match ($styleType) {
                1 => "p-4 bg-{$colorScheme['bg']}-50 border-l-4 border-{$colorScheme['border']}-200", // Banner Style
                2 => "p-4 bg-{$colorScheme['bg']}-50 border border-{$colorScheme['border']}-200 rounded-lg", // Card with Border
                3 => "p-4 bg-white border border-{$colorScheme['border']}-200 rounded-lg", // Modern Card
                default => "p-4 bg-{$colorScheme['bg']}-50 rounded-lg", // Minimalist
            };

            $iconWrapperClasses = "flex-shrink-0 bg-{$colorScheme['bg']}-100 p-2 rounded-full";
            $iconSizeClasses = "w-6 h-6 text-{$colorScheme['text']}-500";
            $iconColorClasses = $alert['icon_color'] ? "color: {$alert['icon_color']}" : '';
            $titleSize = 'text-base';
            $titleClasses = "{$titleSize} font-medium text-{$colorScheme['text']}-800";
            $titleColorStyle = $alert['title_color'] ? "color: {$alert['title_color']}" : '';
            $descriptionClasses = "text-sm text-{$colorScheme['text']}-700 opacity-90 mt-1";
            $descriptionStyle = $alert['description_color'] ? "color: {$alert['description_color']}" : 'color: #64748b';
            $buttonColorClasses = "text-{$colorScheme['text']}-500 hover:text-{$colorScheme['text']}-600";
            $spacingClasses = $styleType === 4 ? 'space-x-2' : 'space-x-3';
            $buttonIconSize = $styleType === 4 ? 'w-4 h-4' : 'w-5 h-5';
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
                                class="transition-colors duration-200 p-1 rounded-md hover:bg-black hover:bg-opacity-5 {{ $buttonColorClasses }}"
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
