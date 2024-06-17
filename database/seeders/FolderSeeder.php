<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;
use App\Models\Cases; // Ensure you import the Cases model
use App\Models\Folders;
use Illuminate\Support\Str;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve all cases
        $cases = Cases::all();

        // Check if there are cases available
        if ($cases->isEmpty()) {
            $this->command->info('No cases available to create folders.');
            return;
        }

        // Iterate over each case and create a folder
        foreach ($cases as $case) {
            Folders::create([
                'cases_id' => $case->id,
                'folder_name' => 'Folder ' . Str::random(10),
                'type' => $this->getRandomType(),
            ]);
        }

        $this->command->info('Folders created successfully.');
    }

    /**
     * Get a random type from the list of types.
     *
     * @return string
     */
    private function getRandomType()
    {
        $types = [
            'criminal case',
            'civil case',
            'admin case',
            'nps docketed',
            'pending case',
            'land transfer',
            'annulment',
            'blue box',
            'land issue',
        ];

        return $types[array_rand($types)];
    }
}
