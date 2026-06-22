<?php

namespace App\Models;

use App\Services\MediaStorage;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $event_id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string|null $check_in_time
 * @property string|null $certificate_token
 * @property string|null $payment_proof_path
 * @property int|null $payment_amount
 * @property string|null $payment_verified_at
 * @property string|null $rejection_reason
 * @property string|null $qr_code
 * @property bool $ticket_access_granted
 */
class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'status',
        'check_in_time',
        'certificate_token',
        'payment_proof_path',
        'payment_amount',
        'payment_verified_at',
        'rejection_reason',
        'qr_code',
        'ticket_access_granted',
    ];

    protected $casts = [
        'payment_verified_at' => 'datetime',
        'ticket_access_granted' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(EventFeedback::class);
    }

    public function scopeConfirmed($query)
    {
        return $query->whereIn('status', ['terdaftar', 'hadir']);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return app(MediaStorage::class)->url($this->payment_proof_path);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['menunggu_konfirmasi', 'menunggu_verifikasi_pembayaran']);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'hadir');
    }

    public function isPaidAndVerified(): bool
    {
        if ($this->event && $this->event->price <= 0) {
            return true;
        }

        return $this->payment_verified_at !== null && $this->status !== 'ditolak';
    }
}
