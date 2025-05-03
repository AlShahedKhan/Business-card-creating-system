<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CardRequest;
use Illuminate\Support\Facades\Log;
class CardController extends Controller
{
    use ApiResponse;

    /**
     * Get all cards.
     */
    public function index(): JsonResponse
    {
        return $this->safeCall(fn() =>
            $this->successResponse('Cards retrieved successfully.', Card::paginate(10))
        );
    }


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

    // public function storeOrUpdate(CardRequest $request, $id = null)
    // {
    //     // Retrieve the 'data' as a JSON string from the request
    //     $data = json_decode($request->input('data'), true);

    //     // Check if the card exists for updating, or create a new instance
    //     $card = $id ? Card::findOrFail($id) : new Card();

    //     // If there is an uploaded image for the logo, handle the file upload
    //     if ($request->hasFile('logo')) {
    //         $path = $request->file('logo')->store('address_logos', 'public');
    //         $data['address_logo'] = $path;  // Save the file path in the data
    //     }

    //     // Update or create the card record
    //     $card->fill($data);

    //     // Save the card
    //     $card->save();

    //     // Return a response
    //     return response()->json([
    //         'message' => $id ? 'Card updated successfully' : 'Card created successfully',
    //         'card' => $card
    //     ], 200);
    // }


    public function storeOrUpdate(CardRequest $request, $id = null)
{
    try {
        // Log the incoming request data
        Log::info('Store or update card request received', [
            'request_data' => $request->all(),
            'card_id' => $id,
        ]);

        // Retrieve the 'data' as a JSON string from the request
        $data = json_decode($request->input('data'), true);

        // Check if the card exists for updating, or create a new instance
        $card = $id ? Card::findOrFail($id) : new Card();

        // Log card retrieval or creation
        Log::info($id ? 'Updating card' : 'Creating new card', [
            'card_id' => $id,
            'card_data' => $data,
        ]);

        // If there is an uploaded image for the logo, handle the file upload
        if ($request->hasFile('logo')) {
            // Log file upload attempt
            Log::info('File upload received for card logo', [
                'file_name' => $request->file('logo')->getClientOriginalName(),
            ]);

            // Handle the file upload
            $path = $request->file('logo')->store('address_logos', 'public');
            $data['address_logo'] = $path;  // Save the file path in the data

            // Log successful file upload
            Log::info('File uploaded successfully', [
                'file_path' => $path,
            ]);
        }

        // Update or create the card record
        $card->fill($data);

        // Save the card
        $card->save();

        // Log successful card save
        Log::info('Card saved successfully', [
            'card_id' => $card->id,
            'card_data' => $card->toArray(),
        ]);

        // Return a response
        return response()->json([
            'message' => $id ? 'Card updated successfully' : 'Card created successfully',
            'card' => $card
        ], 200);
    } catch (\Exception $e) {
        // Log any errors that occur
        Log::error('Error while storing or updating card', [
            'exception' => $e->getMessage(),
            'request_data' => $request->all(),
        ]);

        // Return error response
        return response()->json([
            'message' => 'An error occurred while processing the request.',
            'error' => $e->getMessage()
        ], 500);
    }
}
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

    // public function getRecentUserPost()
    // {
    //     $date = Carbon::now()->subDays(30);
    //     $posts = Post::whereHas('user', function ($query) use ($date){
    //         $query->where('created_at', '>=', $date);
    //     })->paginate(15);
    //     return response()->json($posts);
    // }
}
