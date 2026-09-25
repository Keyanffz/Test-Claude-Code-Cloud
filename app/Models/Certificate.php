<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\HasStoredFiles;
use Database\Factories\CertificateFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Certificate extends Model
{
    /** @use HasFactory<CertificateFactory> */
    use FlushesPortfolioCache, HasFactory, HasStoredFiles;

    protected $fillable = ['title', 'issuer', 'issued_at', 'url', 'file_path', 'image_path'];

    protected function casts(): array
    {
        return ['issued_at' => 'date'];
    }

    public function scopeLatestFirst(Builder $query): void
    {
        $query->orderByDesc('issued_at')->orderByDesc('id');
    }

    /**
     * An uploaded file wins over an external link: it is the one we know will not rot.
     */
    public function credentialUrl(): ?string
    {
        return $this->file_path ? Storage::disk('public')->url($this->file_path) : $this->url;
    }

    protected function storedFileAttributes(): array
    {
        return ['file_path', 'image_path'];
    }
}
