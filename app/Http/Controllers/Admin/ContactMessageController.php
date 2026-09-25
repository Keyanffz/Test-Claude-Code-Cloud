<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('filter') === 'unread' ? 'unread' : 'all';

        return view('admin.messages.index', [
            'filter' => $filter,
            'messages' => ContactMessage::query()
                ->when($filter === 'unread', fn ($query) => $query->unread())
                ->latest()
                ->paginate(20)
                ->withQueryString(),
        ]);
    }

    public function show(ContactMessage $message): View
    {
        // Opening a message is what "reading" it means; no separate click needed.
        if (! $message->isRead()) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', ['contactMessage' => $message]);
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $read = $request->validate(['read' => ['required', 'boolean']])['read'];

        $message->update(['read_at' => $read ? now() : null]);

        return $read
            ? back()->with('toast', 'Marked as read.')
            : redirect()->route('admin.messages.index')->with('toast', 'Marked as unread.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('toast', 'Message deleted.');
    }
}
