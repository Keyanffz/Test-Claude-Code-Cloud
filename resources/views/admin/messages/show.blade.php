<x-admin.layout :title="'Message from '.$contactMessage->name">
    <x-admin.page-header :title="$contactMessage->name" :back="route('admin.messages.index')">
        <x-slot:actions>
            <form method="POST" action="{{ route('admin.messages.update', $contactMessage) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="read" value="0">
                <x-admin.button variant="secondary" icon="mail">Mark as unread</x-admin.button>
            </form>
            <x-admin.button :href="'mailto:'.$contactMessage->email.'?subject='.rawurlencode('Re: your message')" icon="mail-open">Reply by email</x-admin.button>
            <x-admin.delete-button :action="route('admin.messages.destroy', $contactMessage)" confirm="Delete this message?" />
        </x-slot:actions>
    </x-admin.page-header>

    <dl class="grid max-w-3xl gap-x-6 gap-y-3 sm:grid-cols-[140px_1fr]">
        <dt class="label-mono text-muted">From</dt>
        <dd><a href="mailto:{{ $contactMessage->email }}" class="link-underline">{{ $contactMessage->email }}</a></dd>
        <dt class="label-mono text-muted">Received</dt>
        <dd class="tabular-nums">{{ $contactMessage->created_at->format('l, j F Y · H:i') }}</dd>
    </dl>

    <div class="mt-8 max-w-3xl border-t border-line pt-8 text-base leading-relaxed whitespace-pre-line">{{ $contactMessage->message }}</div>
</x-admin.layout>
