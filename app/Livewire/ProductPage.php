<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Livewire\CartPage;

class ProductPage extends Component
{

    public $products;
    public function mount(){
        $this->products = Product::all();
    }
    public function addToCart($id)
    {
        // البحث عن المنتج باستخدام الـ ID
        $product = Product::find($id);

        // إذا لم يتم العثور على المنتج، نوقف العملية
        if (!$product) {
            return;
        }

        // استعادة السلة من الجلسة أو إنشاء مصفوفة فارغة إذا لم تكن موجودة
        $cart = session()->get('cart', []);

        // التحقق مما إذا كان المنتج موجودًا بالفعل في السلة
        if (isset($cart[$id])) {
            // إذا كان موجودًا، نزيد الكمية
            $cart[$id]['quantity']++;
        } else {
            // إذا لم يكن موجودًا، نضيفه للسلة مع الكمية 1
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        // تخزين السلة المحدثة مرة أخرى في الجلسة
        session()->put('cart', $cart);

        // نرسل حدثًا عامًا لتحديث عرض السلة في أي مكان
        $this->dispatch('cart-updated');
    }
    public function render()
    {
        $products = Product::all();
        return view('livewire.product-page', compact(['products']))
        ->layout('layouts.app');
    }
}
