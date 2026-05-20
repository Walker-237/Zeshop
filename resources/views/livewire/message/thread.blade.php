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

    <div class="my-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <x-shopper::heading class="mb-0" :title="$message->subject">
            <x-slot name="description">
                From {{ $message->sender?->full_name ?? 'System' }} to {{ $message->recipient?->full_name ?? 'Unknown' }}
            </x-slot>
        </x-shopper::heading>

        <div class="flex flex-wrap items-center gap-3">
            @can('update', $message)
                <x-shopper::buttons.default wire:click="toggleStar">
                    {{ $message->starred_at ? 'Unstar' : 'Star' }}
                </x-shopper::buttons.default>
            @endcan
            @can('delete', $message)
                @if ($message->archived_at)
                    <x-shopper::buttons.primary wire:click="restore">
                        Restore
                    </x-shopper::buttons.primary>
                @else
                    <x-shopper::buttons.default wire:click="archive">
                        Archive
                    </x-shopper::buttons.default>
                @endif
            @endcan
        </div>
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
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Read</div>
                <div>{{ $message->read_at?->format('M j, Y g:i A') ?? 'Unread' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Starred</div>
                <div>{{ $message->starred_at?->format('M j, Y g:i A') ?? 'No' }}</div>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Archived</div>
                <div>{{ $message->archived_at?->format('M j, Y g:i A') ?? 'No' }}</div>
            </div>
        </div>

        <div class="whitespace-pre-line text-sm leading-6 text-gray-800 dark:text-gray-200">
            {{ $message->body }}
        </div>
    </x-shopper::card>

    @if ($message->replies->isNotEmpty())
        <div class="mt-6 space-y-4">
            @foreach ($message->replies->sortBy('created_at') as $reply)
                <x-shopper::card class="p-6">
                    <div class="mb-3 flex flex-col gap-1 text-sm text-gray-600 dark:text-gray-400 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $reply->sender?->full_name ?? 'System' }}</span>
                            to {{ $reply->recipient?->full_name ?? 'Unknown' }}
                        </div>
                        <div>{{ $reply->created_at?->format('M j, Y g:i A') }}</div>
                    </div>
                    <div class="whitespace-pre-line text-sm leading-6 text-gray-800 dark:text-gray-200">
                        {{ $reply->body }}
                    </div>
                </x-shopper::card>
            @endforeach
        </div>
    @endif

    @can('create', \App\Models\Message::class)
        <form wire:submit="reply" class="mt-6 max-w-3xl">
            <x-shopper::card class="p-6">
                {{ $this->form }}

                <div class="mt-6 flex justify-end">
                    <x-shopper::buttons.primary type="submit">
                        Send Reply
                    </x-shopper::buttons.primary>
                </div>
            </x-shopper::card>
        </form>
    @endcan
</x-shopper::container>
