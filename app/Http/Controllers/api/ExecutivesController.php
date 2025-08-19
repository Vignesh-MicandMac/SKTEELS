<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Executive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ExecutivesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|required|string|max:255',
            'mobile'      => 'sometimes|required|digits:10|unique:executives,mobile,',
            'address'     => 'nullable|string|max:255',
            'password'    => 'nullable|string|min:6|confirmed',
            'state_id'    => 'sometimes|required|exists:states,id',
            'district_id' => 'sometimes|required|exists:districts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $executive = Executive::create([
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'address'    => $request->address,
            'app_password' => Hash::make($request->password),
            'state_id'   => $request->state_id,
            'district_id' => $request->district_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Executive Created successfully',
            'executive' => $executive
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $executive = Executive::find($id);

        if (!$executive) {
            return response()->json([
                'status' => false,
                'message' => 'Executive not found'
            ], 404);
        }
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|required|string|max:255',
            'mobile'      => 'required|digits:10|nullable',
            'address'     => 'nullable|string|max:255',
            'password'    => 'nullable|string|min:6|confirmed',
            'state_id'    => 'sometimes|required|exists:states,id',
            'district_id' => 'sometimes|required|exists:districts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $executive->update([
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'address'    => $request->address,
            'app_password' => Hash::make($request->password),
            'state_id'   => $request->state_id,
            'district_id' => $request->district_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Executive updated successfully',
            'executive' => $executive
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $executive = Executive::find($id);

        if (!$executive) {
            return response()->json([
                'status' => false,
                'message' => 'Executive not found'
            ], 404);
        }

        $executive->delete();

        return response()->json([
            'status' => true,
            'message' => 'Executive deleted successfully'
        ], 200);
    }
}
