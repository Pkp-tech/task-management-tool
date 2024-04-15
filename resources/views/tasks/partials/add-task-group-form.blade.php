<section class="space-y-6">
    <!-- <header>
            <button type="button" class="inline-flex items-center justify-center h-9 px-4 rounded-xl bg-blue-500 text-white text-sm font-semibold transition hover:bg-blue-600" onclick="addTaskGroup()">
                Add Task Group
            </button>
    </header> -->

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

            <!-- <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p> -->

            <!-- <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div> -->

            <div class="mt-6">
                <x-input-label for="task-group-name" value="{{ __('task-group-name') }}" class="sr-only" />

                <x-text-input
                    id="task-group-name"
                    name="task-group-name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Task Group Name') }}"
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
