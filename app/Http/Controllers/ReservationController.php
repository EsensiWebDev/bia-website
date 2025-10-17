<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\CategoryTreatment;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function create()
    {
        $treatments = CategoryTreatment::orderBy('title')->get();
        return view('booknow', compact('treatments'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'preferred_date' => 'required|date',
            'preferred_time' => 'required|string',
            'required_service' => 'required|string|max:255',
            'country_of_origin' => 'required|string|max:255',
            'how_did_you_find_out' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        try {
            Reservation::create($data);
            return redirect()->back()->with('success', 'Reservation submitted successfully!');
        } catch (\Throwable $e) {
            Log::error('Reservation store error: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data,
            ]);

            if (config('app.debug')) {
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }

            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
}
