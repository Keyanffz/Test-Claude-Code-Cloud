<?php

namespace App\Support;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SeoSetting;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Support\Collection;

/**
 * Read side of the public site. Everything here goes through PortfolioCache, which
 * model events flush whenever the admin changes something.
 */
class Portfolio
{
    /**
     * Per-request memo: the layout and several partials ask for the same data, and each
     * trip to the cache store is a query + unserialize.
     *
     * @var array<string, mixed>
     */
    private array $resolved = [];

    /**
     * @return array{profile: Profile, seo: SeoSetting, socialLinks: Collection<int, SocialLink>}
     */
    public function site(): array
    {
        return $this->resolved['site'] ??= PortfolioCache::remember('site', fn () => [
            'profile' => Profile::current(),
            'seo' => SeoSetting::current(),
            'socialLinks' => SocialLink::ordered()->get(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function home(): array
    {
        return $this->resolved['home'] ??= PortfolioCache::remember('home', function () {
            $projects = $this->projects();
            $skills = Skill::ordered()->get();
            $experiences = Experience::ordered()->get();

            return [
                'featuredProjects' => $projects->where('is_featured', true)->values(),
                'projectCount' => $projects->count(),
                'experiences' => $experiences,
                'skills' => $skills,
                'skillsByCategory' => $skills->groupBy('category'),
                'certificates' => Certificate::latestFirst()->get(),
                'yearsActive' => $this->yearsActive($experiences),
            ];
        });
    }

    /**
     * @return Collection<int, Project>
     */
    public function projects(): Collection
    {
        return $this->resolved['projects'] ??= PortfolioCache::remember('projects', fn () => Project::published()->ordered()->get());
    }

    public function project(string $slug): ?Project
    {
        return PortfolioCache::remember(
            "project:{$slug}",
            fn () => Project::published()->with('images')->where('slug', $slug)->first(),
        );
    }

    /**
     * Technologies across published projects, most used first, for the filter bar.
     *
     * @return Collection<int, string>
     */
    public function technologies(): Collection
    {
        return $this->projects()
            ->flatMap(fn (Project $project) => $project->tech_stack)
            ->countBy()
            ->sortDesc()
            ->keys();
    }

    /**
     * @param  Collection<int, Experience>  $experiences
     */
    private function yearsActive(Collection $experiences): int
    {
        $firstStart = $experiences->min('started_at');

        return $firstStart ? max(1, (int) ceil($firstStart->diffInYears(now()))) : 0;
    }
}
