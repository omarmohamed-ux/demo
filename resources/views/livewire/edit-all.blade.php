<div>
    <div>
        <h1>تعديل معلومات الكتاب</h1>

        <form wire:submit="updateBook">
            <div>
                <label for="name">اسم الكتاب</label>
                <input type="text" id="name" wire:model="name">
            </div>

            <div>
                <label for="author_id">المؤلف</label>
                <select id="author_id" wire:model="author_id">
                    <option value="">-- اختر المؤلف --</option>
                    @foreach($authors as $Author)
                        <option value="{{ $Author->id }}">{{ $Author->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="book_type_id">نوع الكتاب</label>
                <select id="book_type_id" wire:model="book_type_id">
                    <option value="">-- اختر نوع الكتاب --</option>
                    @foreach($bookTypes as $bookType)
                        <option value="{{ $bookType->id }}">{{ $bookType->type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="publication_year">سنة النشر</label>
                <input type="number" id="publication_year" wire:model="publication_year">
            </div>
            
            <button type="submit">حفظ التغييرات</button>
        </form>
    </div>
</div>
