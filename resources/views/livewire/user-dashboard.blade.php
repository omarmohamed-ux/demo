<div>
    <div>
        <div class="text-center">
                <h2 class="text-2xl md:text-4xl p-7 font-bold"><strong class="text-green-600">الحضور / الخروج الخاص بي</strong></h2>
                <p class="opacity-70">يرجى فتح تحديد الموقع (اللوكيشن) لكي تستطيع تسجيل الحضور او الانصراف📍</p>
        </div>
        <script>
            // ✅ التعريف الآمن لـ CSRF Token كمتغير عام
            const csrfToken = "{{ csrf_token() }}";
        </script>
        <script type="text/javascript">
            // متغيرات لتخزين الإحداثيات
            let lat = null;
            let lng = null;
            // دالة الزر الأول: تجلب وتخزن
            function getLocationAndCheckIn() {
                document.getElementById('geo-status').innerText = 'جاري تحديد موقعك... 🌐';
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            lat = position.coords.latitude; // التخزين في المتغير العام
                            lng = position.coords.longitude; // التخزين في المتغير العام
                            
                            document.getElementById('geo-status').innerHTML = 
                                `
                                خط العرض (Lat): ${lat.toFixed(6)}
                                خط الطول (Lon): ${lng.toFixed(6)}`;
                                sendCheckRequest(lat, lng); // استدعاء الدالة الثانية هنا
                        },
                        (error) => {
                            document.getElementById('geo-status').innerText = '🚫 فشل تحديد الموقع: يرجى تمكين الموقع.';
                            lat = null; // تفريغ القيمة في حالة الخطأ
                            lng = null;
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                } else {
                    document.getElementById('geo-status').innerText = '⚠ المتصفح لا يدعم تحديد الموقع.';
                }
            }
            function sendCheckRequest(lat, lng) {
                if (lat && lng) { 
                    document.getElementById('geo-status').innerText = 'جاري إرسال الإحداثيات للمقارنة...';
                    //يرسل مفتاح الامان CSRF    
                   // csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    // :اسم المسار هو 'api.check.location'
                    fetch("{{ route('api.check.location') }}", { //fetch("/api/check-location")
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        //تحويل البيانات إلى JSON
                        body: JSON.stringify({ lat: lat, lng: lng })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // عرض النتيجة المستلمة من الخادم
                        document.getElementById('geo-status').innerText = data.message;
                        if (data.status === 'success') {
                            // ✅ حالة النجاح (داخل النطاق): نحدث الصفحة ونعرض اللون الأخضر
                            document.getElementById('geo-status').style.color = 'green';
                            // تحديث الصفحة بعد  نصف ثانية
                            setTimeout(() => {
                                window.location.reload(); 
                            }, 500); 
                        } else {
                            // ❌ حالة الفشل (خارج النطاق أو خطأ أمني)
                            document.getElementById('geo-status').style.color = 'red';
                        }
                    })
                    .catch(error => {
                        document.getElementById('geo-status').innerText = 'حدث خطأ في الاتصال بالخادم.';
                        document.getElementById('geo-status').style.color = 'red';
                    });

                } else {
                    document.getElementById('geo-status').innerText = '⚠️ يرجى أولاً جلب الإحداثيات بالزر الأول.';
                }
            }
    </script>
        {{-- رسائل نجاح أو خطأ (يمكنك إضافة منطق لعرض رسائل الجلسة هنا) --}}
        <div style="margin-bottom: 16px;">
            {{-- عرض حالة تحديد الموقع --}}
            <p id="geo-status" class="text-sm text-blue-600 font-semibold"></p>
            

            {{-- أزرار Check in/out --}}
             @if ($currentAttendance)
                <button wire:click="checkOut" class="bg-red-600 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                   تسجيل المغادرة الآن
                </button>
                    <h2 style="font-size: 1.7rem; font-weight: bold; margin-bottom: 7px;">
                        {{ auth()->user()->name }} ,مرحباً بك 
                    </h2>
                    <p>{{ $currentAttendance->created_at->isoFormat('dddd، D MMMM YYYY') }} {{ $currentAttendance->check_in->format('h:i A') }} :تم تسجيل دخولك في </P>
            @else
                <button onclick="getLocationAndCheckIn();" class="bg-green-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    تسجيل دخول الآن
                </button>
            @endif 
        </div>
        
        <hr style="margin-bottom: 16px;"> 

        {{-- جدول يعرض كل سجلات المستخدم --}}
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            
            {{-- ❌ حذف <thead> الأصلي هنا --}}
            
            <tbody class="bg-white divide-y divide-gray-200">
                
                {{-- ✅ التكرار على السجلات --}}
                @foreach($records as $index => $record)
                    
                    {{-- 🛑 إضافة رؤوس الأعمدة قبل الصف الأول فقط (اختياري، لكنه أنظف) --}}
                    @if ($loop->first)
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">التاريخ</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">وقت الدخول</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">وقت المغادرة</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">مدة الحضور</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">حالة الحضور</th>
                        </tr>
                    @endif
                    
                    @php
                        $dailyStatus = $this->getDailyStatusAndColor($record);
                        $colorClass = ($dailyStatus['status'] === '🟢 تم تحقيق الوقت المطلوب') ? 'text-green-600' : 
                                        (($dailyStatus['status'] === '🟡 أقل من الوقت المطلوب') ? 'text-yellow-600' : 'text-red-600');
                        $rowClass = $loop->odd ? 'bg-white' : 'bg-gray-50'; // تظليل الصفوف
                    @endphp
            
                    <tr class="{{ $rowClass }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($record->created_at)->isoFormat('dddd، D MMMM YYYY') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->check_in ? $record->check_in->format('h:i A') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->check_out ? $record->check_out->format('h:i A') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($record->duration !== null)
                                @php
                                    $minutes = $record->duration;
                                    $hours = floor($minutes / 60);
                                    $remainingMinutes = $minutes % 60;
                                @endphp
                                {{ $hours }}h : {{ str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) }}m
                            @else
                                -
                            @endif
                        </td>
                        {{-- عرض حالة اليوم --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $colorClass }}">
                            {{ $dailyStatus['status'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf 
            <button type="submit" 
                class="bg-red-600 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                logout
            </button>
        </form>
    </div>
</div>
