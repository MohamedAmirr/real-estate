<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Models\Image;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class UnitController extends Controller
{
    private function saveImages($images, Unit $unit)
    {
        $imagesData = [];
        foreach ($images as $imageFile) {
            $data = [
                'path' => $imageFile->store('', ['disk' => 'upload']),
                'unit_id' => $unit->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $imagesData[] = $data;
        }
        Image::insert($imagesData);
    }

    public function store(UnitStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $unit = Unit::create($request->validated());

            $images = $request->file('images');
            if ($images) {
                $this->saveImages($images, $unit);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
        }

        return response()->json([
            'message' => 'Unit created successfully',
            'id' => $unit->id
        ], 201);
    }

    public function update(UnitUpdateRequest $request, Unit $unit)
    {
        try {
            DB::beginTransaction();
            $unit->update($request->validated());

            $images = $request->file('images');

            if ($images) {
                $this->saveImages($images, $unit);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
        }

        return response()->json([
            'message' => 'Unit updated successfully',
            'unit' => new UnitResource($unit)
        ], 200);
    }

    public function show(Unit $unit)
    {
        return response()->json([
            'unit' => new UnitResource($unit),
        ], 200);
    }

    public function delete(Unit $unit)
    {
        $unit->delete();
        return response()->json([
            'message' => 'unit deleted successfully'
        ], 200);
    }


    private function getUserFromToken()
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        return $token->tokenable;
    }

    private function createNewTransaction(Unit $unit, User $user)
    {
        return Transaction::create([
            'user_id'=>$user->id,
            'unit_id'=>$unit->id,
        ])->id;
    }

    public function buy(Unit $unit)
    {
        if($unit->is_sold) {
            return response()->json([
                'message' => 'Unit is sold out'
            ], 403);
        }

        $user = $this->getUserFromToken();
        $transaction = $this->createNewTransaction($unit, $user);
        return response()->json([
            'message' => 'Success',
            'body' => $transaction
        ], 200);
    }
}
