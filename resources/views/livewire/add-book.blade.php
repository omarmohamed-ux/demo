<div>
   <div>
    @if (session()->has('message'))
        <div style="padding: 1rem; background-color: #d1e7dd; color: #0f5132; border-radius: 0.25rem;">
            {{ session('message') }}
        </div>
    @endif
      <h1 style="color:#ff0000;;">ادخل جميع البيانات قبل الحفظ</h1>
     
    <form wire:submit.prevent="save">
        <label for="Book-name">اسم الكتاب:</label>
        <input name="text" id="Book-name" wire:model.live="name">
       
    </form>

    <form wire:submit.prevent="save">
        <label for="Author_name">اسم المؤلف:</label>
        <input Author_name="text" id="Author_name" wire:model.live="Author_name">
        
    </form>
    <form wire:submit.prevent="save">
        <label for="publication_year">سنه ألاصدار:</label>
        <input publication_year="text" id="publication_year" wire:model.live="publication_year">
       
    </form>
    <button  wire:click="save"> حفظ </button>
  </div>  
</div>
