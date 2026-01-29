<div>
    <div>
        <nav class="bg-gray-800 p-4">
            <div class="container mx-auto flex justify-between items-center">
                @auth
                    <h1 class="text-white mr-4 mt-4 text-1 font-bold">
                        {{ __('messages.Welcome') }}, 
                        <span class="text-white">{{ auth()->user()->name }}</span>
                    </h1>
                @endauth
                <div class="flex items-center gap-2 mr-4 mt-4{{ app()->getLocale() == 'ar' ? 'left: 15px;' : 'right: 15px;' }} z-index: 9999;">
                        <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" 
                            class="bg-white text-gray-800 px-4 py-2 rounded-lg border border-gray-300 font-bold shadow-sm hover:bg-gray-50 transition duration-200 text-sm">
                            {{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}
                        </a>
                    <form method="POST" action="{{ route('logout')}}">
                        @csrf 
                        <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                            {{ __('messages.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="text-center">
                <h2 class="text-2xl md:text-4xl p-7 font-bold"><strong class="text-green-600">{{ __('messages.attendance_title') }}</strong></h2>
                <p class="opacity-70"><strong class="text-gray-700">{{ __('messages.confirmation') }}</strong></p>
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
                document.getElementById('geo-status').innerText = 'Your location is being determined... 🌐';
                
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
                            document.getElementById('geo-status').innerText = '{{ __("messages.failed_location") }}';
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
                    document.getElementById('geo-status').innerText = 'The coordinates are being sent for comparison...';
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
                   {{ __('messages.log_out_now') }}
                </button>
                    <h2 style="font-size: 1.7rem; font-weight: bold; margin-bottom: 7px;">
                        {{ __('messages.welcome') }}, {{ auth()->user()->name }} 
                    </h2>
                    <p>{{ __('messages.You have logged in') }}: {{ $currentAttendance->created_at->isoFormat('dddd، D MMMM YYYY') }} {{ $currentAttendance->check_in->format('h:i A') }}</P>
            @else
                <button onclick="getLocationAndCheckIn();" class="bg-green-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    {{ __('messages.take_attendance_now') }}
                </button>
            @endif 
        </div>
        
        <strong class="text-green-600"><hr style="margin-bottom: 16px;"></strong> 

        {{-- جدول يعرض كل سجلات المستخدم --}}
        <div class="w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('messages.date') }}</th>
                    <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('messages.entry_time') }}</th>
                    <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('messages.departure time') }}</th>
                    <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('messages.Duration of attendance ') }}</th>
                    <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('messages.Attendance status') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    {{-- ✅ التكرار على السجلات --}}
                    @foreach($records as $index => $record)
                        
                        @php
                            $dailyStatus = $this->getDailyStatusAndColor($record);
                            $colorClass = ($dailyStatus['status'] === __('messages.🟢 The required time has been achieved.')) ? 'text-green-600' : 
                                            (($dailyStatus['status'] === __('messages.🟡 Less time than required')) ? 'text-yellow-600' : 'text-red-600');
                            $rowClass = $loop->odd ? 'bg-white' : 'bg-gray-50'; // تظليل الصفوف
                        @endphp
                
                        <tr class="{{ $rowClass }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($record->created_at)->isoFormat('dddd، D MMMM YYYY') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $record->check_in ? $record->check_in->format('h:i A') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $record->check_out ? $record->check_out->format('h:i A') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
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
        <hr class="my-6 border-gray-300">
    </div>
</div>
