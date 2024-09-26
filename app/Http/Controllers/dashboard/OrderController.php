<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // إضافة auth middleware لضمان أن المستخدم مسجل دخولًا


    /**
     * عرض قائمة الطلبات.
     */
    public function index()
    {
        // استرجاع جميع الطلبات
        $orders = Order::with('items')->get();
        return view('layouts.pages.checkout', compact('orders'));
    }

    /**
     * عرض تفاصيل الطلب.
     */
    public function show($id)
    {
        // استرجاع الطلب مع العناصر المرتبطة به
        $order = Order::with('items')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * تخزين طلب جديد.
     */
    public function store(OrderRequest $request)
    {
        // تحقق من صحة البيانات
        $validated = $request->validated();

        // استخدام المعاملة لضمان سلامة البيانات
        DB::transaction(function () use ($request) {
            // إنشاء طلب جديد
            $order = new Order();
            $order->name = $request->input('name');
            $order->email = $request->input('email');
            $order->address = $request->input('address');
            $order->phone = $request->input('phone');
            $order->total = (float) $request->input('total'); // تحويل إلى decimal
            $order->bill = $request->input('bill');
            $order->shipping_address = $request->input('shipping_address');
            $order->shipping_cost = (float) $request->input('shipping_cost'); // تحويل إلى decimal
            $order->card_details = json_encode([
                'number' => $request->input('card_number'),
                'expiry' => $request->input('card_expiry'),
                'cvc' => $request->input('card_cvc'),
            ]);

            // تعيين user_id من المستخدم المسجل دخوله
            $order->user_id = auth()->id();

            // حفظ الطلب
            $order->save();

            // إضافة العناصر المرتبطة بالطلب
            $items = $request->input('items', []); // افتراض أن items مصفوفة فارغة إذا لم تكن موجودة
            if (is_array($items)) {
                foreach ($items as $item) {
                    $order->items()->create([
                        'user_id' => auth()->id(), // تعيين user_id تلقائيًا من المستخدم المسجل دخوله
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'price' => (float) $item['price'],
                        'total' => (float) $item['quantity'] * (float) $item['price'],
                    ]);
                }
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

}
