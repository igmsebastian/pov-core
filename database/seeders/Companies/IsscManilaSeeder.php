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
            ['country' => $country['iso2'], 'name' => 'Request Queue', 'code' => 'request_queue', 'type' => FeatureTypeEnum::MENU->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'Daily Tasks', 'code' => 'daily_task', 'type' => FeatureTypeEnum::MENU->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'Mailing', 'code' => 'mail', 'type' => FeatureTypeEnum::FEATURE->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'Reporting', 'code' => 'report', 'type' => FeatureTypeEnum::MENU->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'Invoicing', 'code' => 'invoice', 'type' => FeatureTypeEnum::FEATURE->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
        ];

        foreach ($features as $feature) {
            $features = Feature::updateOrCreate(
                ['country' => $country['iso2'], 'code' => $feature['code'], 'type' => $feature['type']],
                $feature
            );
        }

        // MODULE
        $modules = [
            ['country' => $country['iso2'], 'name' => 'APCW', 'code' => 'apcw', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'OPR', 'code' => 'opr', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'SSH', 'code' => 'ssh', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => $country['iso2'], 'name' => 'AARM', 'code' => 'aarm', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]]
        ];

        foreach ($modules as $module) {
            // Create Permissions for mapping module based permissions
            $permissions = [
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => '*', 'description' => "Full access to {$module['code']} management", 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'create', 'description' => "Manage {$module['code']}", 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'edit', 'description' => "Manage {$module['code']}", 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'delete', 'description' => "Manage {$module['code']}", 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                ['category' => 'module', 'resource' =>  $module['code'], 'action' => 'view', 'description' => "Manage {$module['code']}", 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ];

            // Set allowed permissions for modules
            $allowedModulePermissions = array_map(function (array $permission) {
                return "{$permission['resource']}:{$permission['action']}";
            }, $permissions);

            $module['configs'] = [
                'allowed-permissions' => $allowedModulePermissions,
            ];

            $module = Module::updateOrCreate(
                ['country' => $country['iso2'], 'code' => $module['code']],
                $module
            );

            foreach ($permissions as $permission) {
                Permission::updateOrCreate(
                    ['action' => $permission['action'], 'resource' => $permission['resource']],
                    ['description' => $permission['description']]
                );
            }
        }

        // COMPANY
        $company = Company::updateOrCreate(
            ['abbr' =>  $this->companyAbbr, 'country' => $country['iso2']],
            ['country' => $country['iso2'], 'abbr' => $this->companyAbbr, 'name' => $this->companyName, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]]
        );

        // DEPARTMENTS
        $departments = [
            ['company_id' => $company->id, 'abbr' => 'as',     'name' => 'Accounting Services', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['company_id' => $company->id, 'abbr' => 'bss',    'name' => 'Business Support Services', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['company_id' => $company->id, 'abbr' => 'support','name' => 'Support Services', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
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
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'AP SAP', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'AP CW1', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CM SAP', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CM CW1', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'COST MATCH SAP', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'COST MATCH CW1', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'IC SAP', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'IC CW1', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'VQH', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'FOMD', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'Verification', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                ],
                'bss' => [
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'Commercial Shared Services', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'AIR & OCEAN CONTROL TOWER', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CLAIMS', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
                    ['country' => $company->country, 'company_id' => $company->id, 'name' => 'CUSTOMS', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
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
