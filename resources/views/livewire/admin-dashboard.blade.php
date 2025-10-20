<div>
    <div>
        <h2>سجلات حضور جميع الموظفين</h2>
        <table style="width:100%; border-collapse: collapse; text-align: right;">
            <tr>
                <th style="padding: 8px; border: 1px solid #ddd;">الموظف</th>
                <th style="padding: 8px; border: 1px solid #ddd;"> التاريخ</th>
                <th style="padding: 8px; border: 1px solid #ddd;">وقت الدخول</th>
                <th style="padding: 8px; border: 1px solid #ddd;">وقت الخروج</th>
                <th style="padding: 8px; border: 1px solid #ddd;"> مده الحضور</th>
                <th style="padding: 8px; border: 1px solid #ddd;">  اداء المطلوب</th>
            </tr>
            @foreach($records as $record)
            <tr>
            @php
                        // افترض أن $record هو سجل الحضور اليومي
                        $dailyStatus = $this->getDailyStatusAndColor($record);
                    @endphp
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $record->user->name }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($record->created_at)->isoFormat('dddd، D MMMM YYYY') }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $record->check_in ? $record->check_in->format('h:i A') : '-' }} </td>  {{--('H:i') 14:59--}}
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $record->check_out ? $record->check_out->format('h:i A') : '-' }} </td>
                <td style="padding: 8px; border: 1px solid #ddd;">
                    {{-- لا نحاول إجراء عمليات حسابية إذا لم يتم تسجيل الخروج بعد. --}}
                    @if ($record->duration !== null)
                        @php
                            $minutes = $record->duration; // إجمالي الدقائق المخزنة
                            $hours = floor($minutes / 60); // حساب الساعات
                            $remainingMinutes = $minutes % 60; // الدقائق المتبقية
                        @endphp
                        
                        {{-- عرض التنسيق: 8h : 20m --}}
                        {{ $hours }}h : {{ str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) }}m
                    @else
                        -
                    @endif
                </td>
                {{-- عرض حالة اليوم (🟢 تم تحقيق الهدف / 🟡 أقل من المطلوب / 🔴 انتظار الخروج) --}}
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $dailyStatus['status'] }}</td>
            </tr>
            @endforeach

        </table>
        <form method="POST" action="{{ route('logout')}}">
            @csrf 
            <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                logout
            </button>
        </form>
    </div>
</div>
