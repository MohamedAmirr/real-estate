<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Models\Image;
use App\Models\Unit;
use App\Services\FilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UnitController extends Controller
{
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

    public function filter(Request $request): JsonResponse
    {
        $filterService = new FilterService();
        return $filterService->filter($this->getFiltrationAttributes($request));
    }


}
