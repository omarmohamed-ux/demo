<div>
<div>
    <!-- عنوان الصفحة -->
    <h1>قائمة الكتب</h1>

    <!-- شرط Blade: إذا كانت قائمة الكتب فارغة، اعرض رسالة. -->
    @if ($books->isEmpty())
        <p>لم يتم إضافة أي كتب بعد.</p>
    @else
        <!-- وإلا، قم بإنشاء جدول لعرض البيانات -->
        <table>
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>نوع الكتاب</th>
                    <th>سنة الإصدار</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <!-- حلقة Blade: قم بالمرور على كل كتاب في القائمة -->
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td> <!-- اعرض عنوان الكتاب -->
                        <td>{{ $book->bookType->type }}</td> <!-- اعرض نوع الكتاب من العلاقة -->
                        <td>{{ $book->publication_year }}</td> <!-- اعرض سنة الإصدار -->
                        <td>
                            <!-- رابط التعديل يمرر الـ ID الخاص بالكتاب -->
                            <a href="/edit-book/{{ $book->id }}">تعديل</a>
                            <!-- زر الحذف يستدعي دالة deleteBook ويمرر الـ ID -->
                            <button wire:click="deleteBook({{ $book->id }})">حذف</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</div>
