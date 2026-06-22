<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::find(1);
        if ($event) {
            Registration::create([
                'event_id' => $event->id,
                'name' => 'Ayu Shinta',
                'email' => 'ayu.is3@gmail.com',
                'status' => 'hadir',
                'check_in_time' => '09:45',
                'certificate_token' => Str::uuid(),
            ]);
            Registration::create([
                'event_id' => $event->id,
                'name' => 'Robbilah Samudra',
                'email' => 'robbilah@gmail.com',
                'status' => 'registered',
                'check_in_time' => null,
                'certificate_token' => null,
            ]);
            Registration::create([
                'event_id' => $event->id,
                'name' => 'Sanjaya Faris',
                'email' => 'sanjaya.faris@gmail.com',
                'status' => 'absent',
                'check_in_time' => null,
                'certificate_token' => null,
            ]);
        }
    }
}
