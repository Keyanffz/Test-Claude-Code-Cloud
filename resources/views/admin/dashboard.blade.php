<x-admin.auth-layout title="Dashboard">
    <h1 class="font-display text-5xl">Dashboard</h1>
    <form method="POST" action="{{ route('admin.logout') }}">@csrf<x-admin.button>Sign out</x-admin.button></form>
</x-admin.auth-layout>
