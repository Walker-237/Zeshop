@php
    $user = $getRecord();
@endphp

<div class="flex items-center justify-between gap-4">
    <div class="flex min-w-0 items-center">
        <div class="size-10 shrink-0">
            <img class="size-10 rounded-full" src="{{ $user->picture }}" alt="{{ $user->last_name }} avatar" />
        </div>
        <div class="ml-4 min-w-0">
            <div class="flex items-center gap-2">
                <span class="truncate text-sm font-medium leading-5">
                    {{ $user->full_name }}
                </span>
                @if ($user->id === shopper()->auth()->id())
                    <x-filament::badge icon="untitledui-user-circle" color="gray" size="sm">
                        {{ __('shopper::words.me') }}
                    </x-filament::badge>
                @endif
            </div>
            <div class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                {{ __('shopper::words.registered_on') }}
                <time datetime="{{ $user->created_at->format('Y-m-d') }}" class="capitalize">
                    {{ $user->created_at->translatedFormat('j F Y') }}
                </time>
            </div>
        </div>
    </div>

    @can('view_users')
        <x-shopper::link
            :href="route('shopper.settings.users.edit', $user)"
            class="shrink-0 text-sm font-medium text-primary-600 hover:text-primary-500"
        >
            Edit
        </x-shopper::link>
    @endcan
</div>
