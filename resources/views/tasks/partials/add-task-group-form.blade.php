<section class="space-y-6">
 
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'add-task-group')"
    >{{ __('Add Task Group') }}</x-danger-button>

    <x-modal name="add-task-group" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('task-group.add') }}" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add your task group name') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="task-group-name" value="{{ __('task-group-name') }}" class="sr-only" />

                <x-text-input
                    id="task-group-name"
                    name="task-group-name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Task Group Name') }}"
                    required
                />

                <x-input-error :messages="$errors->userDeletion->get('task-group-name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Add Task Group') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
