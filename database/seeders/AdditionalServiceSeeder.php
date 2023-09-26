<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Service;
use App\Models\ServiceData;
use App\Models\ServiceTariff;
use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ServiceType::where('slug', 'additional')->firstOrFail();

        $services = [
            [
                'slug' => 'slippers',
                'count' => 2,
                'price' => 200,
                'data' => [
                    ['lang' => 'ru', 'name' => 'Тапочки'],
                    ['lang' => 'en', 'name' => 'Slippers'],
                ],
            ],
            [
                'slug' => 'breakfast-to-go',
                'count' => 1,
                'price' => 450,
                'data' => [
                    ['lang' => 'ru', 'name' => 'Завтрак с собой'],
                    ['lang' => 'en', 'name' => 'Breakfast to go'],
                ],
            ],
            [
                'slug' => 'priority-package',
                'count' => 1,
                'price' => 625,
                'data' => [
                    ['lang' => 'ru', 'name' => 'Priority Package'],
                    ['lang' => 'en', 'name' => 'Priority Package'],
                ],
            ],
        ];

        Service::whereNull('parent_id')
            ->get()
            ->each(function (Service $service) use ($type, $services) {
                foreach ($services as $s) {
                    $additional = Service::create([
                        'slug' => $s['slug'],
                        'count' => $s['count'],
                        'parent_id' => $service->id,
                        'type_id' => $type->id,
                        'airport_id' => $service->airport_id,
                        'terminal_id' => $service->terminal_id,
                    ]);

                    ServiceTariff::create([
                        'price' => $s['price'],
                        'service_id' => $additional->id,
                    ]);

                    foreach ($s['data'] as $d) {
                        if ($language = Language::where('code', $d['lang'])->first()) {
                            ServiceData::create([
                                'name' => $d['name'],
                                'lang_id' => $language->id,
                                'service_id' => $additional->id,
                            ]);
                        }
                    }
                }
            });
    }
}
