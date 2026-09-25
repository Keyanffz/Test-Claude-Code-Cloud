<footer class="border-t border-line">
    <div class="container-page grid-page gap-y-6 py-10">
        <p class="label-mono col-span-12 text-muted md:col-span-3">© {{ now()->year }} {{ $profile->name }}</p>

        @if ($socialLinks->isNotEmpty())
            <ul class="col-span-12 flex flex-wrap gap-x-6 gap-y-2 md:col-span-6">
                @foreach ($socialLinks as $link)
                    <li>
                        <a href="{{ $link->url }}" target="_blank" rel="me noopener" class="label-mono link-underline inline-flex items-center gap-1 text-muted hover:text-ink">
                            {{ $link->platform }}<x-icon name="arrow-up-right" :size="12" />
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="#main" class="label-mono col-span-12 inline-flex items-center gap-1 text-muted hover:text-ink md:col-span-3 md:justify-self-end" data-scroll-top>
            Back to top <x-icon name="arrow-up-right" :size="12" class="-rotate-45" />
        </a>
    </div>
</footer>
