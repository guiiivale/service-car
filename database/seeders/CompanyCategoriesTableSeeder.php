<?php

namespace Database\Seeders;

use App\Models\CompanyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyCategories = [
            [
                'title' => 'Oficina Mecânica Geral',
                'slug' => 'oficina-mecanica-geral',
                'description' => 'É uma oficina versátil que oferece serviços de manutenção e reparo em diversas áreas, como motor, suspensão, freios, transmissão e sistemas elétricos. Ela é capaz de lidar com uma ampla variedade de problemas mecânicos.',
            ],
        
            [
                'title' => 'Oficina de Funilaria e Pintura',
                'slug' => 'oficina-funilaria-e-pintura',
                'description' => 'Essa oficina é especializada em reparos de carroceria, como amassados, arranhões e danos causados por colisões. Além disso, também realiza serviços de pintura, para corrigir imperfeições na pintura do veículo e dar um acabamento estético adequado.',
            ],
        
            [
                'title' => 'Oficina de Autoelétrica',
                'slug' => 'oficina-autoeletrica',
                'description' => 'Essa oficina se concentra em diagnosticar e reparar problemas relacionados aos sistemas elétricos e eletrônicos do veículo, como problemas com a bateria, alternador, sistema de ignição, luzes e outros componentes elétricos.',
            ],
        
            [
                'title' => 'Oficina de Alinhamento e Balanceamento',
                'slug' => 'oficina-alinhamento-e-balanceamento',
                'description' => 'Essa oficina é especializada em alinhar as rodas do veículo, garantindo que estejam corretamente posicionadas em relação ao chão, o que evita o desgaste irregular dos pneus e melhora a dirigibilidade. Além disso, ela também realiza o balanceamento das rodas para evitar vibrações indesejadas.',
            ],
        
            [
                'title' => 'Oficina de Ar Condicionado Automotivo',
                'slug' => 'oficina-ar-condicionado-automotivo',
                'description' => 'Oferece serviços de manutenção e reparo do sistema de ar condicionado do veículo. Isso inclui verificação do nível de gás refrigerante, troca de filtro, reparo de vazamentos e solução de problemas relacionados à refrigeração.',
            ],
        
            [
                'title' => 'Oficina de Troca de Óleo e Lubrificação',
                'slug' => 'oficina-troca-de-oleo-e-lubrificacao',
                'description' => 'Especializada em realizar a troca de óleo do motor e outros fluidos essenciais, como o líquido de arrefecimento, fluido de freio e óleo da transmissão. Além disso, também pode oferecer serviços de lubrificação de peças móveis do veículo.',
            ],
        
            [
                'title' => 'Oficina de Injeção Eletrônica',
                'slug' => 'oficina-injecao-eletronica',
                'description' => 'Foca em diagnosticar e reparar problemas relacionados ao sistema de injeção eletrônica do veículo. Esse sistema controla a quantidade de combustível que entra no motor, garantindo um funcionamento eficiente e econômico.',
            ],
        
            [
                'title' => 'Oficina de Personalização e Tuning',
                'slug' => 'oficina-personalizacao-e-tuning',
                'description' => 'Essa oficina é voltada para personalizar e modificar carros de acordo com as preferências dos proprietários. Ela oferece serviços como instalação de acessórios, modificações estéticas, melhoria de desempenho, entre outros.',
            ],
        ];
        

        foreach ($companyCategories as $companyCategory) {
            CompanyCategory::create($companyCategory);
        }
    }
}
