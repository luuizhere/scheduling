<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($whitelabel) ? $whitelabel['name'] : config('app.name') }}</title>

    @if(isset($whitelabel))
    <style>
        :root {
            --primary-color: {{ $whitelabel['colors']['primary'] }};
            --secondary-color: {{ $whitelabel['colors']['secondary'] }};
        }
        .btn-primary {
            background-color: var(--primary-color);
        }
        .text-primary {
            color: var(--primary-color);
        }
        .bg-primary {
            background-color: var(--primary-color);
        }
        .border-primary {
            border-color: var(--primary-color);
        }
    </style>
    @endif
</head>
<body>
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    @if(isset($whitelabel) && $whitelabel['logo'])
                        <img src="{{ Storage::url($whitelabel['logo']) }}"
                             alt="{{ $whitelabel['name'] }}"
                             class="h-8 w-auto self-center">
                    @else
                        <span class="self-center text-xl font-semibold">
                            {{ config('app.name') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
