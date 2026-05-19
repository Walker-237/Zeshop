<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Messages">
        <x-slot name="description">
            Send and track internal messages between team members.
        </x-slot>
        @can('create', \App\Models\Message::class)
            <x-slot name="action">
                <x-shopper::buttons.primary :link="route('shopper.messages.create')">
                    Compose Message
                </x-shopper::buttons.primary>
            </x-slot>
        @endcan
    </x-shopper::heading>

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
