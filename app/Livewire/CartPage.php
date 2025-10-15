<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Livewire\ProductPage;

class CartPage extends Component
{
    public $cart=[];
    protected $listeners = ['cart-updated' => 'refreshCart'];

    
    public function mount()
    {
        // استعادة بيانات السلة من الجلسة
        $this->cart = session()->get('cart', []);
    }    
    public function incrementQuantity($productId)
    {
        // التحقق من وجود المنتج في السلة
        if (isset($this->cart[$productId])) {
            // زيادة الكمية بـ 1
            $this->cart[$productId]['quantity']++;
            // تحديث السلة في الجلسة
            session()->put('cart', $this->cart);
        }
    }

    // دالة لإنقاص كمية المنتج
    public function decrementQuantity($productId)
    {
        // التحقق من وجود المنتج في السلة وأن الكمية أكبر من او يساوي 1
        if (isset($this->cart[$productId]) && $this->cart[$productId]['quantity'] >= 1) {
            // إنقاص الكمية بـ 1
            $this->cart[$productId]['quantity']--;
            // تحديث السلة في الجلسة
            session()->put('cart', $this->cart);
        } elseif (isset($this->cart[$productId]) && $this->cart[$productId]['quantity'] <= 0) {
            // إذا كانت الكمية0 او اقل، احذف المنتج بالكامل
            $this->removeFromCart($productId);
        }
    }    
    public function removeFromCart($productId) 
    { 
       if (isset($this->cart[$productId])) { //لو العنصر في السله
          unset($this->cart[$productId]); //احذف العنصر من السله
          session()->put('cart', $this->cart);// إعادة تخزين السلة المحدثة في الجلسة
        } 
    }
    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    public function render()
    {
        return view('livewire.cart-page')->layout('layouts.app');
    }
}
