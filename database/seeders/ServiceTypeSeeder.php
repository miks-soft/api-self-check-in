<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\ServiceType;
use App\Models\ServiceTypeData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'slug' => 'capsule',
                'data' => [
                    ['lang' => 'ru', 'name' => 'Капсулы для сна'],
                    ['lang' => 'en', 'name' => 'Sleep Capsules'],
                ],
            ],
            [
                'slug' => 'hotel',
                'data' => [
                    ['lang' => 'ru', 'name' => 'Номера'],
                    ['lang' => 'en', 'name' => 'Rooms'],
                ],
            ],
            [
                'slug' => 'vip',
                'data' => [
                    ['lang' => 'ru', 'name' => 'VIP зал'],
                    ['lang' => 'en', 'name' => 'VIP-Lounge'],
                ],
            ],
            [
                'slug' => 'lounge',
                'data' => [
                    ['lang' => 'ru', 'name' => 'Бизнес зал'],
                    ['lang' => 'en', 'name' => 'Business-Lounge'],
                ],
            ],
            [
                'slug' => 'fasttrack',
                'data' => [
                    ['lang' => 'ru', 'name' => 'FastTrack'],
                    ['lang' => 'en', 'name' => 'FastTrack'],
                ],
            ],
            [
                'slug' => 'meet&greet',
                'data' => [
                    ['lang' => 'ru', 'name' => 'Meet & Greet'],
                    ['lang' => 'en', 'name' => 'Meet & Greet'],
                ],
            ],
            [
                'slug' => 'additional',
                'data' => [
                    ['lang' => 'ru', 'name' => 'Дополнительные услуги'],
                    ['lang' => 'en', 'name' => 'Additional services'],
                ],
            ],
        ];

        foreach ($types as $t) {
            $type = ServiceType::create(['slug' => $t['slug']]);
            foreach ($t['data'] as $d) {
                if ($language = Language::where('code', $d['lang'])->first()) {
                    ServiceTypeData::create([
                        'name' => $d['name'],
                        'type_id' => $type->id,
                        'lang_id' => $language->id,
                    ]);
                }
            }
        }
    }
}
