<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccinationRequest;
use App\Models\Consultations;
use App\Models\Vaccinations;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaccinationController extends Controller
{
    public function store(VaccinationRequest $request)
    {
        $user = Auth::user();
        $date = $request->date("date")->format("Y-m-d");
        $vaccinations = Vaccinations::where("spot_id", $request->input("spot_id"))->where("user_id", $user->id)->get();
        if (count($vaccinations) == 0) {
            // if the user never been vaccinated
            Vaccinations::create([
                "dose" => 1,
                "date" => date("Y-m-d"),
                "user_id" => $user->id,
                "spot_id" => $request->input("spot_id"),
                "vaccine_id" => 1,
                "medical_id" => 1
            ]);
            return response()->json([
                "message" => "First vaccination registered successful"
            ])->setStatusCode(201);
        } else if (count($vaccinations) == 2) {
            // if the user has been 2x vaccinated
            return response()->json([
                "message" => "Society has been 2x vaccinated"
            ])->setStatusCode(400);
        }
        // check if the consultation has been accepted or no
        $consultation = Consultations::where("user_id", $user->id)->get()->last();
        if ($consultation == null or  $consultation->status != "accepted") {
            return response()->json([
                "message" => "Your consultation must be accepted by doctor before"
            ])->setStatusCode(400);
        }
        $dateRegister = Carbon::parse($request->input("date"));
        $dateVaccinationFirst = Carbon::parse($vaccinations->first()->date);

        // the second vaccination must be > 30 day after first vaccination
        if ($dateVaccinationFirst->diffInDays($dateRegister) < 30) {
            return response()->json([
                "message" => "Wait at least +30 days from 1st Vaccination"
            ])->setStatusCode(400);
        }

        Vaccinations::create([
            "dose" => 2,
            "date" => date("Y-m-d"),
            "user_id" => $user->id,
            "spot_id" => $request->input("spot_id"),
            "vaccine_id" => 1,
            "medical_id" => 1
        ]);

        return response()->json([
            "message" => "Second vaccination registered successful"
        ])->setStatusCode(201);
    }

    public function show(Request $request)
    {
        $user_id = Auth::user()->id;
        $vaccinations = Vaccinations::with([
            "spot.regional" => [], "vaccine:id,name", "medical.doctor"
        ])->where("user_id", $user_id)->get()->toArray();
        $data = [
            "first" => null,
            "second" => null
        ];
        $idx = 1;
        foreach ($vaccinations as $vc) {
            unset($vc["spot"]["created_at"]);
            unset($vc["spot"]["updated_at"]);
            unset($vc["spot"]["regional"]["created_at"]);
            unset($vc["spot"]["regional"]["updated_at"]);
            $data[$idx == 1 ? "first" : "second"] = [
                "queue" => $idx,
                "vaccination_date" => $vc["date"],
                "spot" => [
                    ...$vc["spot"]
                ],
                "status" => "done",
                "vaccine" => $vc["vaccine"],
                "vaccinator" => [
                    "id" => $vc["medical"]["id"],
                    "role" => $vc["medical"]["role"],
                    "name" => $vc["medical"]["doctor"]["username"],
                ]
            ];
            $idx++;
        }
        return response()->json([
            "vaccinations" => $data
        ]);
    }
}
