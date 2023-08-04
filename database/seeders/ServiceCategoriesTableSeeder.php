<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Higienização',
                'slug' => 'higienizacao',
                'description' => 'A higienização de veículos é um conjunto de procedimentos que visam limpar e desinfetar o interior e exterior dos automóveis, tornando-os mais seguros, agradáveis e livres de sujeira, germes e odores indesejados.',
            ],
            [
                'title' => 'Polimento',
                'slug' => 'polimento',
                'description' => 'O polimento automotivo é um processo de embelezamento e conservação da pintura do veículo, que remove riscos, manchas e imperfeições, deixando-o com um acabamento brilhante e protegido contra agentes externos.',
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
