<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Location;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Locations
        $rak_a  = Location::firstOrCreate(['name' => 'Rak A'], ['room' => 'Ruang Utama']);
        $rak_b  = Location::firstOrCreate(['name' => 'Rak B'], ['room' => 'Ruang Utama']);
        $lemari = Location::firstOrCreate(['name' => 'Lemari C'], ['room' => 'Gudang']);

        $items = [
            [
                'code'            => 'ITM-001',
                'name'            => 'Oscilloscope Digital DS1054',
                'description'     => 'Oscilloscope digital 4 channel, bandwidth 50MHz. Cocok untuk analisis sinyal.',
                'location_id'     => $rak_a->id,
                'condition'       => 'baik',
                'total_stock'     => 5,
                'available_stock' => 5,
            ],
            [
                'code'            => 'ITM-002',
                'name'            => 'Multimeter Digital Fluke 117',
                'description'     => 'Multimeter true-RMS untuk pengukuran tegangan, arus, dan resistansi.',
                'location_id'     => $rak_a->id,
                'condition'       => 'baik',
                'total_stock'     => 10,
                'available_stock' => 8,
            ],
            [
                'code'            => 'ITM-003',
                'name'            => 'Function Generator GW Instek',
                'description'     => 'Generator fungsi dengan frekuensi 0.1Hz - 3MHz.',
                'location_id'     => $rak_b->id,
                'condition'       => 'baik',
                'total_stock'     => 4,
                'available_stock' => 4,
            ],
            [
                'code'            => 'ITM-004',
                'name'            => 'Power Supply DC Variable',
                'description'     => 'Sumber tegangan DC 0-30V, 0-5A adjustable.',
                'location_id'     => $rak_b->id,
                'condition'       => 'baik',
                'total_stock'     => 6,
                'available_stock' => 6,
            ],
            [
                'code'            => 'ITM-005',
                'name'            => 'Breadboard Besar 830 Titik',
                'description'     => 'Breadboard prototyping 830 titik untuk rangkaian elektronika.',
                'location_id'     => $lemari->id,
                'condition'       => 'baik',
                'total_stock'     => 20,
                'available_stock' => 17,
            ],
            [
                'code'            => 'ITM-006',
                'name'            => 'Arduino Uno R3',
                'description'     => 'Mikrokontroler berbasis ATmega328P untuk proyek embedded.',
                'location_id'     => $lemari->id,
                'condition'       => 'baik',
                'total_stock'     => 15,
                'available_stock' => 12,
            ],
            [
                'code'            => 'ITM-007',
                'name'            => 'LCR Meter Digital',
                'description'     => 'Alat ukur induktansi, kapasitansi, dan resistansi presisi tinggi.',
                'location_id'     => $rak_a->id,
                'condition'       => 'rusak',
                'total_stock'     => 2,
                'available_stock' => 0,
            ],
            [
                'code'            => 'ITM-008',
                'name'            => 'Raspberry Pi 4 Model B',
                'description'     => 'Single-board computer RAM 4GB untuk proyek IoT dan komputasi.',
                'location_id'     => $lemari->id,
                'condition'       => 'baik',
                'total_stock'     => 8,
                'available_stock' => 8,
            ],
        ];

        foreach ($items as $item) {
            Item::firstOrCreate(['code' => $item['code']], $item);
        }

        $this->command->info('✅ Sample items created!');
    }
}
