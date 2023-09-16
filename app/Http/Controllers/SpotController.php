<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Vaccine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpotController extends Controller
{
    function show()
    {
        $spots = Spot::with("spot_vaccines")->get();

        // ambil semua spot vaccines beserta vaccine untuk mengambil nama vaccine
        $spot_vaccines_with_vaccine_name = DB::table("spot_vaccines as spv")
            ->join("vaccines as vc", "spv.vaccine_id", "=", "vc.id")
            ->get(["spv.spot_id", "spv.vaccine_id", "vc.name"]);

        $vaccines = Vaccine::all(["id", "name"]);

        // buat data berbeda setiap data dalam tabel nya
        $data = [];

        // ambil semua spot
        foreach ($spots as $sp) {
            $available_vaccines = [];

            // beri semua nilai dalam spot vaccines  menjadi key dalam name dan false sebagai value
            foreach ($vaccines as $vc) {
                $available_vaccines[$vc["name"]] = false;
            }

            // jika spot id yang di looping sama dengan id available vaccine 
            // maka khsusus key nama vaccine yang ada kita set value nya menjadi true
            foreach ($spot_vaccines_with_vaccine_name as $spv_avilable) {
                if ($sp->id == $spv_avilable->spot_id) {
                    $available_vaccines[$spv_avilable->name] = true;
                }
            }

            $data[] = [
                "name" => $sp->name,
                "address" => $sp->address,
                "serve" => $sp->serve,
                "capacity" => $sp->capacity,
                "available_vaccines" => $available_vaccines
            ];
        }
        return response()->json([
            "spots" => $data
        ]);
    }
    public function spot_detail(int $spot_id, Request $request)
    {
        $date = $request->date("date");
        if ($date) {
            $date = $date->format("Y-m-d");
        } else {
            $date = date("Y-m-d");
        }

        $data = Spot::whereDate("created_at", $date)->where("id",$spot_id)->get(["id","name","address","serve","capacity"]);
        return response()->json([
            "date" => date("F d, Y",strtotime($date)),
            "spot" => $data,
            "vaccinations_count" => count($data)
        ]);
    }
}
