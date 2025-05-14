<?php

namespace App\Console\Commands;

use App\Models\User;
use LdapRecord\Container;
use Illuminate\Console\Command;

class SyncLdapUsers extends Command
{
    protected $signature = 'user:sync-ldap';

    protected $description = 'Sync users from LDAP into database';

    public function handle(): void
    {
        $this->info('Starting LDAP Sync...');

        $ldap = Container::getDefaultConnection();

        $users = User::all();

        foreach ($users as $user) {
            if (empty($user->email)) {
                $this->warn("Skipping user with no email: ID {$user->id}");
                continue;
            }

            $ldapUser = $ldap->query()->where('mail', '=', $user->email)->first();

            if (!$ldapUser) {
                $this->error("LDAP user not found for email: {$user->email}. Deleting local user...");

                $user->delete();

                $this->info("Deleted user: {$user->email}");

                continue;
            }

            $this->syncUser($user, $ldapUser);

            $this->info("Synced user: {$user->email}");
        }

        $this->info('LDAP Sync complete.');
    }

    private function syncUser(User $user, $ldapUser): void
    {
        $user->fill([
            'name'           => $ldapUser->getFirstAttribute('cn') ?? $user->name,
            'title'          => $ldapUser->getFirstAttribute('title') ?? $user->title,
            'company'        => $ldapUser->getFirstAttribute('company') ?? $user->company,
            'samaccountname' => $ldapUser->getFirstAttribute('samaccountname') ?? $user->samaccountname,
            'domain'         => $this->extractDomain($ldapUser->getFirstAttribute('userPrincipalName')) ?? $user->domain,
        ])->save();
    }

    private function extractDomain(?string $upn): ?string
    {
        return $upn ? explode('@', $upn)[1] ?? null : null;
    }
}
