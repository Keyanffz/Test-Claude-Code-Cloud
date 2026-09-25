@props(['action', 'method' => 'POST', 'submit' => 'Save changes', 'cancel' => null])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" {{ $attributes->merge(['class' => 'max-w-3xl']) }}>
    @csrf
    @unless (strtoupper($method) === 'POST')
        @method($method)
    @endunless

    @if ($errors->any())
        <div class="mb-8 flex items-start gap-3 border-l-2 border-signal bg-raised px-4 py-3" role="alert">
            <x-icon name="circle-alert" class="mt-0.5 text-signal" />
            <p>Some fields need attention. {{ $errors->count() === 1 ? 'One problem' : $errors->count().' problems' }} highlighted below.</p>
        </div>
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>

    <div class="sticky bottom-0 mt-10 flex items-center gap-3 border-t border-line bg-paper py-4">
        <x-admin.button icon="check">{{ $submit }}</x-admin.button>
        @if ($cancel)
            <x-admin.button variant="secondary" :href="$cancel">Cancel</x-admin.button>
        @endif
    </div>
</form>
