<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/admins/users/list/*',
        '/admins/users/delete/*',
        '/admins/users/checkemail',
        '/admins/partners/list/*',
        '/admins/partners/delete/*',
        '/admins/partners/reorder',
        '/admins/contents/list/*',
        '/admins/contents/delete/*',
        '/admins/montivory/reorder',
        '/admins/montivory/list/*',
        '/admins/montivory/delete/*',
        '/api/position',
        '/api/cv',
        '/api/contact'
    ];
}
