<section id="contact" class="container-page scroll-mt-14 py-24 md:py-36" aria-labelledby="contact-title">
    <x-section-heading :$index label="Contact" />

    <div class="grid-page mt-10 gap-y-16 md:mt-16">
        <div class="col-span-12 md:col-span-5">
            <h2 id="contact-title" class="font-display text-title" data-reveal>
                @if ($profile->email)
                    <a href="mailto:{{ $profile->email }}" class="link-underline break-all">{{ $profile->email }}</a>
                @else
                    Contact
                @endif
            </h2>

            @if ($socialLinks->isNotEmpty())
                <ul class="mt-10 border-t border-line" data-reveal>
                    @foreach ($socialLinks as $link)
                        <li class="border-b border-line">
                            <a href="{{ $link->url }}" target="_blank" rel="me noopener" class="group flex items-center justify-between py-3">
                                <span>{{ $link->platform }}</span>
                                <x-icon name="arrow-up-right" class="text-muted transition-transform duration-500 ease-(--ease-out-expo) group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:text-ink" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="col-span-12 md:col-span-6 md:col-start-7" data-reveal>
            @if (session('contact_sent'))
                <div class="border-l-2 border-ink py-2 pl-5" role="status">
                    <p class="font-display text-4xl leading-none">Message received.</p>
                    <p class="mt-3 text-muted">Thanks for writing. The reply will go to the address you entered.</p>
                </div>
            @else
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-8" novalidate>
                    @csrf

                    {{-- Honeypot: off-screen rather than display:none, which some bots skip. --}}
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="{{ \App\Http\Requests\ContactRequest::HONEYPOT }}">Leave this empty</label>
                        <input type="text" id="{{ \App\Http\Requests\ContactRequest::HONEYPOT }}" name="{{ \App\Http\Requests\ContactRequest::HONEYPOT }}" tabindex="-1" autocomplete="off">
                    </div>

                    <x-contact-field label="Name" name="name" autocomplete="name" required maxlength="120" />
                    <x-contact-field label="Email" name="email" type="email" autocomplete="email" required maxlength="255" />
                    <x-contact-field label="Message" name="message" textarea required minlength="10" maxlength="5000" />

                    <button type="submit" class="group inline-flex items-center gap-3 rounded-sm bg-ink px-5 py-3 text-paper" data-magnetic>
                        <span data-magnetic-label>Send message</span>
                        <x-icon name="arrow-right" class="transition-transform duration-300 ease-(--ease-out-power3) group-hover:translate-x-0.5" />
                    </button>
                </form>
            @endif
        </div>
    </div>
</section>
