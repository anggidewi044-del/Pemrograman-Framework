<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registration;
use Illuminate\Support\Carbon;
use App\Services\MediaStorage;

/**
 * @property int $id
 * @property string $title
 * @property string $speaker
 * @property string $date
 * @property string $time
 * @property string $location
 * @property string $description
 * @property int $quota_max
 * @property int $quota_used
 * @property string $status
 * @property string|null $image
 * @property string|null $flyer_path
 * @property string|null $category
 * @property int $price
 * @property string|null $contact_phone
 * @property string|null $materi
 * @property string $event_type
 * @property string|null $zoom_link
 * @property string|null $zoom_info
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organizer_id',
        'speaker',
        'category',
        'date',
        'time',
        'location',
        'description',
        'materi',
        'quota_max',
        'quota_used',
        'price',
        'contact_phone',
        'status',
        'event_type',
        'zoom_link',
        'zoom_info',
        'attendance_open',
        'published_at',
        'completed_at',
        'certificate_template_path',
        'certificate_template_name',
        'certificate_generated_at',
        'certificate_name_y',
        'certificate_name_size',
        'certificate_name_color',
        'image',
        'flyer_path',
    ];

    protected $casts = [
        'attendance_open' => 'boolean',
        'published_at' => 'datetime',
        'completed_at' => 'datetime',
        'certificate_generated_at' => 'datetime',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(EventFeedback::class);
    }

    public function getDisplayDateAttribute(): string
    {
        try {
            return Carbon::parse($this->date)->translatedFormat('d M, Y');
        } catch (\Throwable $exception) {
            return (string) $this->date;
        }
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->quota_max - $this->quota_used);
    }

    public function getFlyerUrlAttribute(): ?string
    {
        return app(MediaStorage::class)->url($this->flyer_path);
    }

    public function getCertificateTemplateUrlAttribute(): ?string
    {
        return app(MediaStorage::class)->url($this->certificate_template_path);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price <= 0) {
            return 'Gratis';
        }

        return 'Rp. ' . number_format($this->price, 0, ',', '.');
    }

    public function getMaterialsAttribute(): array
    {
        if (empty($this->materi)) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $this->materi)));
    }

    public function getIsOnlineAttribute(): bool
    {
        return $this->event_type === 'online';
    }

    public function getIsOfflineAttribute(): bool
    {
        return $this->event_type === 'offline';
    }

    public function revenue(): int
    {
        if ($this->price <= 0) {
            return 0;
        }

        $paidRegistrations = $this->registrations()
            ->whereIn('status', ['terdaftar', 'hadir'])
            ->count();

        return $this->price * $paidRegistrations;
    }
}
