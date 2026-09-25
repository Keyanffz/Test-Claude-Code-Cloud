<x-admin.layout title="Profile">
    <x-admin.page-header title="Profile" description="Your name, bio and photo as they appear in the hero and About section." />

    <x-admin.form :action="route('admin.profile.update')" method="PUT">
        <x-admin.fieldset legend="Identity">
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input label="Full name" name="name" :value="$profile->name" required />
                <x-admin.input label="Nickname" name="nickname" :value="$profile->nickname" hint="Used as the large name in the hero." />
            </div>
            <x-admin.input label="Headline" name="headline" :value="$profile->headline" required />
            <x-admin.image-input label="Photo" name="photo" :current="$profile->photo_path ? Storage::url($profile->photo_path) : null" aspect="aspect-[4/5]" />
        </x-admin.fieldset>

        <x-admin.fieldset legend="About">
            <x-admin.textarea label="Short bio" name="short_bio" :value="$profile->short_bio" rows="3" hint="One or two sentences for the hero. Max 500 characters." />
            <x-admin.markdown label="Long bio" name="long_bio" :value="$profile->long_bio" />
        </x-admin.fieldset>

        <x-admin.fieldset legend="Contact">
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input label="Email" name="email" type="email" :value="$profile->email" />
                <x-admin.input label="Location" name="location" :value="$profile->location" />
            </div>
            <x-admin.file-input label="CV" name="cv" :current="$profile->cv_path ? Storage::url($profile->cv_path) : null" />
            @if ($profile->cv_path)
                <x-admin.checkbox label="Remove the current CV" name="remove_cv" />
            @endif
            <x-admin.checkbox label="Open to work" name="open_to_work" :checked="$profile->open_to_work" hint="Shows an availability note in the hero." />
        </x-admin.fieldset>
    </x-admin.form>
</x-admin.layout>
