<?php

use Illuminate\Database\Seeder;
use App\Models\Committee;

class CommitteeSeeder extends Seeder
{
    public function run(): void
    {
        $committees = [
            ['committee_name' => 'Committee on Peace and Order',                                         'chairperson' => 'Kap Robert',      'description' => 'Responsible for maintaining peace, order, and public safety in the barangay.',           'status' => 'Active'],
            ['committee_name' => 'Committee on Health',                                                  'chairperson' => 'Kgd Doc Twinkle', 'description' => 'Oversees health programs, sanitation, and medical assistance for barangay residents.',    'status' => 'Active'],
            ['committee_name' => 'Committee on Education',                                               'chairperson' => 'Kgd Fred Sicat',  'description' => 'Handles educational programs, scholarships, and literacy initiatives.',                  'status' => 'Active'],
            ['committee_name' => 'Committee on Infrastructure',                                          'chairperson' => 'Kgd Euler',       'description' => 'Manages barangay infrastructure projects, roads, and public facilities.',                 'status' => 'Active'],
            ['committee_name' => 'Committee on Environment',                                             'chairperson' => 'Kgd Medel',       'description' => 'Leads environmental protection, waste management, and greening programs.',               'status' => 'Active'],
            ['committee_name' => 'Committee on Livelihood',                                              'chairperson' => 'Kgd Fred',        'description' => 'Develops livelihood programs and economic opportunities for residents.',                  'status' => 'Active'],
            ['committee_name' => 'Committee on Transport and Communication',                             'chairperson' => 'Kgd Bem',         'description' => 'Coordinates local transportation and communication services.',                           'status' => 'Active'],
            ['committee_name' => 'Committee on Barangay Disaster Risk Reduction & Management (BDRRM)',   'chairperson' => 'Kgd Joel',        'description' => 'Leads disaster preparedness, response, and recovery efforts in the barangay.',           'status' => 'Active'],
        ];

        foreach ($committees as $committee) {
            Committee::create($committee);
        }
    }
}