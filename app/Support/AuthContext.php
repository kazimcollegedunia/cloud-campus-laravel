<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

class AuthContext
{
    public static function user()
    {
        return Auth::user();
    }

    public static function userId(): int
    {
        return Auth::id();
    }

    public static function tenantId(): int
    {
        return Auth::user()->tenant_id;
    }

    public static function role(): string
    {
        return Auth::user()->role;
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }

    public static function isTeacher(): bool
    {
        return self::role() === 'teacher';
    }
}
