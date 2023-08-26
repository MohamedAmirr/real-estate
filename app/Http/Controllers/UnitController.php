<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Image;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UnitController extends Controller
{
    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->validated());

        $images = $request->file('images');
        if ($images)
            foreach ($images as $imageFile) {
                $image = new Image;
                $path = $imageFile->store('/images/resource', ['disk' => 'my_files']);
                $image->src = $path;
                $image->unit_id = $unit->id;
                $image->save();
            }

        return response()->json([
            'message' => 'Unit created successfully',
            'id' => $unit->id
        ], 201);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());

        $images = $request->file('images');
        if ($images)
            foreach ($images as $imageFile) {
                $image = new Image;
                $path = $imageFile->store('/images/resource', ['disk' => 'my_files']);
                $image->src = $path;
                $image->unit_id = $unit->id;
                $image->save();
            }

        return response()->json([
            'message' => 'Unit updated successfully',
            'unit' => $unit
        ], 200);
    }

    public function read(Unit $unit)
    {
        return response()->json([
            $unit
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
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->unit_id = $unit->id;
        $transaction->save();
        return $transaction;
    }

    public function buy(Unit $unit)
    {
        $user = $this->getUserFromToken();
        $transaction = $this->createNewTransaction($unit, $user);
        return response()->json([
            'message' => 'Success',
            'body' => $transaction
        ], 200);
    }
}
