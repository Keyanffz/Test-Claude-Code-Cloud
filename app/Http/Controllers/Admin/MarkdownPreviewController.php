<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Markdown;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarkdownPreviewController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate(['markdown' => ['nullable', 'string', 'max:20000']]);

        $html = (string) Markdown::render($validated['markdown'] ?? '');

        return response()->json(['html' => $html ?: '<p>Nothing to preview yet.</p>']);
    }
}
