<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

    // private function fetchProvinces(): ?array
    // {
    //     // kalau pakai dummy → langsung return data lokal
    //     if (config('rajaongkir.use_dummy')) {
    //         return [
    //             ['id' => 11, 'name' => 'Nanggroe Aceh Darussalam'],
    //             ['id' => 12, 'name' => 'Sumatera Utara'],
    //             ['id' => 13, 'name' => 'Sumatera Barat'],
    //             ['id' => 14, 'name' => 'Riau'],
    //             ['id' => 15, 'name' => 'Jambi'],
    //             ['id' => 16, 'name' => 'Sumatera Selatan'],
    //             ['id' => 17, 'name' => 'Bengkulu'],
    //             ['id' => 18, 'name' => 'Lampung'],
    //             ['id' => 19, 'name' => 'Bangka Belitung'],
    //             ['id' => 21, 'name' => 'Kepulauan Riau'],
    //             ['id' => 31, 'name' => 'DKI Jakarta'],
    //             ['id' => 32, 'name' => 'Jawa Barat'],
    //             ['id' => 33, 'name' => 'Jawa Tengah'],
    //             ['id' => 34, 'name' => 'Daerah Istimewa Yogyakarta'],
    //             ['id' => 35, 'name' => 'Jawa Timur'],
    //             ['id' => 36, 'name' => 'Banten'],
    //             ['id' => 51, 'name' => 'Bali'],
    //             ['id' => 52, 'name' => 'Nusa Tenggara Barat'],
    //             ['id' => 53, 'name' => 'Nusa Tenggara Timur'],
    //             ['id' => 61, 'name' => 'Kalimantan Barat'],
    //             ['id' => 62, 'name' => 'Kalimantan Tengah'],
    //             ['id' => 63, 'name' => 'Kalimantan Selatan'],
    //             ['id' => 64, 'name' => 'Kalimantan Timur'],
    //             ['id' => 65, 'name' => 'Kalimantan Utara'],
    //             ['id' => 71, 'name' => 'Sulawesi Utara'],
    //             ['id' => 72, 'name' => 'Sulawesi Tengah'],
    //             ['id' => 73, 'name' => 'Sulawesi Selatan'],
    //             ['id' => 74, 'name' => 'Sulawesi Tenggara'],
    //             ['id' => 75, 'name' => 'Gorontalo'],
    //             ['id' => 76, 'name' => 'Sulawesi Barat'],
    //             ['id' => 81, 'name' => 'Maluku'],
    //             ['id' => 82, 'name' => 'Maluku Utara'],
    //             ['id' => 91, 'name' => 'Papua'],
    //             ['id' => 92, 'name' => 'Papua Barat'],
    //             ['id' => 93, 'name' => 'Papua Tengah'],
    //             ['id' => 94, 'name' => 'Papua Pegunungan'],
    //             ['id' => 95, 'name' => 'Papua Selatan'],
    //             ['id' => 96, 'name' => 'Papua Barat Daya'],
                
    //         ];
    //     }

    //     // kalau pakai API asli
    //     $response = Http::withHeaders([
    //         'key' => config('rajaongkir.api_key'),
    //         'Accept' => 'application/json',
    //     ])->get(config('rajaongkir.endpoints.province'));

    //     if ($response->failed()) {
    //         $this->command->error('API Response Status: ' . $response->status());
    //         return null;
    //     }

    //     $data = $response->json();

    //     return $data['data'] ?? null;
    // }

    private function fetchProvinces(): ?array
{
    $response = Http::get('https://wilayah.id/api/provinces.json');

    if ($response->failed()) {
        $this->command->error('Gagal ambil provinsi dari wilayah.id');
        return null;
    }

    $data = $response->json();

    return collect($data['data'])->map(function ($prov) {
        return [
            'id' => $prov['code'], // 🔥 penting
            'name' => $prov['name'],
        ];
    })->toArray();
}

    private function storeProvinces(array $provinces): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // 🔥

        Province::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // 🔥
        
        $data = collect($provinces)->map(function ($province) {
            return [
                'id' => $province['id'],
                'name' => $province['name'],
            ];
        })->toArray();

        Province::insert($data);
    }
}