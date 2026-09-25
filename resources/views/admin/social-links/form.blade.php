@php($editing = $socialLink->exists)

<x-admin.layout :title="$editing ? 'Edit link' : 'Add link'">
    <x-admin.page-header :title="$editing ? 'Edit link' : 'Add link'" :back="route('admin.social-links.index')" />

    <x-admin.form :action="$editing ? route('admin.social-links.update', $socialLink) : route('admin.social-links.store')" :method="$editing ? 'PUT' : 'POST'" :cancel="route('admin.social-links.index')">
        <x-admin.input label="Platform" name="platform" :value="$socialLink->platform" required hint="As it should read on the site, e.g. GitHub, LinkedIn, Dribbble." />
        <x-admin.input label="URL" name="url" type="url" :value="$socialLink->url" placeholder="https://" required />
    </x-admin.form>
</x-admin.layout>
