<div>
    <div>
     
    @if (session()->has('message'))
        <div style="padding: 1rem; background-color: #d1e7dd; color: #0f5132; border-radius: 0.25rem;">
            {{ session('message') }}
        </div>
    @endif
    
    <form wire:submit.prevent="save">
      
        <h1 style="background-color:Tomato;">ادخل نوع الكتاب</h1>
        <label for="type-name">نوع الكتاب:</label>
        <input type="text" id="type-name" wire:model.live="type">
        <button type="submit">حفظ</button>
        <input type="button" onclick="alert('استغفر الله')" value="حسنه">
        
    </form>
    

</div>
</div>
