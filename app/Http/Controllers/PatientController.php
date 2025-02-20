<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function fetchpatients(Request $request) {
        $sortBy = $request->query('sortBy', 'id'); 
        $order = $request->query('order', 'asc');  
    
        $allowedColumns = ['id', 'fname', 'lname', 'bdate', 'mname'];
        $allowedOrders = ['asc', 'desc'];
    
        if (!in_array($sortBy, $allowedColumns)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid sorting column.'
            ], 400);
        }
    
        if (!in_array($order, $allowedOrders)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid sorting order. Use asc or desc.'
            ], 400);
        }
    
        $patients = Patient::orderBy($sortBy, $order)->get();
    
        return response()->json([
            'success' => true,
            'data' => $patients,
        ], 200);
    }    

    public function addpatient(Request $request) {

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'sex' => 'required|string|in:Male,Female,Other',
            'bdate' => 'required|date',
            'civstat' => 'required|string|max:50',
            'nlity' => 'required|string|max:100',
            'hadd' => 'required|string|max:255',
            'badd' => 'nullable|string|max:255',
            'pnum' => 'required|string|max:20',
            'email' => 'required|email|unique:patients,email',
            'philnum' => 'nullable|string|max:50',
            'occup' => 'nullable|string|max:100',
            'rlgion' => 'nullable|string|max:100',
            'dpcon' => 'required|boolean',
            'sdel' => 'boolean',
        ]);

            $patient = Patient::create($validated);

        return response()->json([
            'message' => 'Patient added successfully',
            'patient' => $patient
        ], 201);
    }

    public function findpatient($id){

        $patient = Patient::find($id);
        if (!$patient || $patient->sdel) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json(['data' => $patient], 200);
    }

    public function searchpatient(Request $request) {
        $query = $request->input('query');
    
        $patients = Patient::where('sdel', false)
            ->where(function($q) use ($query) {
                $q->where('fname', 'LIKE', "%{$query}%")
                  ->orWhere('mname', 'LIKE', "%{$query}%")
                  ->orWhere('lname', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();
    
        return response()->json(['data' => $patients], 200);
    }

    public function softDeletePatient($id) {
        $patient = Patient::find($id);

        if (!$patient || $patient->sdel) {
            return response()->json(['message' => 'Patient not found or already soft deleted'], 404);
        }

        $patient->sdel = true;
        $patient->save();

        return response()->json([
            'message' => 'Patient soft-deleted successfully',
            'data'    => $patient
        ], 200);
    }

    public function updatePatient(Request $request, $id) {
        $patient = Patient::find($id);
    
        if (!$patient || $patient->sdel) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
    
        $validated = $request->validate([
            'fname' => 'sometimes|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'sometimes|string|max:255',
            'sex' => 'sometimes|string|in:Male,Female,Other',
            'bdate' => 'sometimes|date',
            'civstat' => 'sometimes|string|max:50',
            'nlity' => 'sometimes|string|max:100',
            'hadd' => 'sometimes|string|max:255',
            'badd' => 'nullable|string|max:255',
            'pnum' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:patients,email,' . $id,
            'philnum' => 'nullable|string|max:50',
            'occup' => 'nullable|string|max:100',
            'rlgion' => 'nullable|string|max:100',
            'dpcon' => 'sometimes|boolean',
            'sdel' => 'boolean',
        ]);
    
        $patient->update($validated);
    
        return response()->json([
            'message' => 'Patient updated successfully',
            'patient' => $patient
        ], 200);
    }
}
