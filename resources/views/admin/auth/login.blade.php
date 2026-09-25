<x-admin.auth-layout title="Sign in">
    <p class="label-mono text-muted">Admin</p>
    <h1 class="mt-3 font-display text-5xl leading-none">Sign in</h1>

    <form method="POST" action="{{ route('admin.login.store') }}" class="mt-10 space-y-6">
        @csrf

        <x-admin.input label="Email" name="email" type="email" autocomplete="username" required autofocus />
        <x-admin.input label="Password" name="password" type="password" autocomplete="current-password" required />
        <x-admin.checkbox label="Keep me signed in" name="remember" />

        <x-admin.button class="w-full" icon="arrow-right">Sign in</x-admin.button>
    </form>
</x-admin.auth-layout>
