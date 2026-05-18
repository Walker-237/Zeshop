<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.settings.users')"
        current="Create Staff User"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.settings.users')"
            title="Staff"
        />
    </x-shopper::breadcrumb>

    <x-shopper::heading class="my-6" title="Create Staff User">
        <x-slot name="description">
            Add an internal account and assign its role.
        </x-slot>
    </x-shopper::heading>

    <form wire:submit="create" class="max-w-3xl">
        <x-shopper::card class="p-6">
            {{ $this->form }}

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-shopper::buttons.default :link="route('shopper.settings.users')">
                    Cancel
                </x-shopper::buttons.default>
                <x-shopper::buttons.primary type="submit">
                    Create Staff User
                </x-shopper::buttons.primary>
            </div>
        </x-shopper::card>
    </form>
</x-shopper::container>
