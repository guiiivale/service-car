<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    public function run() : void
    {
        $services = [
            [
                'name' => 'Higienização Interna',
                'description' => 'Serviço de higienização interna de veículos, incluindo limpeza de estofados e painel.',
                'suggested_price' => 100.00,
                'suggested_duration' => 120,
                'category_slug' => 'higienizacao',
                'is_available' => true,
                'image' => 'higienizacao.jpg',
            ],
            [
                'name' => 'Polimento e Cristalização',
                'description' => 'Serviço de polimento e cristalização da pintura do veículo, deixando-o com brilho intenso e proteção.',
                'suggested_price' => 250.00,
                'suggested_duration' => 180,
                'category_slug' => 'polimento',
                'is_available' => true,
                'image' => 'polimento.jpg',
            ],
        ];

        foreach ($services as $serviceData) {
            $category = ServiceCategory::where('slug', $serviceData['category_slug'])->first();

            if ($category) {
                $service = new Service([
                    'name' => $serviceData['name'],
                    'description' => $serviceData['description'],
                    'suggested_price' => $serviceData['suggested_price'],
                    'suggested_duration' => $serviceData['suggested_duration'],
                    'is_available' => $serviceData['is_available'],
                    'image' => $serviceData['image'],
                ]);

                $service->category()->associate($category);
                $service->save();
            }
        }
    }
}