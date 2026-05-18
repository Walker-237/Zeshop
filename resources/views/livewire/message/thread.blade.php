<x-shopper::container class="py-5">
    <x-shopper::breadcrumb
        :back="route('shopper.messages.index')"
        current="Message"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.messages.index')"
            title="Messages"
        />
    </x-shopper::breadcrumb>

    <div class="my-6 flex items-start justify-between gap-4">
        <x-shopper::heading class="mb-0" :title="$message->subject">
            <x-slot name="description">
                From {{ $message->sender?->full_name ?? 'System' }} to {{ $message->recipient?->full_name ?? 'Unknown' }}
            </x-slot>
        </x-shopper::heading>

        @can('delete', $message)
            <x-shopper::buttons.default wire:click="archive">
                Archive
            </x-shopper::buttons.default>
        @endcan
    </div>

    <x-shopper::card class="p-6">
        <div class="mb-6 grid gap-4 text-sm text-gray-600 dark:text-gray-400 md:grid-cols-3">
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Sender</div>
                <div>{{ $message->sender?->full_name ?? 'System' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Recipient</div>
                <div>{{ $message->recipient?->full_name ?? 'Unknown' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Sent</div>
                <div>{{ $message->created_at?->format('M j, Y g:i A') }}</div>
            </div>
        </div>

        <div class="whitespace-pre-line text-sm leading-6 text-gray-800 dark:text-gray-200">
            {{ $message->body }}
        </div>
    </x-shopper::card>
</x-shopper::container>
