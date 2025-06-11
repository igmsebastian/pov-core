<?php

namespace App\Ldap\Rules;

use Illuminate\Http\Response;
use LdapRecord\Laravel\Auth\Rule;
use Illuminate\Support\Facades\DB;
use LdapRecord\Models\Model as LdapRecord;
use Illuminate\Database\Eloquent\Model as Eloquent;

class OnlyListedUsers implements Rule
{
    /**
     * Check if the rule passes validation.
     */
    public function passes(LdapRecord $user, ?Eloquent $model = null): bool
    {
        $email = $user->mail[0] ?? null;
        dd('hi');
        abort_unless(
            $email,
            Response::HTTP_UNAUTHORIZED,
            __("No email address found in LDAP record.")
        );

        abort_unless(
            DB::table('users')->where('email', $email)->exists(),
            Response::HTTP_UNAUTHORIZED,
            __("User not found. Please contact administrator for assistance.")
        );

        return true;
    }
}
