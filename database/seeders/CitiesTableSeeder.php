<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = Province::all();

        if ($provinces->isEmpty()) {
            $this->command->error('Tidak ada provinsi yang ditemukan di database. Silakan seed provinsi terlebih dahulu.');
            return;
        }

        $allCities = $this->fetchAllCities($provinces);

        if (empty($allCities)) {
            $this->command->error('Gagal mengambil kota dari API.');
            return;
        }

        $this->storeCities($allCities);

        $this->command->info('Tabel kota berhasil di-seed.');
    }

    // private function fetchAllCities($provinces): array
    // {
    //     $allCities = [];

    //     foreach ($provinces as $province) {
    //         $response = Http::withHeaders([
    //             'Key' => config('rajaongkir.api_key'),
    //             'Accept' => 'application/json',
    //         ])->get(config('rajaongkir.endpoints.city') . '/' . $province->id);

    //         if ($response->failed()) {
    //             $this->command->warn("Gagal mengambil kota untuk ID provinsi: {$province->id}");
    //             continue;
    //         }

    //         $cities = $response->json()['data'] ?? [];

    //         foreach ($cities as &$city) {
    //             $city['province_id'] = $province->id;
    //         }

    //         if (!empty($cities)) {
    //             $allCities = array_merge($allCities, $cities);
    //         }
    //     }

    //     return $allCities;
    // }

    // private function fetchAllCities($provinces): array
    // {
    //     // ✅ MODE DUMMY
    //     if (config('rajaongkir.use_dummy')) {
    //         return [
    //             ['id' => 501, 'province_id' => 17, 'name' => 'Jakarta Pusat'],
    //             ['id' => 502, 'province_id' => 17, 'name' => 'Jakarta Utara'],
    //             ['id' => 114, 'province_id' => 18, 'name' => 'Bandung'],
    //             ['id' => 115, 'province_id' => 18, 'name' => 'Bekasi'],
    //             ['id' => 116, 'province_id' => 18, 'name' => 'Bogor'],
    //         ];
    //     }

    //     // ✅ MODE API ASLI
    //     $allCities = [];

    //     foreach ($provinces as $province) {
    //         $response = Http::withHeaders([
    //             'key' => config('rajaongkir.api_key'), // 🔧 fix kecil
    //             'Accept' => 'application/json',
    //         ])->get(config('rajaongkir.endpoints.city') . '/' . $province->id);

    //         if ($response->failed()) {
    //             $this->command->warn("Gagal mengambil kota untuk ID provinsi: {$province->id}");
    //             continue;
    //         }

    //         $data = $response->json();

    //         $cities = $data['data'] 
    //             ?? $data['rajaongkir']['results'] 
    //             ?? [];

    //         foreach ($cities as &$city) {
    //             $city['province_id'] = $province->id;
    //         }

    //         $allCities = array_merge($allCities, $cities);
    //     }

    //     return $allCities;
    // }

    private function fetchAllCities($provinces): array
{
    $allCities = [];

    foreach ($provinces as $province) {

        $url = "https://wilayah.id/api/regencies/{$province->id}.json";

        $response = Http::get($url);

        if ($response->failed()) {
            $this->command->warn("Gagal ambil kota provinsi ID: {$province->id}");
            continue;
        }

        $data = $response->json();

        foreach ($data['data'] as $city) {
            $allCities[] = [
                'id' => $city['code'], // 🔥 penting
                'province_id' => $province->id,
                'name' => $city['name'],
            ];
        }
    }

    return $allCities;
}

    // private function storeCities(array $cities): void
    // {
    //     $data = collect($cities)->map(function ($city) {
    //         return [
    //             'id' => $city['id'],
    //             'province_id' => $city['province_id'],
    //             'name' => $city['name'],
    //         ];
    //     })->toArray();

    //     City::insert($data);
    // }

    private function storeCities(array $cities): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        City::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = collect($cities)->map(function ($city) {
            return [
                'province_id' => $city['province_id'],
                'name' => $city['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        City::insert($data);
    }
}