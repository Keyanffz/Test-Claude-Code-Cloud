<section id="work" class="container-page scroll-mt-14 py-24 md:py-36" aria-labelledby="work-title">
    <x-section-heading :$index label="Selected work">
        <a href="{{ route('projects.index') }}" class="label-mono link-underline col-span-12 inline-flex items-center gap-1 justify-self-start md:col-span-9 md:justify-self-end">
            All projects ({{ sprintf('%02d', $projectCount) }}) <x-icon name="arrow-right" :size="12" />
        </a>
    </x-section-heading>
    <h2 id="work-title" class="sr-only">Selected work</h2>

    <ol class="mt-6" data-preview-list>
        @foreach ($featuredProjects as $project)
            <x-project-row :$project :index="sprintf('%02d', $loop->iteration)" />
        @endforeach
    </ol>
</section>
