<x-layouts.app>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <h3
                            class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('Edit Post') }}</h3>

                        <div>
                            <x-forms.input label="{{ __('Title') }}" name="title" placeholder="{{ __('Enter title') }}"
                                value="{{ $post->title }}" />
                        </div>
                        <div>
                            <x-forms.input label="{{ __('Slug') }}" name="slug" placeholder="{{ __('Enter slug') }}"
                                value="{{ $post->slug }}" />
                        </div>
                        <div>
                            <x-forms.textarea label="{{ __('Content') }}" name="content"
                                placeholder="{{ __('Enter content') }}">{{ $post->content }}</x-forms.textarea>
                        </div>
                        @can('publish', \App\Models\Post::class)
                            <div>
                                <x-forms.checkbox label="{{ __('Published') }}" name="is_published" :checked="$post->is_published" value="1" />
                            </div>
                        @endcan
                        <div>
                            <x-forms.input label="{{ __('Meta Title') }}" name="meta_title" placeholder="{{ __('Enter meta title') }}"
                                value="{{ $post->meta_title }}" />
                        </div>
                        <div>
                            <x-forms.textarea label="{{ __('Meta Description') }}" name="meta_description"
                                placeholder="{{ __('Enter meta description') }}">{{ $post->meta_description }}</x-forms.textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('posts.index') }}"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Cancel') }}
                        </a>
                        <x-buttons.primary type="submit">
                            {{ __('Update Post') }}
                        </x-buttons.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
