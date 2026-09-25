<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Markdown
{
    /**
     * Raw HTML in the source is stripped: content comes from a form, and the admin
     * session should not be one XSS away from the public site.
     */
    public static function render(?string $markdown): HtmlString
    {
        return new HtmlString(Str::markdown((string) $markdown, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]));
    }
}
