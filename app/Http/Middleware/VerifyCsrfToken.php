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
        '/admins/auth',
        '/admins/signout',
        '/admins/users/list/*',
        '/admins/users/delete/*',
        '/admins/users/checkemail',
        '/admins/partners/list/*',
        '/admins/partners/delete/*',
        '/admins/partners/reorder',
        '/admins/tags/list/*',
        '/admins/tags/checktag',
        '/admins/tags/checktagname',
        '/admins/tags/create',
        '/admins/tags/delete/*',
        '/admins/contents/list/*',
        '/admins/contents/checkslug',
        '/admins/contents/create',
        '/admins/contents/published',
        '/admins/contents/unpublished',
        '/admins/contents/archived',
        '/admins/contents/unarchived',
        '/admins/images/published',
        '/admins/images/unpublished',
        '/admins/images/archived',
        '/admins/images/unarchived',
        '/admins/images/delete',
        '/admins/pagecontents/list/*',
        '/admins/pagecontents/delete/*',
        '/admins/pagecontents/create',
        '/admins/pagecontents/update/*',
        '/admins/pagecontents/checkslug',
        '/admins/categories/create',
        '/admins/categories/update/*',
        '/admins/categories/checkslug',
        '/admins/categories/list/*',
        '/admins/categories/delete/*',
        '/admins/montivory/reorder',
        '/admins/montivory/list/*',
        '/admins/montivory/delete/*',
        '/admins/positions/checkslug',
        '/api/position',
        '/api/cv',
        '/api/contact'
    ];
}
