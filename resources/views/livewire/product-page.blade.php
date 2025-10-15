<div>
    <div>
        <h2>📦 قائمة المنتجات</h2>
            
            @if($products->isEmpty())
                <p>لم يتم إضافة أي أغراض </p>
            @else
                <ul>
                    @foreach ($products as $product)

                        <h3>{{ $product->name }}</h3>
                        <p>💰السعر:{{ $product->price }}</p>
                        <button wire:click="addToCart({{ $product->id }})" onclick="alert('تم ')">اضف للسلة</button>
                    @endforeach
                </ul>
            @endif 
            <a href="{{route('cart')}}" wire:navigate>
                    🛒انتقل الي السله
            </a>
    </div>
</div>