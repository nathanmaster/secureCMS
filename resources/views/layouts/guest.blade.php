<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>
        
        <!-- Meta Description -->
        <meta name="description" content="{{ $description ?? 'SecureCMS - A modern content management system' }}">
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional Head Content -->
        @stack('head')
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased h-full bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="mb-6">
                <a href="{{ route('menu') }}" class="flex items-center">
                    <x-application-logo class="w-16 h-16 fill-current text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors" />
                    <span class="ml-3 text-xl font-bold text-gray-900 dark:text-gray-100">{{ config('app.name', 'SecureCMS') }}</span>
                </a>
            </div>

            <!-- Content Card -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SecureCMS') }}. All rights reserved.
                </p>
            </div>
        </div>
        
        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>
