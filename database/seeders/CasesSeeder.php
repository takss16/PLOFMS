<?php

namespace Database\Seeders;

use App\Models\Cases;
use App\Models\Filecases;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some cases
        $case1 = Cases::create([
            'case_number' => 'Case001',
            'docker_number' => 'Docker001',
            'name' => 'John Doe',
        ]);

        $case2 = Cases::create([
            'case_number' => 'Case002',
            'docker_number' => 'Docker002',
            'name' => 'Jane Smith',
        ]);

        // Seed some filecases related to cases
        $this->seedFileCases($case1);
        $this->seedFileCases($case2);

        // You can add more cases and filecases as needed
    }

    /**
     * Seed file cases for a given case.
     *
     * @param  \App\Case  $case
     * @return void
     */
    protected function seedFileCases(Cases $case)
    {
        // Seed some file cases related to the given case
        Filecases::create([
            'cases_id' => $case->id,
            'file_name' => 'file1.txt', // Replace with actual file name or path
        ]);

        Filecases::create([
            'cases_id' => $case->id,
            'file_name' => 'file2.txt', // Replace with actual file name or path
        ]);
    }
}
