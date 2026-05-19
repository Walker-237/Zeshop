<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.settings.users')"
        current="Edit User"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.settings.users')"
            title="Staff"
        />
    </x-shopper::breadcrumb>

    <x-shopper::heading class="my-6" title="Edit User">
        <x-slot name="description">
            Update account details, password, and role assignment.
        </x-slot>
    </x-shopper::heading>

    <form wire:submit="update" class="max-w-3xl">
        <x-shopper::card class="p-6">
            {{ $this->form }}

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-shopper::buttons.default :link="route('shopper.settings.users')">
                    Cancel
                </x-shopper::buttons.default>
                <x-shopper::buttons.primary type="submit">
                    Save Changes
                </x-shopper::buttons.primary>
            </div>
        </x-shopper::card>
    </form>
</x-shopper::container>
