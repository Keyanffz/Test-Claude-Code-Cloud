<?php

namespace Database\Seeders;

use App\Enums\ExperienceType;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SeoSetting;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Services\ImageUploadService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function run(): void
    {
        $this->seedProfile();
        $this->seedProjects();
        $this->seedExperiences();
        $this->seedSkills();
        $this->seedSocialLinks();

        SeoSetting::query()->updateOrCreate([], [
            'meta_title' => 'Key — Frontend Developer in Semarang',
            'meta_description' => 'Muhammad Nafi Anzalulrahman (Key) builds booking, campus and school systems with Next.js and Laravel. Informatics student at UDINUS, Semarang.',
            'og_image_path' => $this->image(1200, 630, 99, 'og_image'),
        ]);
    }

    private function seedProfile(): void
    {
        Profile::query()->updateOrCreate([], [
            'name' => 'Muhammad Nafi Anzalulrahman',
            'nickname' => 'Key',
            'headline' => 'Frontend Developer & Mahasiswa Teknik Informatika',
            'short_bio' => 'I build the part of a product people actually touch — booking flows, dashboards, forms that do not fight back. Informatics Engineering student at Universitas Dian Nuswantoro (UDINUS), Semarang.',
            'long_bio' => <<<'MD'
                Most of my work lives between a design file and a Laravel API: turning screens into components, wiring them to real data, and sweating the states nobody draws — loading, empty, error, "you have no bookings yet".

                I study Informatics Engineering at **Universitas Dian Nuswantoro (UDINUS)** in Semarang. Outside class I assist in the university lab and teach at Bengkel Koding, which has made me much better at explaining *why* code is written a certain way, not just how.

                Right now I am most interested in fast, accessible interfaces with Next.js and in keeping Laravel back-ends boring in the best sense.
                MD,
            'photo_path' => $this->image(960, 1200, 7, 'profile_photo'),
            'location' => 'Semarang, Indonesia',
            'email' => 'key@example.com',
            'open_to_work' => true,
        ]);
    }

    private function seedProjects(): void
    {
        $projects = [
            [
                'title' => 'Pivactive',
                'summary' => 'A booking platform for sports facilities: live court availability, time-slot booking and a venue dashboard for managing schedules.',
                'role' => 'Frontend Developer',
                'tech_stack' => ['Next.js', 'TypeScript', 'Tailwind CSS', 'Laravel', 'MySQL'],
                'year' => 2025,
                'is_featured' => true,
                'description' => <<<'MD'
                    Pivactive lets players find a court, see which slots are free, and book without a phone call. Venue owners get a dashboard for schedules, pricing and bookings.

                    ## My part

                    - Built the booking flow in Next.js: venue search, slot picker and checkout summary.
                    - Designed the component set with Tailwind CSS so venue pages and the owner dashboard share one visual language.
                    - Worked with the back-end team on the Laravel API contract, including how slot conflicts are reported to the UI.

                    ## What I learned

                    Time slots are harder than they look. Most of the interesting bugs were about time zones, overlapping bookings and what the UI should say when a slot disappears mid-checkout.
                    MD,
            ],
            [
                'title' => 'HaloKampus',
                'summary' => 'A digital health service for a campus community — appointment requests, health articles and a simple record of past consultations.',
                'role' => 'Frontend Developer',
                'tech_stack' => ['Laravel', 'Tailwind CSS', 'Alpine.js', 'MySQL'],
                'year' => 2024,
                'is_featured' => true,
                'description' => <<<'MD'
                    HaloKampus brings the campus clinic online: students request a consultation, read vetted health articles, and keep a history of their visits.

                    ## My part

                    - Built the student-facing pages and the appointment request form in Blade and Tailwind CSS.
                    - Added small Alpine.js interactions (filters, form steps) without pulling in a SPA framework.
                    - Paid attention to readable type and contrast — many users open it on a phone, outdoors, between classes.
                    MD,
            ],
            [
                'title' => 'Blockchain Certificate Verification',
                'summary' => 'Issue certificates with a fingerprint stored on-chain, then let anyone verify a document by uploading it or scanning its QR code.',
                'role' => 'Full-stack Developer',
                'tech_stack' => ['React', 'Solidity', 'Laravel', 'Ethers.js'],
                'year' => 2024,
                'is_featured' => true,
                'description' => <<<'MD'
                    Forged certificates are cheap to make and expensive to check. This system stores a hash of each issued certificate on a blockchain, so verification is a lookup rather than an email to the issuing office.

                    ## How it works

                    1. An institution issues a certificate; its hash is written to a smart contract.
                    2. The certificate carries a QR code pointing to the verification page.
                    3. Anyone can upload the file or scan the code — the page re-computes the hash and compares it with the chain.

                    ## My part

                    Built the issuing and verification interfaces in React and connected them to the contract through Ethers.js.
                    MD,
            ],
            [
                'title' => 'School Management System',
                'summary' => 'Attendance, grades and announcements for a school, with a web dashboard for staff and a Flutter app for students and parents.',
                'role' => 'Web & Mobile Developer',
                'tech_stack' => ['Laravel', 'Flutter', 'MySQL'],
                'year' => 2023,
                'is_featured' => false,
                'description' => <<<'MD'
                    One Laravel back-end, two clients: a web dashboard where teachers record attendance and grades, and a Flutter app where students and parents see them.

                    ## My part

                    - Built the staff dashboard screens and the REST endpoints the mobile app consumes.
                    - Built the Flutter screens for schedules, grades and announcements.
                    MD,
            ],
        ];

        foreach ($projects as $index => $data) {
            $project = Project::query()->updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    ...$data,
                    'is_published' => true,
                    'sort_order' => $index + 1,
                    'thumbnail_path' => $this->image(1600, 1200, $index + 1, 'project_thumbnail'),
                ],
            );

            if ($project->images()->doesntExist()) {
                foreach ([0, 1] as $position) {
                    $stored = $this->images->store(PlaceholderImage::make(2000, 1250, ($index + 1) * 10 + $position), 'project_gallery');
                    $project->images()->create([
                        'path' => $stored->path,
                        'width' => $stored->width,
                        'height' => $stored->height,
                        'alt' => "{$project->title} — screen ".($position + 1),
                        'sort_order' => $position,
                    ]);
                }
            }
        }
    }

    private function seedExperiences(): void
    {
        $experiences = [
            [
                'position' => 'Frontend Developer',
                'organization' => 'Pivactive (project team)',
                'type' => ExperienceType::Work,
                'started_at' => '2025-02-01',
                'ended_at' => null,
                'description' => 'Own the booking flow and the shared component library of a sports-facility booking platform built with Next.js and a Laravel API.',
            ],
            [
                'position' => 'Teaching Assistant',
                'organization' => 'Bengkel Koding, Universitas Dian Nuswantoro',
                'type' => ExperienceType::Assistant,
                'started_at' => '2024-09-01',
                'ended_at' => null,
                'description' => 'Guide students through web development sessions, review their code and help them debug their first full projects.',
            ],
            [
                'position' => 'Laboratory Assistant',
                'organization' => 'Universitas Dian Nuswantoro',
                'type' => ExperienceType::Assistant,
                'started_at' => '2024-02-01',
                'ended_at' => '2025-01-31',
                'description' => 'Ran practical sessions, prepared lab material and assessed assignments for programming courses.',
            ],
        ];

        foreach ($experiences as $index => $data) {
            Experience::query()->updateOrCreate(
                ['position' => $data['position'], 'organization' => $data['organization']],
                [...$data, 'sort_order' => $index + 1],
            );
        }
    }

    private function seedSkills(): void
    {
        $skills = [
            'Frontend' => ['Next.js', 'React', 'TypeScript', 'Tailwind CSS'],
            'Backend' => ['Laravel', 'PHP', 'MySQL'],
            'Mobile' => ['Flutter'],
            'Tools' => ['Git', 'Linux'],
        ];

        $position = 0;
        foreach ($skills as $category => $names) {
            foreach ($names as $name) {
                Skill::query()->updateOrCreate(['name' => $name], ['category' => $category, 'sort_order' => ++$position]);
            }
        }
    }

    private function seedSocialLinks(): void
    {
        $links = [
            'GitHub' => 'https://github.com/keyanffz',
            'LinkedIn' => 'https://www.linkedin.com/',
            'Instagram' => 'https://www.instagram.com/',
        ];

        $position = 0;
        foreach ($links as $platform => $url) {
            SocialLink::query()->updateOrCreate(['platform' => $platform], ['url' => $url, 'sort_order' => ++$position]);
        }
    }

    private function image(int $width, int $height, int $seed, string $preset): string
    {
        return $this->images->store(PlaceholderImage::make($width, $height, $seed), $preset)->path;
    }
}
