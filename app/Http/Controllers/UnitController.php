<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\FilterUnitCollection;
use App\Http\Resources\FilterUnitResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UnitResource;
use App\Models\Image;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class UnitController extends Controller
{
    public function update(UnitUpdateRequest $request): JsonResponse
    {
        $unit = Unit::findOrFail($request->id);
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

    public function filter(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'body' => new FilterUnitCollection(
                Unit::latest()->filter(
                    request(['type', 'location', 'number_of_rooms', 'number_of_bathrooms', 'area'])
                )->paginate()
            )
        ], 200);
    }

    public function show(Request $request): JsonResponse
    {
        $unit = Unit::findOrFail($request->id);
        return response()->json([
            'unit' => new UnitResource($unit),
        ], 200);
    }

    public function delete(Request $request): JsonResponse
    {
        //TODO: if unit is sold, this function will return error
        $unit = Unit::findOrFail($request->id);
        $unit->delete();
        return response()->json([
            'message' => 'unit deleted successfully'
        ], 200);
    }

    public function buy(Request $request): JsonResponse
    {
        $unit = Unit::findOrFail($request->id);
        if ($unit->is_sold) {
            return response()->json([
                'message' => 'Unit is sold out'
            ], 403);
        }

        $user = Auth::user();

        $price = $unit->price;

        $transaction = $this->createNewTransaction($unit->id, $user->id, $price);

        return response()->json([
            'message' => 'Success',
            'body' => new TransactionResource($transaction)
        ], 200);
    }

    private function createNewTransaction(int $unitId, int $userId, int $price): Transaction
    {
        return Transaction::create([
            'user_id' => $userId,
            'unit_id' => $unitId,
            'price' => $price
        ]);
    }
}
