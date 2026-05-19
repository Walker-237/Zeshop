<x-shopper::container class="py-5">
    <x-shopper::heading class="mb-6" title="Reports">
        <x-slot name="description">
            Generate and review operational snapshots across sales, commissions, deliveries, and inventory.
        </x-slot>
        @can('create', \App\Models\Report::class)
            <x-slot name="action">
                <x-shopper::buttons.primary :link="route('shopper.reports.create')">
                    Generate Report
                </x-shopper::buttons.primary>
            </x-slot>
        @endcan
    </x-shopper::heading>

    @if ($latestReport)
        <x-shopper::card class="mb-6 p-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase text-gray-500 dark:text-gray-400">Latest report</p>
                    <h3 class="mt-1 font-heading text-xl font-semibold text-gray-950 dark:text-white">
                        {{ $latestReport->title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ ucfirst($latestReport->type) }} generated {{ $latestReport->generated_at->diffForHumans() }}
                    </p>
                </div>
                <dl class="grid gap-3 sm:grid-cols-2 lg:min-w-[24rem]">
                    @foreach (array_slice($latestReport->summary, 0, 4, true) as $label => $value)
                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-white/5">
                            <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                {{ str($label)->replace('_', ' ')->title() }}
                            </dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-950 dark:text-white">
                                {{ is_array($value) ? count($value) : $value }}
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </x-shopper::card>
    @endif

    <x-shopper::card class="p-4">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
