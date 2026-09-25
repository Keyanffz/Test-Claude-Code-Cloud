@props(['sortable' => null])

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full min-w-[640px] border-collapse text-left']) }}>
        <thead class="label-mono border-b border-ink text-muted">
            <tr>{{ $head }}</tr>
        </thead>
        <tbody
            @if ($sortable) x-data="sortableList('{{ $sortable }}')" @endif
            class="[&>tr]:border-b [&>tr]:border-line [&_td]:py-3 [&_td]:pr-4 [&_td]:align-middle"
        >
            {{ $slot }}
        </tbody>
    </table>
</div>
