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
        // dd($request);   
        
        switch ($intent) {
            case 'Default Welcome Intent':
                return $this->handleDefaultWelcome();
            case 'Default Fallback Intent':
                return $this->handleDefaultFallback();
            case 'info.order':
                return $this->handleInfoOrder();
            case 'track.order':
                return $this->handleTrackOrder();
            case 'place.order':
                return $this->handlePlaceOrder();
            case 'new.order':
                return $this->handleNewOrder();
            case 'order.add':
                return $this->handleOrderAdd();
            case 'order.remove':
                return $this->handleOrderRemove();
            case 'menu':
                return $this->handleGetMenu();
            case 'menu.category':
                return $this->handleGetCategory($request);
            case 'make.reservation':
                return $this->handleMakeReservation();
            case 'info.reservation':
                return $this->handleReservationDetails();
            case 'checkout.order':
                return $this->handleCheckoutOrder();
            case 'get.customer.details':
                return $this->handleGetCustomerDetails();
            case 'cancel.order':
                return $this->handleCancelOrder();
            case 'modify.order':
                return $this->handleModifyOrder();
            case 'greetings':
                return $this->handleGreetings();
            case 'thanks':
                return $this->handleThanks();
            case 'goodbye':
                return $this->handleGoodbye();
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

   
    private function handleInfoOrder(Request $request)
    {
        return response()->json([
            'fulfillmentText' => 'Let me check your order status. Could you please share your order ID?'
        ]);
    }

    /**
     * Handle the default welcome intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleDefaultWelcome()
    {
        return response()->json(['fulfillmentText' => 'Hello! Welcome to EatzAI! 🍽️ How can I assist you today?']);
    }

    /**
     * Handle the default fallback intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleDefaultFallback()
    {
        return response()->json(['fulfillmentText' => "I'm sorry, I didn't understand that. Can you please rephrase or select an option from the menu?"]);
    }

    /**
     * Handle the place order intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handlePlaceOrder()
    {
        return response()->json(['fulfillmentText' => 'Of course! What would you like to order today?']);
    }

    /**
     * Handle the new order intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleNewOrder()
    {
        return response()->json(['fulfillmentText' => 'Alright, starting a new order. Browse our menu and let me know your selections!']);
    }

   
    /**
     * Handle the make reservation intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleMakeReservation()
    {
        return response()->json(['fulfillmentText' => 'Sure! How many people and what time would you like to reserve for?']);
    }

    /**
     * Handle the reservation details intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleReservationDetails()
    {
        return response()->json(['fulfillmentText' => 'Let me check your reservation. Could you provide your name or phone number?']);
    }

    /**
     * Handle the checkout order intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleCheckoutOrder()
    {
        return response()->json(['fulfillmentText' => 'Alright! Please share your contact details to complete the checkout. 📋']);
    }

    /**
     * Handle the get customer details intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGetCustomerDetails()
    {
        return response()->json(['fulfillmentText' => "Thank you! Your order is being processed. You'll receive confirmation shortly! ✅"]);
    }

    /**
     * Handle the cancel order intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleCancelOrder()
    {
        return response()->json(['fulfillmentText' => "I'm sorry to hear that! Let me cancel your order. Can you confirm the order ID?"]);
    }

    /**
     * Handle the modify order intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleModifyOrder()
    {
        return response()->json(['fulfillmentText' => 'Of course! Tell me what changes you\'d like to make.']);
    }

    /**
     * Handle the greetings intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGreetings()
    {
        return response()->json(['fulfillmentText' => 'Hi there! 👋 Hope you\'re having a great day! How can I help you today?']);
    }

    /**
     * Handle the thanks intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleThanks()
    {
        return response()->json(['fulfillmentText' => 'You\'re very welcome! 😊 Happy to help!']);
    }

    /**
     * Handle the goodbye intent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGoodbye()
    {
        return response()->json(['fulfillmentText' => 'Goodbye! 👋 Hope to serve you again soon at EatzAI!']);
    }
}
