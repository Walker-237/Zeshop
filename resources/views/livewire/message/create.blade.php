<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.messages.index')"
        current="Compose Message"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.messages.index')"
            title="Messages"
        />
    </x-shopper::breadcrumb>

    <x-shopper::heading class="my-6" title="Compose Message">
        <x-slot name="description">
            Send an internal note to another user in the team.
        </x-slot>
    </x-shopper::heading>

    <form wire:submit="create" class="max-w-3xl">
        <x-shopper::card class="p-6">
            {{ $this->form }}

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-shopper::buttons.default :link="route('shopper.messages.index')">
                    Cancel
                </x-shopper::buttons.default>
                <x-shopper::buttons.primary type="submit">
                    Send Message
                </x-shopper::buttons.primary>
            </div>
        </x-shopper::card>
    </form>
</x-shopper::container>
