<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Menu;

class SampleOrderSeeder extends Seeder
{
    public function run()
    {
        // Get some customers and menus for creating realistic orders
        $customers = Customer::all();
        $menus = Menu::all();

        if ($customers->isEmpty() || $menus->isEmpty()) {
            return; // Skip if no customers or menus exist
        }

        // Create sample orders
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers->random();
            $orderType = ['dine-in', 'takeaway', 'delivery'][array_rand(['dine-in', 'takeaway', 'delivery'])];
            $orderStatus = ['pending', 'preparing', 'ready', 'delivered', 'completed'][array_rand(['pending', 'preparing', 'ready', 'delivered', 'completed'])];

            // Calculate order totals
            $subtotal = 0;
            $orderDetails = [];

            // Create 1-4 order details per order
            $numItems = rand(1, 4);
            for ($j = 0; $j < $numItems; $j++) {
                $menu = $menus->random();
                $quantity = rand(1, 3);
                $unitPrice = $menu->price;
                $itemSubtotal = $quantity * $unitPrice;
                $subtotal += $itemSubtotal;

                $orderDetails[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal,
                    'special_instructions' => rand(0, 1) ? 'Extra sauce please' : null,
                ];
            }

            $tax = $subtotal * 0.08; // 8% tax
            $discount = rand(0, 1) ? rand(5, 20) : 0; // Random discount
            $deliveryFee = $orderType === 'delivery' ? rand(5, 15) : 0;
            $total = $subtotal + $tax - $discount + $deliveryFee;

            // Create the order
            $order = Order::create([
                'customer_id' => $customer->id,
                'reservation_id' => null, // Could be linked to reservations later
                'order_number' => 'ORD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'type' => $orderType,
                'status' => $orderStatus,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'delivery_address' => $orderType === 'delivery' ? $customer->address : null,
                'notes' => rand(0, 1) ? 'Please make it spicy' : null,
                'prepared_at' => in_array($orderStatus, ['ready', 'delivered', 'completed']) ? now()->subMinutes(rand(10, 60)) : null,
                'delivered_at' => in_array($orderStatus, ['delivered', 'completed']) ? now()->subMinutes(rand(5, 30)) : null,
            ]);

            // Create order details
            foreach ($orderDetails as $detail) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $detail['menu_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'subtotal' => $detail['subtotal'],
                    'special_instructions' => $detail['special_instructions'],
                ]);
            }
        }
    }
} 