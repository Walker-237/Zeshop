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

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Messages</p>
            <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ $summary['total'] }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Unread</p>
            <p class="mt-2 text-2xl font-semibold text-primary-600">{{ $summary['unread'] }}</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Starred</p>
            <p class="mt-2 text-2xl font-semibold text-warning-600">{{ $summary['starred'] }}</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $summary['sent'] }} sent</p>
        </x-shopper::card>
        <x-shopper::card class="p-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Archived</p>
            <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ $summary['archived'] }}</p>
        </x-shopper::card>
    </div>

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
