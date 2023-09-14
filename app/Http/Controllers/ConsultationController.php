<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationRequest;
use App\Models\Consultations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ResponseInterface;

class ConsultationController extends Controller
{
    function show(): JsonResponse
    {
        $user = Auth::user();
        $data = Consultations::with("medical")->where("user_id", $user->id)->first(["id", "status", "current_symptoms", "disease_history", "notes"]);
        $consultation = null;
        if ($data) {
            $consultation = [
                "id" => $data->id,
                "status" => $data->status,
                "current_symptoms" => $data->current_symptoms,
                "disease_history" => "$data->disease_history",
                "notes" => $data->notes,
                "doctor" => $data->medical
            ];
        }
        return response()->json([
            "consultation" => $consultation
        ])->setStatusCode(200);
    }

    function store(StoreConsultationRequest $request): JsonResponse
    {

        $user = Auth::user();
        Consultations::create([
            "user_id" => $user->id,
            "disease_history" => $request["disease_history"],
            "current_symptoms" => $request["current_symptoms"]
        ]);
        return response()->json([
            "message" => "Request consultation sent successful"
        ])->setStatusCode(201);
    }
}
