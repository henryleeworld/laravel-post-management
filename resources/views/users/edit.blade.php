<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('Edit User') }}</h3>

                        <div>
                            <x-forms.input label="Name" name="name" placeholder="{{ __('Enter name') }}"
                                value="{{ $user->name }}" />
                        </div>
                        <div>
                            <x-forms.input label="Email" name="email" placeholder="{{ __('Enter email') }}"
                                value="{{ $user->email }}" />
                        </div>
                        <div>
                            <x-forms.input type="password" label="Password" name="password"
                                placeholder="{{ __('Enter password') }}" />
                        </div>
                        <div>
                            <x-forms.select label="Role" name="role" :options="$roles" optionKey="name"
                                value="{{ $user->roles->pluck('name')->first() }}" optionValue="name" />
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('users.index') }}"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Cancel') }}
                        </a>
                        <x-buttons.primary type="submit">
                            {{ __('Update User') }}
                        </x-buttons.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
