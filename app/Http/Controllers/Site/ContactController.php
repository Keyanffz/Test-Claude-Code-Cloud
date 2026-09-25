<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function __invoke(ContactRequest $request): RedirectResponse
    {
        // Bots get the same success response so they have no signal to adapt to.
        if (! $request->isSpam()) {
            ContactMessage::create([...$request->validated(), 'ip_address' => $request->ip()]);
        }

        return redirect()->to(route('home').'#contact')->with('contact_sent', true);
    }
}
