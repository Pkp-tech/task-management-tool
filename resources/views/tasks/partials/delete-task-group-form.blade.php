<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'delete-task-group-{{$taskGroup->id}}')"
    >{{ __('Delete') }}</x-danger-button>

    <x-modal name="delete-task-group-{{$taskGroup->id}}" :show="$errors->taskGroupValidation->isNotEmpty()" focusable>
        <form method="post" action="{{ route('task-group.destroy', ['id' => $taskGroup->id]) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once this task group is deleted, all of its resources and data will be permanently deleted.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="task-group-name" value="{{ __('task-group-name') }}" class="sr-only" />

                <x-text-input
                    id="task-group-name"
                    name="task-group-name"
                    type="text"
                    disabled
                    class="mt-1 block w-3/4"
                    value="{{$taskGroup->name}}"
                />

                <x-text-input
                    id="task-group-id"
                    name="task-group-id"
                    type="text"
                    hidden
                    value="{{$taskGroup->id}}"
                />

                <x-input-error :messages="$errors->taskGroupValidation->get('task-group-name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Task Group') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
