<?php

namespace App\Http\Middleware;

use App\Models\Teacher;
use Closure;
use Illuminate\Http\Request;

class TeacherAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('teacher_id') || !Teacher::find(session('teacher_id'))) {
            return redirect()->route('teacher.login');
        }

        return $next($request);
    }
}
