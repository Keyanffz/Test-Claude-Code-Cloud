@php($editing = $certificate->exists)

<x-admin.layout :title="$editing ? 'Edit certificate' : 'Add certificate'">
    <x-admin.page-header :title="$editing ? 'Edit certificate' : 'Add certificate'" :back="route('admin.certificates.index')" />

    <x-admin.form :action="$editing ? route('admin.certificates.update', $certificate) : route('admin.certificates.store')" :method="$editing ? 'PUT' : 'POST'" :cancel="route('admin.certificates.index')">
        <x-admin.input label="Title" name="title" :value="$certificate->title" required />
        <div class="grid gap-6 sm:grid-cols-2">
            <x-admin.input label="Issuer" name="issuer" :value="$certificate->issuer" required />
            <x-admin.input label="Issued on" name="issued_at" type="date" :value="$certificate->issued_at?->toDateString()" required />
        </div>
        <x-admin.input label="Credential URL" name="url" type="url" :value="$certificate->url" placeholder="https://" />
        <x-admin.file-input label="Certificate file" name="file" :current="$certificate->file_path ? Storage::url($certificate->file_path) : null" hint="Optional PDF. When present, it is linked instead of the URL." />
        <x-admin.image-input label="Image" name="image" :current="$certificate->image_path ? Storage::url($certificate->image_path) : null" />
    </x-admin.form>
</x-admin.layout>
