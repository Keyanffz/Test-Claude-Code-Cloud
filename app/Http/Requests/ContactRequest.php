<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Name of the honeypot input. Humans never see it; naive bots fill every field.
     */
    public const HONEYPOT = 'website';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('home').'#contact';
    }

    public function isSpam(): bool
    {
        return filled($this->input(self::HONEYPOT));
    }
}
