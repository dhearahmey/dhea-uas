<?php
namespace Database\Seeders;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'name' => 'Cuci Kering Reguler',
                'type' => 'cuci_kering',
                'price' => 8000,
                'duration' => 24,
                'description' => 'Cuci kering biasa, selesai 1 hari',
                'is_active' => true
            ],
            [
                'name' => 'Cuci Setrika Premium',
                'type' => 'cuci_setrika',
                'price' => 12000,
                'duration' => 24,
                'description' => 'Cuci + setrika rapi, selesai 1 hari',
                'is_active' => true
            ],
            [
                'name' => 'Express 6 Jam',
                'type' => 'express',
                'price' => 20000,
                'duration' => 6,
                'description' => 'Cepat selesai dalam 6 jam',
                'is_active' => true
            ],
            [
                'name' => 'Dry Clean',
                'type' => 'dry_clean',
                'price' => 25000,
                'duration' => 48,
                'description' => 'Dry clean khusus pakaian formal',
                'is_active' => true
            ]
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}