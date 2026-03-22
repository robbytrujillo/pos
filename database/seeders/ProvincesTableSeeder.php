<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvincesTableSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = $this->fetchProvinces();

        if ($provinces === null) {
            $this->command->error('Failed to fetch provinces from API.');
            return;
        }

        $this->storeProvinces($provinces);

        $this->command->info('Provinces table seeded successfully.');
    }

    // private function fetchProvinces(): ?array
    // {
    //     $response = Http::withHeaders([
    //         'Key' => config('rajaongkir.api_key'),
    //         'Accept' => 'application/json',
    //     ])->get(config('rajaongkir.endpoints.province'));

    //     if ($response->failed()) {
    //         $this->command->error('API Response Status: ' . $response->status());
    //         $this->command->error('API Response Body: ' . $response->body());
    //         return null;
    //     }

    //     $data = $response->json();

    //     return $data['data'] ?? null;
    // }

    private function fetchProvinces(): ?array
    {
        // kalau pakai dummy → langsung return data lokal
        if (config('rajaongkir.use_dummy')) {
            return [
                ['id' => 1, 'name' => 'Nanggroe Aceh Darussalam'],
                ['id' => 2, 'name' => 'Sumatera Utara'],
                ['id' => 3, 'name' => 'Sumatera Selatan'],
                ['id' => 4, 'name' => 'Sumatera Barat'],
                ['id' => 5, 'name' => 'Bengkulu'],
                ['id' => 6, 'name' => 'Riau'],
                ['id' => 7, 'name' => 'Kepulauan Riau'],
                ['id' => 8, 'name' => 'Jambi'],
                ['id' => 9, 'name' => 'Lampung'],
                ['id' => 10, 'name' => 'Bangka Belitung'],
                ['id' => 11, 'name' => 'Kalimantan Barat'],
                ['id' => 12, 'name' => 'Kalimantan Timur'],
                ['id' => 13, 'name' => 'Kalimantan Selatan'],
                ['id' => 14, 'name' => 'Kalimantan Tengah'],
                ['id' => 15, 'name' => 'Kalimantan Utara'],
                ['id' => 16, 'name' => 'Banten'],
                ['id' => 17, 'name' => 'DKI Jakarta'],
                ['id' => 18, 'name' => 'Jawa Barat'],
                ['id' => 19, 'name' => 'Jawa Tengah'],
                ['id' => 20, 'name' => 'Daerah Istimewa Yogyakarta'],
                ['id' => 21, 'name' => 'Jawa Timur'],
                ['id' => 22, 'name' => 'Bali'],
                ['id' => 23, 'name' => 'Nusa Tenggara Timur'],
                ['id' => 24, 'name' => 'Nusa Tenggara Barat'],
                ['id' => 25, 'name' => 'Gorontalo'],
                ['id' => 26, 'name' => 'Sulawesi Barat'],
                ['id' => 27, 'name' => 'Sulawesi Tengah'],
                ['id' => 28, 'name' => 'Sulawesi Utara'],
                ['id' => 29, 'name' => 'Sulawesi Tenggara'],
                ['id' => 30, 'name' => 'Sulawesi Selatan'],
                ['id' => 31, 'name' => 'Maluku Utara'],
                ['id' => 32, 'name' => 'Maluku'],
                ['id' => 33, 'name' => 'Papua Barat'],
                ['id' => 34, 'name' => 'Papua'],
                ['id' => 35, 'name' => 'Papua Tengah'],
                ['id' => 36, 'name' => 'Papua Pegunungan'],
                ['id' => 37, 'name' => 'Papua Selatan'],
                ['id' => 38, 'name' => 'Papua Barat Daya'],
                
            ];
        }

        // kalau pakai API asli
        $response = Http::withHeaders([
            'Key' => config('rajaongkir.api_key'),
            'Accept' => 'application/json',
        ])->get(config('rajaongkir.endpoints.province'));

        if ($response->failed()) {
            $this->command->error('API Response Status: ' . $response->status());
            return null;
        }

        $data = $response->json();

        return $data['data'] ?? null;
    }

    private function storeProvinces(array $provinces): void
    {
        Province::truncate();
        
        $data = collect($provinces)->map(function ($province) {
            return [
                'id' => $province['id'],
                'name' => $province['name'],
            ];
        })->toArray();

        Province::insert($data);
    }
}