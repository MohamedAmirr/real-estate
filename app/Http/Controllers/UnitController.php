<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Models\Image;
use App\Models\Unit;
use http\Env\Response;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function saveImages($images, Unit $unit)
    {
        foreach ($images as $imageFile) {
            $image = new Image;
            $path = $imageFile->store('', ['disk' => 'upload']);
            $image->path = $path;
            $image->unit_id = $unit->id;
            $image->save();
        }
    }

    public function store(UnitStoreRequest $request)
    {
        $unit = Unit::create($request->validated());

        $images = $request->file('images');
        if ($images) {
            $this->saveImages($images, $unit);
        }

        return response()->json([
            'message' => 'Unit created successfully',
            'id' => $unit->id
        ], 201);
    }

    public function update(UnitUpdateRequest $request, Unit $unit)
    {
        $unit->update($request->validated());

        $images = $request->file('images');

        if ($images) {
            $this->saveImages($images, $unit);
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


}
