<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\LdapUser;
use Illuminate\Support\Facades\DB;
use LdapRecord\Models\Attributes\Guid;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function fetchClient(): object
    {
        return DB::table('oauth_clients')
            ->where('password_client', true)
            ->get()[0];
    }

    public function fetchAll($filters): Collection
    {
        return User::filters($filters)->get();
    }

    public function syncLdapUser(LdapUser $ldapUser): User|null
    {
        // Parse GUID
        $guidBinary = $ldapUser->getFirstAttribute('objectGUID');
        $guid = $guidBinary ? (string) new Guid($guidBinary) : null;

        $samAccountName = $ldapUser->getFirstAttribute('samaccountname');
        $dn = $ldapUser->getFirstAttribute('distinguishedname');
        $name = $ldapUser->getFirstAttribute('cn');
        $email = $ldapUser->getFirstAttribute('mail');

        $title = $ldapUser->getFirstAttribute('title');
        $company = $ldapUser->getFirstAttribute('company');
        $division = $ldapUser->getFirstAttribute('division');
        $memberOf = $ldapUser->getFirstAttribute('memberof');

        $department = $ldapUser->getFirstAttribute('department');
        $departmentNumber = $ldapUser->getFirstAttribute('departmentNumber');
        
        // Extract Manager
        $manager = $ldapUser->getFirstAttribute('manager');

        $managerLdap = LdapUser::find($manager);
        $managerEmail = $managerLdap?->getFirstAttribute('mail');

        if (!$email) {
            throw new \Exception("LDAP user missing email attribute");
        }

        return User::updateOrCreate(
            ['samAccountName' => $samAccountName],
            [
                'guid' => $guid,
                'samaccountname' => $samAccountName,
                'dn' => $dn,
                'name' => $name,
                'email' => $email,
                'title' => $title,
                'company' => $company,
                'division' => $division,
                'memberof' => $memberOf,
                'department' => $department,
                'departmentNumber' => $departmentNumber,
                'manager' => $manager,
                'manager_email' => $managerEmail,
            ]
        );
    }

    public function findUserByEmail(string $email): User|null
    {
        return User::firstWhere($email);
    }

    public function create(array $data): Collection
    {
        return User::create($data);
    }
}
