<div>
    <div>
    <h2>🛒 سلة المشتريات</h2>

        @if(empty($cart))
            <p>السلة فارغة</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>المجموع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] * $item['quantity'] }}</td>
                            <td><button wire:click="decrementQuantity({{ $id }})">-</button></td>
                            <td><button wire:click="incrementQuantity({{ $id }})">+</button></td>
                            <td>
                                <button wire:click="removeFromCart({{ $id }})" >
                                    حذف
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 >الإجمالي: <strong>{{ $this->total }}</strong></h3>
        @endif

        <a href="{{route('products')}}" wire:navigate>
                    ☺️تابع التسوق
        </a>
    </div>
</div>
