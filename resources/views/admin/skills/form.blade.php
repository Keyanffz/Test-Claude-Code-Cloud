@php($editing = $skill->exists)

<x-admin.layout :title="$editing ? 'Edit skill' : 'Add skill'">
    <x-admin.page-header :title="$editing ? 'Edit skill' : 'Add skill'" :back="route('admin.skills.index')" />

    <x-admin.form :action="$editing ? route('admin.skills.update', $skill) : route('admin.skills.store')" :method="$editing ? 'PUT' : 'POST'" :cancel="route('admin.skills.index')">
        <x-admin.input label="Name" name="name" :value="$skill->name" required />
        <x-admin.input label="Category" name="category" :value="$skill->category" list="skill-categories" required hint="Pick an existing category or type a new one." />
        <datalist id="skill-categories">
            @foreach ($categories as $category)
                <option value="{{ $category }}">
            @endforeach
        </datalist>
    </x-admin.form>
</x-admin.layout>
