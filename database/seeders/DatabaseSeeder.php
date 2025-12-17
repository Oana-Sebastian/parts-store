<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Part;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@parts.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@parts.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);

        $parts = [
            [
                'name' => 'Front Disc Brake',
                'code' => 'BRK-001',
                'description' => 'Ventilated disc brake for the front wheel, compatible with most European models.',
                'price' => 250.00,
                'stock' => 15,
                'category' => 'Braking',
                'manufacturer' => 'Brembo',
                'images' => [
                    'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800',
                    'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800'
                ]
            ],
            [
                'name' => 'Oil Filter',
                'code' => 'ENG-002',
                'description' => 'High-performance oil filter for diesel and gasoline engines.',
                'price' => 45.00,
                'stock' => 50,
                'category' => 'Engine',
                'manufacturer' => 'Bosch',
                'images' => [
                    'https://images.unsplash.com/photo-1605732562742-3023a888e56e?w=800'
                ]
            ],
            [
                'name' => 'Front Shock Absorber',
                'code' => 'SUS-003',
                'description' => 'Gas telescopic shock absorber for front suspension, adjustable.',
                'price' => 380.00,
                'stock' => 8,
                'category' => 'Suspension',
                'manufacturer' => 'Monroe',
                'images' => [
                    'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800'
                ]
            ],
            [
                'name' => '12V 70Ah Car Battery',
                'code' => 'ELC-004',
                'description' => 'Maintenance-free car battery with AGM technology.',
                'price' => 420.00,
                'stock' => 12,
                'category' => 'Electrical System',
                'manufacturer' => 'Varta',
                'images' => [
                    'https://images.unsplash.com/photo-1593941707882-a5bba14938c7?w=800'
                ]
            ],
            [
                'name' => 'Rear Brake Pad Set',
                'code' => 'BRK-005',
                'description' => 'Ceramic brake pads for the rear wheel, low noise.',
                'price' => 180.00,
                'stock' => 20,
                'category' => 'Braking',
                'manufacturer' => 'Brembo',
                'images' => [
                    'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=800'
                ]
            ],
            [
                'name' => 'Air Filter',
                'code' => 'ENG-006',
                'description' => 'High-performance sport air filter, washable and reusable.',
                'price' => 120.00,
                'stock' => 30,
                'category' => 'Engine',
                'manufacturer' => 'K&N',
                'images' => [
                    'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800'
                ]
            ],
            [
                'name' => '17" Alloy Wheels',
                'code' => 'WHL-007',
                'description' => 'Set of 4 lightweight alloy wheels, sporty design, anthracite finish.',
                'price' => 1200.00,
                'stock' => 4,
                'category' => 'Wheels',
                'manufacturer' => 'OZ Racing',
                'images' => [
                    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800'
                ]
            ],
            [
                'name' => 'Iridium Spark Plugs Set',
                'code' => 'ENG-008',
                'description' => 'Set of 4 iridium electrode spark plugs, extended lifespan.',
                'price' => 180.00,
                'stock' => 25,
                'category' => 'Engine',
                'manufacturer' => 'NGK',
                'images' => [
                    'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800'
                ]
            ]
        ];

        foreach ($parts as $partData) {
            Part::create($partData);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@parts.com / password123');
        $this->command->info('User: user@parts.com / password123');
    }
}