<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .docs-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            margin-top: 0;
            line-height: 1.2;
        }
        .docs-content h2 {
            font-size: 1.875rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        .docs-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .docs-content p {
            margin-bottom: 1rem;
            line-height: 1.75;
            font-size: 1.125rem;
        }
        .docs-content ul, .docs-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
            line-height: 1.75;
        }
        .docs-content ul {
            list-style-type: disc;
        }
        .docs-content ol {
            list-style-type: decimal;
        }
        .docs-content li {
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }
        .docs-content code {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-family: ui-monospace, monospace;
            color: #FF2D20;
        }
        .docs-content pre {
            background-color: #1a1a1a;
            color: #e5e5e5;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1rem;
            border: 1px solid #333;
        }
        .docs-content pre code {
            background-color: transparent;
            padding: 0;
            color: inherit;
            font-size: 0.875rem;
        }
        .docs-content strong {
            font-weight: 600;
        }
        .docs-content a {
            color: #FF2D20;
            text-decoration: none;
        }
        .docs-content a:hover {
            text-decoration: underline;
        }
        @media (prefers-color-scheme: dark) {
            .docs-content h1,
            .docs-content h2,
            .docs-content h3 {
                color: #fff;
            }
            .docs-content p,
            .docs-content li {
                color: #d1d5db;
            }
            .docs-content code {
                background-color: rgba(255, 255, 255, 0.1);
                color: #FF4433;
            }
            .docs-content strong {
                color: #fff;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-black text-gray-900 dark:text-white font-sans antialiased">
    <div class="min-h-screen py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-[#FF2D20] hover:text-[#FF2D20]/80 font-semibold transition">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Home
                </a>
            </div>
            
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg p-8 lg:p-12 ring-1 ring-gray-200 dark:ring-zinc-800 docs-content">
                {!! \Illuminate\Support\Str::markdown($content) !!}
            </div>
        </div>
    </div>
</body>
</html>
