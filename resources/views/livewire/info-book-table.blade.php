<div>
    <div>
        <h1>جدول الكتب المسجلة</h1>
    
    
        <table style="width:100%; border-collapse: collapse; text-align: right;">
            <thead>
                <tr style="background-color:#a9a4a4ff;">
                    <th style="padding: 8px; border: 1px solid #060606f6;">اسم الكتاب</th>
                    <th style="padding: 8px; border: 1px solid #0a0a0aff;">اسم المؤلف</th>
                    <th style="padding: 8px; border: 1px solid #030303ff;">سنة النشر</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->name }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->Author->name }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->publication_year }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
    </div>
    
</div>
