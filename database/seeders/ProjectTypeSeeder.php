<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        $projectTypes = [
            'Asset Protection Analysis',
            'Asset Protection',
            'Business Structure Analysis',
            'Cease & Desist',
            'Compliance',
            'Consulting',
            'Contract Review',
            'Contract Writing',
            'Copyright Registration',
            'Corporate Dissolution',
            'Corporate Formation',
            'Demand for Payment',
            'Domain Dispute Resolution',
            'LLC Dissolution',
            'LLC Formation',
            'Other',
            'Ownership Transfer',
            'Trademark Assignment',
            'Trademark ITU Extension',
            'Trademark Registration',
            'Trademark Renewal',
            'Trademark SOU Filings',
            'Various',
        ];

        foreach ($projectTypes as $projectType) {
            ProjectType::updateOrCreate(
                [
                    'project_type_name' => $projectType,
                ],
                [
                    'added_by' => 1,
                ]
            );
        }
    }
}
