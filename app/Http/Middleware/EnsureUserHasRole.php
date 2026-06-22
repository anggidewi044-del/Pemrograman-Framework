<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== $role) {
            $dashboard = $user->isOrganizer()
                ? 'organizer.dashboard'
                : 'participant.dashboard';

            return redirect()->route($dashboard)->with(
                'error',
                'Halaman tersebut hanya dapat diakses oleh akun ' . ($role === 'organizer' ? 'penyelenggara.' : 'peserta.')
            );
        }

        return $next($request);
    }
}
