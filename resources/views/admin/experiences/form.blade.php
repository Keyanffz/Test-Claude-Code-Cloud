@php($editing = $experience->exists)

<x-admin.layout :title="$editing ? 'Edit experience' : 'Add experience'">
    <x-admin.page-header :title="$editing ? 'Edit experience' : 'Add experience'" :back="route('admin.experiences.index')" />

    <x-admin.form :action="$editing ? route('admin.experiences.update', $experience) : route('admin.experiences.store')" :method="$editing ? 'PUT' : 'POST'" :cancel="route('admin.experiences.index')">
        <x-admin.input label="Position" name="position" :value="$experience->position" required />
        <x-admin.input label="Organization" name="organization" :value="$experience->organization" required />
        <x-admin.select
            label="Type"
            name="type"
            :value="$experience->type?->value"
            :options="collect(\App\Enums\ExperienceType::cases())->mapWithKeys(fn ($type) => [$type->value => $type->label()])"
        />
        <div class="grid gap-6 sm:grid-cols-2">
            <x-admin.input label="Start date" name="started_at" type="date" :value="$experience->started_at?->toDateString()" required />
            <x-admin.input label="End date" name="ended_at" type="date" :value="$experience->ended_at?->toDateString()" hint="Leave empty if you are still here." />
        </div>
        <x-admin.textarea label="Description" name="description" :value="$experience->description" rows="4" maxlength="2000" />
    </x-admin.form>
</x-admin.layout>
