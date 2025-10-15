<div>
    <div>
            <h1>جدول المؤلفين</h1>
            {{-- نموذج إضافة مؤلف جديد --}}
            <form wire:submit="submit">
                <div>
                    <label for="name">اسم المؤلف</label>
                    <input type="text" id="name" wire:model="name">
                </div>
                
                <div>
                    <label for="Date_of_birth">تاريخ الميلاد</label>
                    <input type="number" id="Date_of_birth" wire:model="Date_of_birth">
                </div>
                
                <button type="submit">حفظ</button>
            </form>
    
    <hr>
            @if($authors->isEmpty())
                <p>لا يوجد مؤلفون مسجلون لعرضهم.</p>
            @else
                <table style="width:100%; border-collapse: collapse; text-align: right;">
                    <thead>
                        <tr style="background-color:#f2f2f2;">
                            <th style="padding: 8px; border: 1px solid #ddd;">اسم المؤلف</th>
                            <th style="padding: 8px; border: 1px solid #ddd;">تاريخ الميلاد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($authors as $author)
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $author->name }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $author->Date_of_birth }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
    </div>
</div>
