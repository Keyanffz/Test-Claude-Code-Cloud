<x-admin.layout title="Dashboard">
    <x-admin.page-header title="Dashboard" description="What is live on the site, and what is waiting for you." />

    <dl class="grid border-b border-line sm:grid-cols-3">
        <div class="border-line py-6 sm:border-r sm:pr-6">
            <dt class="label-mono text-muted">Projects</dt>
            <dd class="mt-3 font-display text-6xl leading-none tabular-nums">{{ $projectCount }}</dd>
            <dd class="mt-2 text-muted">{{ $publishedCount }} published</dd>
        </div>
        <div class="border-t border-line py-6 sm:border-t-0 sm:border-r sm:px-6">
            <dt class="label-mono text-muted">Unread messages</dt>
            <dd @class(['mt-3 font-display text-6xl leading-none tabular-nums', 'text-signal' => $unreadCount > 0])>{{ $unreadCount }}</dd>
            <dd class="mt-2"><a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}" class="link-underline text-muted hover:text-ink">Open inbox</a></dd>
        </div>
        <div class="border-t border-line py-6 sm:border-t-0 sm:pl-6">
            <dt class="label-mono text-muted">Quick actions</dt>
            <dd class="mt-3 flex flex-col items-start gap-2">
                <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 hover:text-signal"><x-icon name="plus" /> New project</a>
                <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center gap-2 hover:text-signal"><x-icon name="user" /> Edit profile</a>
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-signal"><x-icon name="external-link" /> View site</a>
            </dd>
        </div>
    </dl>

    <section class="mt-12">
        <h2 class="label-mono text-muted">Latest messages</h2>
        @forelse ($recentMessages as $recent)
            <a href="{{ route('admin.messages.show', $recent) }}" class="grid grid-cols-[auto_1fr_auto] items-baseline gap-4 border-b border-line py-3 first:mt-3 first:border-t hover:bg-raised">
                <span @class(['size-1.5 rounded-full', 'bg-signal' => ! $recent->isRead(), 'bg-transparent' => $recent->isRead()])></span>
                <span class="truncate"><span class="font-medium">{{ $recent->name }}</span> <span class="text-muted">— {{ Str::limit($recent->message, 90) }}</span></span>
                <time class="label-mono text-muted" datetime="{{ $recent->created_at->toIso8601String() }}">{{ $recent->created_at->diffForHumans(short: true) }}</time>
            </a>
        @empty
            <p class="mt-3 text-muted">No messages yet. They will appear here when someone uses the contact form.</p>
        @endforelse
    </section>
</x-admin.layout>
