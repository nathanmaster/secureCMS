@props([
    'title' => null,
    'subtitle' => null,
    'breadcrumbs' => [],
    'actions' => null,
    'tabs' => null,
    'activeTab' => null
])

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <!-- Breadcrumbs -->
                    @if(!empty($breadcrumbs))
                        <div class="mb-4">
                            <x-breadcrumb :items="$breadcrumbs" />
                        </div>
                    @endif
                    
                    <!-- Title -->
                    @if($title)
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $title }}
                        </h1>
                    @endif
                    
                    <!-- Subtitle -->
                    @if($subtitle)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
                
                <!-- Actions -->
                @if($actions)
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        {{ $actions }}
                    </div>
                @endif
            </div>
            
            <!-- Tabs -->
            @if($tabs)
                <div class="mt-6">
                    <x-tabs :active="$activeTab">
                        <x-tabs.nav :tabs="$tabs" />
                    </x-tabs>
                </div>
            @endif
        </div>
        
        <!-- Content -->
        <div class="space-y-6">
            {{ $slot }}
        </div>
    </div>
</div>
