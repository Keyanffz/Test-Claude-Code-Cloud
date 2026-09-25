<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'publishedCount' => Project::published()->count(),
            'unreadCount' => ContactMessage::unread()->count(),
            'recentMessages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
