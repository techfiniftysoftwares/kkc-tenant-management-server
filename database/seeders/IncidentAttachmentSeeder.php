<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncidentAttachment;
use App\Models\Ticket;
use Faker\Factory as Faker;

class IncidentAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all ticket IDs
        $ticketIds = Ticket::pluck('id')->toArray();

        // Generate and insert fake data for incident attachments
        foreach (range(1, 50) as $index) {
            $attachment = new IncidentAttachment([
                'ticket_id' => $faker->randomElement($ticketIds),
                'file_path' => $faker->imageUrl(), 
            ]);
            $attachment->save();
        }
    }
}
