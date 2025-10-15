<div>
  <div>
       <h1 style="color:#ff0000;;">ادخل  نوع الكتاب اولا قبل معلومات الكتاب</h1>

      
       <hr>
       <h2>أنواع الكتب</h2>
       <a href="{{route('books.add')}}" wire:navigate>
         اضف نوع كتاب
       </a>
       <hr>
        <h2>اضف معلومات الكتاب</h2>
       <form wire:submit="save">
            <div>
              <label for="name">اسم الكتاب</label>
              <input type="text" id="name" wire:model="name" >
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
                 <input type="number" id="publication_year" wire:model="publication_year" >
            </div>
            <button type="submit">حفظ</button>
          </form>

           <p>عدد أنواع الكتب المسجلة: <mark>{{ $books->count() }}</mark></p>
           <hr>
            <h2>جدول معلومات الكتب</h2>
            <a href="{{route('info.table')}}" wire:navigate>
            تصفح الجدول 
            </a>
            <hr>
            <h2>جدول معلومات المؤلفين</h2>
            
            <a href="{{route('author.view')}}" wire:navigate>
            تصفح جدول المؤلفين 
            </a>

           <hr>
       
        <h2>قائمة أنواع الكتب</h2>

            @if($bookTypes->isEmpty())
            <p>لم يتم إضافة أي أنواع كتب بعد.</p>
            @else
            <ul>
            @foreach($bookTypes as $bookType)
                <!-- لكل نوع كتاب، نستخدم x-data و x-show للتحكم في عرض الكتب -->
                <li x-data="{ show: false }" style="margin-bottom: 10px;">

                    <!-- اسم النوع وعدد الكتب -->
                    {{ $bookType->type }} - {{ count($bookType->books) }}

                    <!-- زر عرض/إخفاء -->
                    <button @click="show = !show">
                        <span x-show="!show">عرض</span>
                        <span x-show="show">إخفاء</span>
                    </button>

                    <!-- قائمة الكتب (مخفية في البداية، وتظهر عند الضغط على الزر) -->
                    <ul x-show="show" style="margin-top: 5px;">
                        @foreach($bookType->books as $book)
                            <li>
                                {{ $book->name }} - ({{ $book->publication_year }}) - @if(@$book->author_id) {{ $book->Author->name }} @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- زر الحذف -->
                    <button wire:click="deleteBookType({{ $bookType->id }})">حذف</button>
                    
                </li>
            @endforeach
            </ul>
            @endif

        
        <hr>

        <h2>قائمة الكتب</h2>
        @if($books->isEmpty())
            <p>لم يتم إضافة أي كتب بعد.</p>
        @else
            <ul>
                @foreach($books as $book)
                    <li>
                        {{ $book->name }} -  ({{ $book->publication_year }}) - @if(@$book->book_type_id) {{ $book->bookType->type }} - @endif @if(@$book->author_id) {{ $book->Author->name }} @endif
                    </li>
                    <a href="{{ route('edit.all', ['bookId' => $book->id]) }}">
                        تعديل
                    </a>


                @endforeach
            </ul>
        @endif
    </div>
</div>






