<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Support\Portfolio;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(Portfolio $portfolio): Response
    {
        $projects = $portfolio->projects();

        return response()
            ->view('site.sitemap', [
                'projects' => $projects,
                'lastModified' => $projects->max('updated_at') ?? now(),
            ])
            ->header('Content-Type', 'application/xml');
    }
}
