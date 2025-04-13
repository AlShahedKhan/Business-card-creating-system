<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CardRequest;

class CardController extends Controller
{
    use ApiResponse;

    /**
     * Get all cards.
     */
    public function index(): JsonResponse
    {
        return $this->safeCall(fn() =>
            $this->successResponse('Cards retrieved successfully.', Card::all())
        );
    }

    /**
     * Show a specific card by ID.
     */
    public function show($id): JsonResponse
    {
        return $this->safeCall(function () use ($id) {
            $card = Card::find($id);

            if (!$card) {
                return $this->errorResponse('Card not found.', 404);
            }

            return $this->successResponse('Card retrieved successfully.', $card);
        });
    }

    /**
     * Create or update a card.
     */
    public function storeOrUpdate(CardRequest $request, $id = null): JsonResponse
    {
        return $this->safeCall(function () use ($request, $id) {
            $validated = $request->validated();

            $card = $id ? Card::find($id) : new Card();

            if (!$card && $id) {
                return $this->errorResponse('Card not found.', 404);
            }

            $card->fill($validated)->save();

            $message = $id ? 'Card updated successfully.' : 'Card created successfully.';

            return $this->successResponse($message, $card, $id ? 200 : 201);
        });
    }

    /**
     * Delete a card by ID.
     */
    public function destroy($id): JsonResponse
    {
        return $this->safeCall(function () use ($id) {
            $card = Card::find($id);

            if (!$card) {
                return $this->errorResponse('Card not found.', 404);
            }

            $card->delete();

            return $this->successResponse('Card deleted successfully.', null);
        });
    }

}
