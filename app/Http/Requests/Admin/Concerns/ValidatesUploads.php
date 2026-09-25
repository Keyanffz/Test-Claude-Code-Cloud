<?php

namespace App\Http\Requests\Admin\Concerns;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

trait ValidatesUploads
{
    /**
     * The dimensions check reads the actual pixels, so a renamed non-image fails
     * validation here instead of blowing up later in the image decoder.
     */
    protected function imageRule(): File
    {
        return File::image()
            ->types(['jpg', 'jpeg', 'png', 'webp'])
            ->max(config('images.max_upload_kb'))
            ->dimensions(Rule::dimensions()->minWidth(200)->minHeight(200));
    }

    protected function pdfRule(): File
    {
        return File::types(['pdf'])->max(5 * 1024);
    }
}
