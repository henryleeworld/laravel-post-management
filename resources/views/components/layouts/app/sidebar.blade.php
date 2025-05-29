            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <div class="h-full flex flex-col">
                    <!-- Sidebar Menu -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                        <ul class="space-y-1 px-2">
                            <!-- Dashboard -->
                            <x-layouts.sidebar-link href="{{ route('dashboard') }}" icon='fas-house'
                                :active="request()->routeIs('dashboard*')">{{ __('Dashboard') }}</x-layouts.sidebar-link>
                            @can('view', \App\Models\Post::class)
                                <x-layouts.sidebar-link href="{{ route('posts.index') }}" icon='fas-file-alt'
                                    :active="request()->routeIs('posts*')">{{ __('Posts') }}</x-layouts.sidebar-link>
                            @endcan
                            @can('view', \App\Models\Setting::class)
                                <x-layouts.sidebar-link href="{{ route('page-settings.index') }}" icon='fas-gear'
                                    :active="request()->routeIs('page-settings*')">{{ __('Page Settings') }}</x-layouts.sidebar-link>
                            @endcan
                            @can('view', \App\Models\User::class)
                                <x-layouts.sidebar-link href="{{ route('users.index') }}" icon='fas-users'
                                    :active="request()->routeIs('users*')">{{ __('Users') }}</x-layouts.sidebar-link>
                            @endcan
                        </ul>
                    </nav>
                </div>
            </aside>
