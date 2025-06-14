<?php

namespace Database\Seeders\Companies;

use App\Models\Module;
use App\Models\Company;
use App\Models\Feature;
use App\Models\Process;
use Nnjeim\World\World;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Support\Arr;
use Nnjeim\World\WorldHelper;
use App\Enums\FeatureTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IsscManilaSeeder extends Seeder
{
    public string $iso2 = 'PH';

    public string $companyName = 'ISSC MANILA';

    public string $companyAbbr = 'ISSC-MNL';

    /**
     * Run the database seeds.
     */
    public function run(WorldHelper $world): void
    {
        // Country
        $country = $world->countries([
            'fields' => 'countries,iso2,iso3,currency',
            'filters' => [
                'iso2' => $this->iso2
            ]
        ]);

        if (!$country->success) {
            $this->command->error('Failed to fetch country.');
            exit;
        }

        $country = Arr::first($country->data);

        // FEATURES
        $features = [
            ['country' => $country['iso2'], 'name' => 'Request Queue', 'code' => 'request_queue', 'type' => FeatureTypeEnum::MENU->value],
            ['country' => $country['iso2'], 'name' => 'Daily Tasks', 'code' => 'daily_task', 'type' => FeatureTypeEnum::MENU->value],
            ['country' => $country['iso2'], 'name' => 'Mailing', 'code' => 'mail', 'type' => FeatureTypeEnum::FEATURE->value],
            ['country' => $country['iso2'], 'name' => 'Reporting', 'code' => 'report', 'type' => FeatureTypeEnum::MENU->value],
            ['country' => $country['iso2'], 'name' => 'Invoicing', 'code' => 'invoice', 'type' => FeatureTypeEnum::FEATURE->value],
        ];

        foreach ($features as $feature) {
            $permissions = [
                ['category' => '*', 'resource' =>  $feature['code'], 'action' => '*', 'description' => "Full access to {$feature['code']} management"],
                ['category' => '*', 'resource' =>  $feature['code'], 'action' => 'create', 'description' => "Manage {$feature['code']}"],
                ['category' => '*', 'resource' =>  $feature['code'], 'action' => 'edit', 'description' => "Manage {$feature['code']}"],
                ['category' => '*', 'resource' =>  $feature['code'], 'action' => 'delete', 'description' => "Manage {$feature['code']}"],
                ['category' => '*', 'resource' =>  $feature['code'], 'action' => 'view', 'description' => "Manage {$feature['code']}"],
            ];

            // Set allowed permissions for features
            $allowedFeaturePermissions = array_map(function (array $permission) {
                return "{$permission['resource']}:{$permission['action']}";
            }, $permissions);

            $feature['configs'] = [
                ...($feature['configs'] ?? []),
                'allowed_permissions' => $allowedFeaturePermissions,
            ];

            $features = Feature::updateOrCreate(
                ['country' => $country['iso2'], 'code' => $feature['code'], 'type' => $feature['type']],
                $feature
            );
        }

        // MODULE
        $modules = [
            ['country' => $country['iso2'], 'name' => 'APCW', 'code' => 'apcw'],
            ['country' => $country['iso2'], 'name' => 'OPR', 'code' => 'opr'],
            ['country' => $country['iso2'], 'name' => 'SSH', 'code' => 'ssh'],
            ['country' => $country['iso2'], 'name' => 'AARM', 'code' => 'aarm']
        ];

        foreach ($modules as $module) {
            // Create Permissions for mapping module based permissions
            $permissions = [
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => '*', 'description' => "Full access to {$module['code']} management"],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'create', 'description' => "Manage {$module['code']}"],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'edit', 'description' => "Manage {$module['code']}"],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'delete', 'description' => "Manage {$module['code']}"],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'view', 'description' => "Manage {$module['code']}"],
            ];

            // Set allowed permissions for modules
            $allowedModulePermissions = array_map(function (array $permission) {
                return "{$permission['resource']}:{$permission['action']}";
            }, $permissions);

            $module['configs'] = [
                ...($module['configs'] ?? []),
                'allowed_permissions' => $allowedModulePermissions,
            ];

            // Update or Create Module
            $module = Module::updateOrCreate(
                ['country' => $country['iso2'], 'code' => $module['code']],
                $module
            );

            foreach ($permissions as $permission) {
                Permission::updateOrCreate(
                    ['action' => $permission['action'], 'resource' => $permission['resource']],
                    $permission
                );
            }
        }

        // COMPANY
        $company = Company::updateOrCreate(
            ['abbr' =>  $this->companyAbbr, 'country' => $country['iso2']],
            ['country' => $country['iso2'], 'abbr' => $this->companyAbbr, 'name' => $this->companyName]
        );

        // DEPARTMENTS
        $departments = [
            ['company_id' => $company->id, 'abbr' => 'as',     'name' => 'Accounting Services'],
            ['company_id' => $company->id, 'abbr' => 'bss',    'name' => 'Business Support Services'],
            ['company_id' => $company->id, 'abbr' => 'support','name' => 'Support Services'],
        ];

        foreach ($departments as $department)
        {
            $department = Department::updateOrCreate(
                ['country' => $company->country, 'abbr' => $department['abbr']],
                $department
            );

            $processes = match ($department->abbr)
            {
                'as' => [
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'AP SAP'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'AP CW1'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CM SAP'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CM CW1'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'COST MATCH SAP'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'COST MATCH CW1'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'IC SAP'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'IC CW1'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'VQH'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'FOMD'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'Verification'],
                ],
                'bss' => [
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'Commercial Shared Services'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'AIR & OCEAN CONTROL TOWER'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CLAIMS'],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CUSTOMS'],
                ],
                default => null
            };

            if (!is_null($processes)) {
                foreach ($processes as $process) {
                    $process = Process::updateOrCreate(
                        ['country' => $company->country, 'name' => $process['name']],
                        $process
                    );
                }
            }

        }

        $this->command->info("Done seeding {$this->companyName}.");
    }
}
