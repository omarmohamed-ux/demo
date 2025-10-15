<div>
    <div>
    

        <h2>input First number</h2>
        <input type="number"wire:model='count' />

        <h2>input Secound number</h2>
        <input type="number"wire:model='count2' />

        <button wire:click="multi">*</button>
        <button wire:click="add">+</button>
        <button wire:click="sub">-</button>
        <button wire:click="div">/</button>
        <h2>The Answer is: <h2>{{$answer}}

    </div>

    <hr>

    <div>

        <h2>your history</h2>
        @if ($history->isEmpty())
        <h2>no history</h2>
        @else
            <ul>
                @foreach ($history as $calulation)
                    <li :key={{$calulation->id}}>
                        {{ $calulation->first_number }} {{ $calulation->operation }} {{ $calulation->second_number }} = {{ $calulation->the_answer }}

                        <button wire:click='deleteItem({{$calulation->id}})'>Delete</button>
                        <a href="{{route('test.update', $calulation->id)}}" wire:navigate class="py-1 px-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">
                             Update
                        </a>
                    </li>
                    
                @endforeach
                <button wire:click='deleteAllItems'>Delete All</button>
            </ul>
        @endif
    </div>
</div>
