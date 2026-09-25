<x-admin.layout title="SEO">
    <x-admin.page-header title="SEO" description="Defaults for search results and link previews. Project pages use their own title and summary." />

    <x-admin.form :action="route('admin.seo.update')" method="PUT">
        <x-admin.input label="Meta title" name="meta_title" :value="$seo->meta_title" maxlength="70" required hint="Up to 70 characters. Shown as the tab title and search result heading." />
        <x-admin.textarea label="Meta description" name="meta_description" :value="$seo->meta_description" rows="3" maxlength="160" hint="Up to 160 characters." />
        <x-admin.image-input label="Open Graph image" name="og_image" :current="$seo->og_image_path ? Storage::url($seo->og_image_path) : null" aspect="aspect-[1200/630]" hint="Cropped to 1200 × 630 for link previews." />
    </x-admin.form>
</x-admin.layout>
