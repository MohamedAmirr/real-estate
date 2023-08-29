<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UnitResource;
use App\Models\Image;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class UnitController extends Controller
{
    private function saveImages($images, Unit $unit): void
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

    public function store(UnitStoreRequest $request): JsonResponse
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

    public function update(UnitUpdateRequest $request, Unit $unit): JsonResponse
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

    public function show(Unit $unit): JsonResponse
    {
        return response()->json([
            'unit' => new UnitResource($unit),
        ], 200);
    }

    public function delete(Unit $unit): JsonResponse
    {
        $unit->delete();
        return response()->json([
            'message' => 'unit deleted successfully'
        ], 200);
    }


    private function getUserFromToken(): User
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        return $token->tokenable;
    }

    private function createNewTransaction(Unit $unit, User $user): Transaction
    {
        return Transaction::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
        ]);
    }

    public function buy(Unit $unit): JsonResponse
    {
        if ($unit->is_sold) {
            return response()->json([
                'message' => 'Unit is sold out'
            ], 403);
        }

        $user = $this->getUserFromToken();
        $transaction = $this->createNewTransaction($unit, $user);
        return response()->json([
            'message' => 'Success',
            'body' => new TransactionResource($transaction)
        ], 200);
    }
}
