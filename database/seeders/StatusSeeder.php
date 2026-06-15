<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Not Started',
            'In Progress',
            'Waiting on Client',
            'Waiting on USPTO',
            'Waiting on Copyright Office',
            'Waiting on 3rd Party',
            'Haitus',
            'Finalizing',
            'Assigned to Close',
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                [
                    'status_name' => $status,
                ],
                [
                    'added_by' => 1,
                ]
            );
        }
    }
}
