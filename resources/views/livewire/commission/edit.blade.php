<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.commissions.show', $commission)"
        current="Edit Commission"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.commissions.index')"
            title="Commissions"
        />
    </x-shopper::breadcrumb>

    <x-shopper::heading class="my-6" title="Edit Commission">
        <x-slot name="description">
            Update seller, amount, status, payment reference, and internal notes.
        </x-slot>
    </x-shopper::heading>

    <form wire:submit="update" class="max-w-3xl">
        <x-shopper::card class="p-6">
            {{ $this->form }}

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-shopper::buttons.default :link="route('shopper.commissions.show', $commission)">
                    Cancel
                </x-shopper::buttons.default>
                <x-shopper::buttons.primary type="submit">
                    Save Changes
                </x-shopper::buttons.primary>
            </div>
        </x-shopper::card>
    </form>
</x-shopper::container>
