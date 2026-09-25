<footer class="border-t border-line">
    <div class="container-page grid-page gap-y-6 py-10">
        <p class="label-mono col-span-12 text-muted lg:col-span-4">© {{ now()->year }} {{ $profile->name }}</p>

        @if ($socialLinks->isNotEmpty())
            <ul class="col-span-12 flex flex-wrap gap-x-6 gap-y-2 lg:col-span-5">
                @foreach ($socialLinks as $link)
                    <li>
                        <a href="{{ $link->url }}" target="_blank" rel="me noopener" class="label-mono link-underline inline-flex items-center gap-1 text-muted hover:text-ink">
                            {{ $link->platform }}<x-icon name="arrow-up-right" :size="12" />
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="#main" class="label-mono col-span-12 inline-flex items-center gap-1 text-muted hover:text-ink lg:col-span-3 lg:justify-self-end" data-scroll-top>
            Back to top <x-icon name="arrow-up-right" :size="12" class="-rotate-45" />
        </a>
    </div>
</footer>
