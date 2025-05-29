<x-layouts.app>
    <!-- Form Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            @can('settings-update')
                <form action="{{ route('page-settings.update') }}" method="POST">
                    @csrf
                @endcan
                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('Edit Page Settings') }}</h3>

                        <div>
                            <x-forms.input label="{{ __('Title') }}" name="title" placeholder="{{ __('Enter title') }}"
                                value="{{ $setting->title }}" />
                        </div>
                        <div>
                            <x-forms.checkbox label="{{ __('Maintenance Mode') }}" name="maintenance_mode" :checked="$setting->maintenance_mode"
                                value="1" />
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Cancel') }}
                        </a>
                        @can('settings-update')
                            <x-buttons.primary type="submit">
                                {{ __('Update Settings') }}
                            </x-buttons.primary>
                        @endcan
                    </div>
                </div>
                @can('settings-update')
                </form>
            @endcan
        </div>
    </div>
</x-layouts.app>
