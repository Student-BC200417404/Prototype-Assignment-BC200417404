<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    /**
     * Handle incoming requests from Dialogflow.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleRequest(Request $request)
    {
        $intent = $request->input('queryResult.intent.displayName');
        
        switch ($intent) {
            case 'OrderAdd':
                return $this->handleOrderAdd($request);
            case 'OrderRemove':
                return $this->handleOrderRemove($request);
            case 'Reservation':
                return $this->handleReservation($request);
            case 'TrackOrder':
                return $this->handleTrackOrder($request);
            case 'OrderStatus':
                return $this->handleOrderStatus($request);
            case 'GetCategory':
                return $this->handleGetCategory($request);
            case 'GetMenu':
                return $this->handleGetMenu($request);
            default:
                return $this->handleUnknownQuery();
        }
    }

    /**
     * Handle the order addition intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleOrderAdd(Request $request)
    {
        // Logic for adding an order
        return response()->json([
            'fulfillmentText' => 'Your order has been added successfully!'
        ]);
    }

    /**
     * Handle the order removal intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleOrderRemove(Request $request)
    {
        // Logic for removing an order
        return response()->json([
            'fulfillmentText' => 'Your order has been removed successfully!'
        ]);
    }

    /**
     * Handle the reservation intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleReservation(Request $request)
    {
        // Logic for making a reservation
        return response()->json([
            'fulfillmentText' => 'Your reservation has been made successfully!'
        ]);
    }

    /**
     * Handle the order tracking intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleTrackOrder(Request $request)
    {
        // Logic for tracking an order
        return response()->json([
            'fulfillmentText' => 'Your order is currently being prepared.'
        ]);
    }

    /**
     * Handle the order status intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleOrderStatus(Request $request)
    {
        // Logic for checking order status
        return response()->json([
            'fulfillmentText' => 'Your order is on the way!'
        ]);
    }

    /**
     * Handle the category retrieval intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGetCategory(Request $request)
    {
        // Logic for retrieving categories
        return response()->json([
            'fulfillmentText' => 'Here are the categories: Pizza, Pasta, Salad.'
        ]);
    }

    /**
     * Handle the menu retrieval intent.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGetMenu(Request $request)
    {
        // Logic for retrieving the menu
        return response()->json([
            'fulfillmentText' => 'Here is our menu: Pizza, Pasta, Salad, Dessert.'
        ]);
    }

    /**
     * Handle unknown queries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleUnknownQuery()
    {
        $responses = [
            "Sorry, I didn't understand that.",
            "Can you please rephrase your question?",
            "I'm not sure how to help with that."
        ];

        return response()->json([
            'fulfillmentText' => $responses[array_rand($responses)]
        ]);
    }
}
