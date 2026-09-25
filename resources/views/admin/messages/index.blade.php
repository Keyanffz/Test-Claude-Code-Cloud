<x-admin.layout title="Messages">
    <x-admin.page-header title="Messages" description="Everything sent through the contact form. Opening a message marks it as read." />

    <nav class="mb-6 flex gap-4" aria-label="Filter messages">
        @foreach (['all' => 'All', 'unread' => 'Unread'] as $value => $label)
            <a
                href="{{ route('admin.messages.index', $value === 'all' ? [] : ['filter' => $value]) }}"
                @class(['label-mono border-b pb-1', 'border-ink text-ink' => $filter === $value, 'border-transparent text-muted hover:text-ink' => $filter !== $value])
                @if ($filter === $value) aria-current="page" @endif
            >{{ $label }}</a>
        @endforeach
    </nav>

    @if ($messages->isEmpty())
        <x-admin.empty-state :title="$filter === 'unread' ? 'Inbox zero' : 'No messages yet'">
            {{ $filter === 'unread' ? 'Every message has been read.' : 'Messages from the contact form will land here.' }}
        </x-admin.empty-state>
    @else
        <ul class="border-t border-line">
            @foreach ($messages as $item)
                <li class="group grid grid-cols-[auto_1fr_auto] items-start gap-4 border-b border-line py-4">
                    <span @class(['mt-2 size-1.5 rounded-full', 'bg-signal' => ! $item->isRead()])><span class="sr-only">{{ $item->isRead() ? 'Read' : 'Unread' }}</span></span>
                    <a href="{{ route('admin.messages.show', $item) }}" class="min-w-0">
                        <p @class(['truncate', 'font-medium' => ! $item->isRead()])>{{ $item->name }} <span class="font-normal text-muted">&lt;{{ $item->email }}&gt;</span></p>
                        <p class="mt-1 line-clamp-2 text-muted group-hover:text-ink">{{ $item->message }}</p>
                    </a>
                    <div class="flex items-center gap-2">
                        <time class="label-mono text-muted" datetime="{{ $item->created_at->toIso8601String() }}" title="{{ $item->created_at->format('j M Y, H:i') }}">{{ $item->created_at->diffForHumans(short: true) }}</time>
                        <x-admin.delete-button :action="route('admin.messages.destroy', $item)" confirm="Delete this message?" />
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">{{ $messages->links() }}</div>
    @endif
</x-admin.layout>
