<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.pages.order.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with(['customer', 'reservation', 'orderDetails'])->select('orders.*');

            return DataTables::of($orders)
                ->addColumn('customer_name', function ($order) {
                    return $order->customer ? $order->customer->first_name . ' ' . $order->customer->last_name : 'N/A';
                })
                ->addColumn('items_count', function ($order) {
                    return $order->orderDetails->sum('quantity');
                })
                ->addColumn('total_amount', function ($order) {
                    return $order->total;
                })
                ->addColumn('payment_status', function ($order) {
                    // You can add payment status logic here based on your payment system
                    $paymentStatuses = [
                        'pending' => 'bg-warning',
                        'paid' => 'bg-success',
                        'failed' => 'bg-danger',
                        'refunded' => 'bg-info'
                    ];
                    $status = $order->payment_status ?? 'pending';
                    $badge = $paymentStatuses[$status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($status) . '</span>';
                })
                ->addColumn('order_type', function ($order) {
                    $badges = [
                        'dine-in' => 'bg-primary',
                        'takeaway' => 'bg-info',
                        'delivery' => 'bg-warning'
                    ];
                    $badge = $badges[$order->type] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($order->type) . '</span>';
                })
                ->addColumn('status', function ($order) {
                    $badges = [
                        'pending' => 'bg-warning',
                        'preparing' => 'bg-info',
                        'ready' => 'bg-primary',
                        'delivered' => 'bg-success',
                        'completed' => 'bg-success',
                        'cancelled' => 'bg-danger'
                    ];
                    $badge = $badges[$order->status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($order->status) . '</span>';
                })
                ->addColumn('total_formatted', function ($order) {
                    return '$' . number_format($order->total, 2);
                })
                ->addColumn('created_date', function ($order) {
                    return $order->created_at->format('M d, Y H:i');
                })
                ->addColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y H:i');
                })
                ->addColumn('action', function ($order) {
                    return '<div class="btn-group" role="group">
                                <a href="' . route('admin.orders.show', $order->id) . '" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i> View
                                </a>
                                <a href="' . route('admin.orders.edit', $order->id) . '" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $order->id . '">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </div>';
                })
                ->rawColumns(['order_type', 'status', 'payment_status', 'action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function create()
    {
        $customers = Customer::all();
        $menus = Menu::where('is_available', true)->get();
        return view('admin.pages.order.create', compact('customers', 'menus'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'reservation_id' => 'nullable|exists:reservations,id',
                'type' => 'required|in:dine-in,takeaway,delivery',
                'status' => 'required|in:pending,preparing,ready,delivered,completed,cancelled',
                'payment_status' => 'required|in:pending,paid,failed,refunded',
                'delivery_address' => 'required_if:type,delivery|nullable|string',
                'notes' => 'nullable|string',
                'menu_items' => 'required|array|min:1',
                'menu_items.*.menu_id' => 'required|exists:menus,id',
                'menu_items.*.quantity' => 'required|integer|min:1',
                'menu_items.*.unit_price' => 'required|numeric|min:0',
                'menu_items.*.special_instructions' => 'nullable|string',
            ]);

            // Calculate totals
            $subtotal = 0;
            foreach ($request->menu_items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $tax = $subtotal * 0.08; // 8% tax
            $discount = 0; // Can be added later
            $deliveryFee = $request->type === 'delivery' ? 5.00 : 0;
            $total = $subtotal + $tax - $discount + $deliveryFee;

            // Create order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'reservation_id' => $request->reservation_id,
                'order_number' => 'ORD-' . time(),
                'type' => $request->type,
                'status' => $request->status,
                'payment_status' => $request->payment_status,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
            ]);

            // Create order details
            foreach ($request->menu_items as $item) {
                $order->orderDetails()->create([
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                    'special_instructions' => $item['special_instructions'] ?? null,
                ]);
            }

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create order. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with(['customer', 'reservation', 'orderDetails.menu'])->findOrFail($id);
            return view('admin.pages.order.show', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found.');
        }
    }

    public function edit($id)
    {
        try {
            $order = Order::with(['customer', 'orderDetails.menu'])->findOrFail($id);
            $customers = Customer::all();
            $menus = Menu::where('is_available', true)->get();
            return view('admin.pages.order.edit', compact('order', 'customers', 'menus'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'reservation_id' => 'nullable|exists:reservations,id',
                'type' => 'required|in:dine-in,takeaway,delivery',
                'status' => 'required|in:pending,preparing,ready,delivered,completed,cancelled',
                'delivery_address' => 'required_if:type,delivery|nullable|string',
                'notes' => 'nullable|string',
                'menu_items' => 'required|array|min:1',
                'menu_items.*.menu_id' => 'required|exists:menus,id',
                'menu_items.*.quantity' => 'required|integer|min:1',
                'menu_items.*.unit_price' => 'required|numeric|min:0',
                'menu_items.*.special_instructions' => 'nullable|string',
            ]);

            // Calculate totals
            $subtotal = 0;
            foreach ($request->menu_items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $tax = $subtotal * 0.08;
            $discount = $order->discount;
            $deliveryFee = $request->type === 'delivery' ? 5.00 : 0;
            $total = $subtotal + $tax - $discount + $deliveryFee;

            // Update order
            $order->update([
                'customer_id' => $request->customer_id,
                'reservation_id' => $request->reservation_id,
                'type' => $request->type,
                'status' => $request->status,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'delivery_fee' => $deliveryFee,
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
            ]);

            // Update order details
            $order->orderDetails()->delete(); // Delete existing details
            foreach ($request->menu_items as $item) {
                $order->orderDetails()->create([
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                    'special_instructions' => $item['special_instructions'] ?? null,
                ]);
            }

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update order. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Delete order details first
            $order->orderDetails()->delete();
            
            // Delete the order
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order. Please try again.'
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,preparing,ready,delivered,completed,cancelled',
            ]);

            $order = Order::findOrFail($id);
            $order->update([
                'status' => $request->status,
                'prepared_at' => in_array($request->status, ['ready', 'delivered', 'completed']) ? now() : null,
                'delivered_at' => in_array($request->status, ['delivered', 'completed']) ? now() : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status. Please try again.'
            ], 500);
        }
    }

    public function pending()
    {
        return view('admin.pages.order.pending');
    }

    public function completed()
    {
        return view('admin.pages.order.completed');
    }
} 