<?php

namespace App\Models;

use App\Enums\StatusEnum;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Concerns\Filterable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements LdapAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, AuthenticatesWithLdap, HasUlids, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'guid',
        'samaccountname',
        'dn',
        'name',
        'email',
        'title',
        'company',
        'division',
        'memberof',
        'department',
        'departmentNumber',
        'manager',
        'manager_email',
        'lead',
        'lead_email',
        'configs',
        'metas',
        'created_by',
        'created_by_email',
        'updated_by',
        'updated_by_email',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
            'configs' => 'array',
            'metas' => 'array',
            'created_at'  => 'datetime:Y-m-d',
            'updated_at'  => 'datetime:Y-m-d',
        ];
    }
}
