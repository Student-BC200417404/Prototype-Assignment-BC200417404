<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;

class ChatBotController extends Controller
{
    /**
     * Handle incoming requests from Dialogflow.
     * Uses session ID for per-chat state.
     */
    public function handleRequest(Request $request)
    {
        $intent = $request->input('queryResult.intent.displayName');
        $sessionId = $request->input('session');
        
        try {
            switch ($intent) {
                case 'Default Welcome Intent':
                    return $this->handleDefaultWelcome();
                case 'Default Fallback Intent':
                    return $this->handleDefaultFallback($sessionId);
                case 'cancel.order':
                    return $this->handleCancelOrder($request, $sessionId);
                case 'checkout.order':
                    return $this->handleCheckoutOrder($request, $sessionId);
                case 'customer.details':
                    return $this->handleGetCustomerDetails($request, $sessionId);
                case 'faq.inquiry':
                    return $this->handleFaqInquiry($request, $sessionId);
                case 'menu.category':
                    return $this->handleMenuByCategory($request, $sessionId);
                case 'menu.show':
                    return $this->handleGetCategory($request, $sessionId);
                case 'new.order':
                    return $this->handleNewOrder($request, $sessionId);
                case 'order.add':
                    return $this->handleOrderAdd($request, $sessionId);
                case 'order.remove':
                    return $this->handleOrderRemove($request, $sessionId);
                case 'reservation.create':
                    return $this->handleMakeReservation($request, $sessionId);
                case 'reservation.details':
                    return $this->handleReservationDetails($request, $sessionId);
                case 'reservation.status':
                    return $this->handleReservationStatus($request, $sessionId);
                case 'track.order':
                    return $this->handleTrackOrder($request, $sessionId);
                // case 'menu.by.category':
                //     return $this->handleMenuByCategory($request, $sessionId);
                default:
                    return $this->handleUnknownQuery($sessionId);
            }
        } catch (\Throwable $e) {
            // Use the base controller's error logging function
            $this->logError($e, $request);
            
            return response()->json([
                'fulfillmentText' => "Sorry, something went wrong. Please try again later."
            ]);
        }
    }

    // --- INTENT HANDLERS ---

    private function handleDefaultWelcome()
    {
        return response()->json(['fulfillmentText' => 'Hello! Welcome to EatzAI! 🍽️ How can I assist you today?']);
    }

    private function handleDefaultFallback($sessionId)
    {
        $this->logSessionMessage($sessionId, 'fallback');
        return response()->json([
            'fulfillmentText' => "I'm sorry, I didn't understand that. Can you please rephrase or select an option from the menu?"
        ]);
    }

    private function handleCancelOrder(Request $request, $sessionId)
    {
        // Example: clear order from session
        Cache::forget('chatbot_' . $sessionId . '_order');
        return response()->json([
            'fulfillmentText' => "Your order has been cancelled. If you need anything else, let me know!"
        ]);
    }

    private function handleCheckoutOrder(Request $request, $sessionId)
    {
        $order = Cache::get('chatbot_' . $sessionId . '_order', []);
        if (empty($order)) {
            $msg = "🛒 Your order is empty. Please add some items before checking out.";
        } else {
            $orderList = "- " . implode("\n- ", $order);
            $msg = "🧾 Here is your order summary:\n\n$orderList\n\nThank you! Your order has been placed. You'll receive confirmation soon. Would you like anything else?";
            Cache::forget('chatbot_' . $sessionId . '_order');
        }
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleGetCustomerDetails(Request $request, $sessionId)
    {
        // Example: retrieve customer details from session or DB
        $details = Cache::get('chatbot_' . $sessionId . '_customer', []);
        if ($details) {
            $msg = "Your details: Name: {$details['name']}, Phone: {$details['phone']}";
        } else {
            $msg = "I don't have your details yet. Please provide your name and phone number.";
        }
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleFaqInquiry(Request $request, $sessionId)
    {
        // Example: static FAQ response
        return response()->json([
            'fulfillmentText' => "Our restaurant is open from 10am to 10pm. We accept cash, card, and online payments."
        ]);
    }

    private function handleGetCategory(Request $request, $sessionId)
    {
        try {
            $categories = Category::where('is_active', true)->pluck('name')->toArray();
            
            if ($categories) {
                $options = [];
                foreach ($categories as $category) {
                    $options[] = ['text' => $category];
                }
                
                return response()->json([
                    'fulfillmentText' => 'What would you like to explore?',
                    'fulfillmentMessages' => [
                        [
                            'payload' => [
                                'richContent' => [
                                    [
                                        [
                                            'type' => 'info',
                                            'subtitle' => 'Please choose a category below.',
                                            'title' => 'What would you like to explore?'
                                        ],
                                        [
                                            'type' => 'chips',
                                            'options' => $options
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
            } else {
                return response()->json([
                    'fulfillmentText' => 'Sorry, no categories are available at the moment. Please check back later!'
                ]);
            }
        } catch (\Throwable $e) {
            $this->logError($e, $request);
            return response()->json([
                'fulfillmentText' => "Sorry, there was an error loading categories. Please try again."
            ]);
        }
    }

    private function handleMenuByCategory(Request $request, $sessionId)
    {
        try {
            $params = $request->input('queryResult.parameters', []);
            $categoryName = $params['menu-category'] ?? null;
            
            if (!$categoryName) {
                return response()->json([
                    'fulfillmentText' => 'Please specify which category you would like to see.'
                ]);
            }
            
            // Get category ID
            $category = Category::where('name', $categoryName)->where('is_active', true)->first();
            
            if (!$category) {
                return response()->json([
                    'fulfillmentText' => "Sorry, the category '$categoryName' is not available."
                ]);
            }
            
            // Get menu items for this category
            $items = Menu::where('category_id', $category->id)
                        ->where('is_available', true)
                        ->get(['name', 'price', 'description']);
            
            if ($items->count() > 0) {
                $menuList = '';
                foreach ($items as $item) {
                    $menuList .= "• **{$item->name}** - $" . number_format($item->price, 2);
                    if ($item->description) {
                        $menuList .= "\n  {$item->description}";
                    }
                    $menuList .= "\n\n";
                }
                
                $msg = "🍽️ Here are the items in **$categoryName**:\n\n" . $menuList . "Would you like to add any of these items to your order?";
                
                return response()->json([
                    'fulfillmentText' => $msg
                ]);
            } else {
                return response()->json([
                    'fulfillmentText' => "Sorry, no items are available in the $categoryName category at the moment."
                ]);
            }
        } catch (\Throwable $e) {
            $this->logError($e, $request);
            return response()->json([
                'fulfillmentText' => "Sorry, there was an error loading the menu. Please try again."
            ]);
        }
    }

    private function handleMenuShow(Request $request, $sessionId)
    {
        $categories = Category::where('is_active', true)->pluck('name')->toArray();
        
        if ($categories) {
            $options = [];
            foreach ($categories as $category) {
                $options[] = ['text' => $category];
            }
            
            return response()->json([
                'fulfillmentText' => 'What would you like to explore?',
                'fulfillmentMessages' => [
                    [
                        'payload' => [
                            'richContent' => [
                                [
                                    [
                                        'type' => 'info',
                                        'subtitle' => 'Please choose a category below.',
                                        'title' => 'What would you like to explore?'
                                    ],
                                    [
                                        'type' => 'chips',
                                        'options' => $options
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        } else {
            return response()->json([
                'fulfillmentText' => 'Sorry, our menu is currently unavailable. Please check back later or ask for assistance!'
            ]);
        }
    }

    private function handleNewOrder(Request $request, $sessionId)
    {
        // Start a new order session
        Cache::put('chatbot_' . $sessionId . '_order', [], 60);
        return response()->json([
            'fulfillmentText' => 'Starting a new order. What would you like to add?'
        ]);
    }

    private function handleOrderAdd(Request $request, $sessionId)
    {
        $params = $request->input('queryResult.parameters', []);
        $items = $params['item'] ?? null;
        $numbers = $params['number'] ?? [];
        $order = Cache::get('chatbot_' . $sessionId . '_order', []);

        if ($items) {
            // Normalize to arrays
            if (!is_array($items)) {
                $items = [$items];
            }
            if (!is_array($numbers)) {
                $numbers = [$numbers];
            }

            $addedItems = [];
            foreach ($items as $idx => $item) {
                $qty = isset($numbers[$idx]) ? (int)$numbers[$idx] : 1;
                // Add or update quantity in order
                if (isset($order[$item])) {
                    $order[$item] += $qty;
                } else {
                    $order[$item] = $qty;
                }
                $addedItems[] = "$qty x $item";
            }

            Cache::put('chatbot_' . $sessionId . '_order', $order, 60);

            $msg = "✅ I've added: " . implode(', ', $addedItems) . " to your order.\n\nWould you like to add more items or proceed to checkout?";
        } else {
            $msg = "Please specify what you want to add to your order.";
        }
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleOrderRemove(Request $request, $sessionId)
    {
        $params = $request->input('queryResult.parameters', []);
        $item = $params['item'] ?? null;
        $order = Cache::get('chatbot_' . $sessionId . '_order', []);
        if ($item && in_array($item, $order)) {
            $order = array_diff($order, [$item]);
            Cache::put('chatbot_' . $sessionId . '_order', $order, 60);
            $msg = "❌ *$item* has been removed from your order.\n\nWould you like to remove anything else or proceed to checkout?";
        } else {
            $msg = "That item is not in your order. Please specify another item to remove.";
        }
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleMakeReservation(Request $request, $sessionId)
    {
        $params = $request->input('queryResult.parameters', []);
        Cache::put('chatbot_' . $sessionId . '_reservation', $params, 60);
        // Reservation prompts
        $reservationPrompts = [
            "Sure, I'd be happy to help with your reservation. May I have a few details like your name, number of people, and whether it's for lunch or dinner?",
            "Absolutely! Let's get your table booked. Could you please tell me your name, how many people are joining, and if it's for lunch or dinner?",
            "Of course! To reserve a table, I just need a few details—your name, number of guests, and the time you'd like to dine.",
            "I'd love to help with that! Can you share your name, the number of people, and whether it's for lunch or dinner?",
            "No problem! I can assist you with the reservation. May I know your name, how many seats you need, and if it's for lunch or dinner?"
        ];
        $msg = $reservationPrompts[array_rand($reservationPrompts)];
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleReservationDetails(Request $request, $sessionId)
    {
        $params = $request->input('queryResult.parameters', []);
        // Extract parameters
        $personObj = $params['person'] ?? null;
        $person = is_array($personObj) && isset($personObj['name']) ? $personObj['name'] : (is_string($personObj) ? $personObj : null);
        $mealType = $params['meal-type'] ?? null;
        $time = $params['time'] ?? null;
        $email = $params['email'] ?? null;
        $phone = $params['phone_number'] ?? null;
        $date = $params['date'] ?? null;

        // Validate required fields
        if (!$person || !$time || !$email || !$phone || !$date) {
            return response()->json(['fulfillmentText' => 'Some required reservation details are missing. Please provide all required information (name, email, phone, date, and time).']);
        }

        // Find or create customer by email
        $customer = Customer::where('email', $email)->first();
        if (!$customer) {
            // Try to find a user with this email
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $person,
                    'email' => $email,
                    'password' => bcrypt(uniqid()), // random password
                    'role' => 'customer',
                ]);
            }
            $customer = Customer::create([
                'user_id' => $user->id,
                'first_name' => $person,
                'last_name' => '',
                'email' => $email,
                'phone' => $phone,
            ]);
        }

        // Create reservation
        $reservation = Reservation::create([
            'customer_id' => $customer->id,
            'reservation_date' => $date,
            'reservation_time' => $time,
            'number_of_guests' => 1, // Default to 1, can be improved if guests param is available
            'status' => 'pending',
            'special_requests' => null,
        ]);

        // Store in cache for session reference
        Cache::put('chatbot_' . $sessionId . '_reservation', [
            'person' => $person,
            'meal-type' => $mealType,
            'time' => $time,
            'email' => $email,
            'phone_number' => $phone,
            'date' => $date,
        ], 60);

        $msg = "📝 Your reservation has been created!\n\n" .
            "Name: $person\n" .
            "Email: $email\n" .
            "Phone: $phone\n" .
            "Date: $date\n" .
            "Time: $time\n" .
            "Meal: $mealType\n\n" .
            "We will confirm your reservation shortly. Is there anything else I can help you with?";
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleReservationStatus(Request $request, $sessionId)
    {
        $params = $request->input('queryResult.parameters', []);
        $email = $params['email'] ?? null;

        if (!$email) {
            return response()->json(['fulfillmentText' => "Please provide your email address to check your reservation status."]);
        }

        // Find customer by email
        $customer = Customer::where('email', $email)->first();
        
        if (!$customer) {
            return response()->json(['fulfillmentText' => "No reservations found for email: $email. Please check your email address or make a new reservation."]);
        }

        // Get the most recent reservation for this customer
        $reservation = $customer->reservations()
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$reservation) {
            return response()->json(['fulfillmentText' => "No reservations found for email: $email. Please check your email address or make a new reservation."]);
        }

        // Format the reservation details
        $statusMap = [
            'pending' => '🕒 Pending confirmation',
            'confirmed' => '✅ Confirmed',
            'cancelled' => '❌ Cancelled',
            'completed' => '🎉 Completed',
            'no_show' => '⏰ No show'
        ];

        $status = $statusMap[$reservation->status] ?? ucfirst($reservation->status);
        $date = $reservation->reservation_date->format('F j, Y');
        $time = $reservation->reservation_time->format('g:i A');
        $guests = $reservation->number_of_guests;

        $msg = "📅 **Reservation Status**\n\n" .
            "**Name:** {$customer->first_name} {$customer->last_name}\n" .
            "**Email:** $email\n" .
            "**Date:** $date\n" .
            "**Time:** $time\n" .
            "**Guests:** $guests\n" .
            "**Status:** $status\n\n";

        if ($reservation->status === 'pending') {
            $msg .= "Your reservation is pending confirmation. We'll contact you soon to confirm your booking.";
        } elseif ($reservation->status === 'confirmed') {
            $msg .= "Your reservation is confirmed! We look forward to serving you.";
        } elseif ($reservation->status === 'cancelled') {
            $msg .= "This reservation has been cancelled.";
        } elseif ($reservation->status === 'completed') {
            $msg .= "This reservation has been completed. Thank you for dining with us!";
        }

        $msg .= "\n\nIs there anything else I can help you with?";

        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleTrackOrder(Request $request, $sessionId)
    {
        // Get tracking id (order_number) from parameters if provided
        $params = $request->input('queryResult.parameters', []);
        $trackingId = $params['tracking_id'] ?? null;

        if (!$trackingId) {
            return response()->json(['fulfillmentText' => "Please provide your tracking ID (order number) to track your order."]);
        }

        $order = Order::where('order_number', $trackingId)->first();
        if (!$order) {
            return response()->json(['fulfillmentText' => "No order found with tracking ID $trackingId. Please check your tracking ID or try again."]);
        }

        $statusMap = [
            'pending' => '🕒 Your order is pending and will be processed soon.',
            'preparing' => '👨‍🍳 Your order is being prepared.',
            'ready' => '✅ Your order is ready for pickup or delivery.',
            'delivered' => '🚚 Your order has been delivered.',
            'completed' => '🎉 Your order is completed. Enjoy your meal!',
            'cancelled' => '❌ Your order was cancelled.'
        ];
        $statusMsg = $statusMap[$order->status] ?? 'Your order status: ' . ucfirst($order->status);

        $msg = "Order Tracking\nOrder Number: {$order->order_number}\nStatus: {$order->status}\n\n$statusMsg\n\nIs there anything else I can help you with?";
        return response()->json(['fulfillmentText' => $msg]);
    }

    private function handleUnknownQuery($sessionId)
    {
        $this->logSessionMessage($sessionId, 'unknown');
        $responses = [
            "Sorry, I didn't understand that.",
            "Can you please rephrase your question?",
            "I'm not sure how to help with that."
        ];
        return response()->json([
            'fulfillmentText' => $responses[array_rand($responses)]
        ]);
    }

    // --- SESSION LOGGING (optional for debugging) ---
    private function logSessionMessage($sessionId, $type)
    {
        // You can log session activity here for analytics/debugging
        // Example: \Log::info("Chatbot session $sessionId: $type");
    }
}
