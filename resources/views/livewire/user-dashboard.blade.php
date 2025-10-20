<div>
    <div>
    <script type="text/javascript">
            //  دالة JavaScript للحصول على الموقع وإرساله إلى Livewire
      function getLocationAndCheckIn() {
        // عرض رسالة 'جاري التحديد'
        document.getElementById('geo-status').innerText = 'جاري تحديد موقعك... 🌐';
        
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            // في حالة النجاح
            (position) => {
              const lat = position.coords.latitude;
              const lng = position.coords.longitude;
              
              document.getElementById('geo-status').innerText = 'تم تحديد الموقع. جاري التحقق من النطاق...';
              
              // إرسال الإحداثيات إلى دالة checkIn في Livewire
              Livewire.dispatch('performCheckIn', { lat: lat, lng: lng }); 
            },
            // في حالة فشل الحصول على الموقع (رفض أو خطأ)
            (error) => {
              document.getElementById('geo-status').innerText = '🚫 فشل تحديد الموقع: يرجى تمكين الموقع والمحاولة مجدداً.';
              // عرض رسالة خطأ للمستخدم
              Livewire.dispatch('sessionMessage', { type: 'error', message: 'يجب السماح بالوصول للموقع لتسجيل الحضور.' });
            },
            // خيارات إضافية لدقة الموقع
            { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
          );
        } else {
          document.getElementById('geo-status').innerText = '⚠ المتصفح لا يدعم تحديد الموقع.';
        }
      }
    </script>
        {{-- رسائل نجاح أو خطأ (يمكنك إضافة منطق لعرض رسائل الجلسة هنا) --}}
        <div style="margin-bottom: 16px;">
            {{-- عرض حالة تحديد الموقع --}}
            <p id="geo-status" class="text-sm text-blue-600 font-semibold"></p>

            {{-- أزرار Check in/out --}}
            @if ($currentAttendance)
                <button wire:click="checkOut" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    تسجيل خروج
                </button>
                <p style="margin-top: 8px;">تم تسجيل دخولك في: {{ $currentAttendance->created_at->format('Y-m-d') }} {{ $currentAttendance->check_in->format('H:i A') }}</p>
            @else
                <button onclick="getLocationAndCheckIn();" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    تسجيل دخول (مع الموقع)
                </button>
            @endif
        </div>
        
        <hr style="margin-bottom: 16px;">

        {{-- جدول يعرض كل سجلات المستخدم --}}
        <h2>سجلات حضوري</h2>
        <table style="width:100%; border-collapse: collapse; text-align: right;">
            <tr>
                <th style="padding: 8px; border: 1px solid #ddd;"> التاريخ</th>
                <th style="padding: 8px; border: 1px solid #ddd;">وقت الدخول</th>
                <th style="padding: 8px; border: 1px solid #ddd;">وقت الخروج</th>
                <th style="padding: 8px; border: 1px solid #ddd;">مده الحضور</th>
            </tr>
            @foreach($records as $record)
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $record->created_at->format('Y-m-d') }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $record->check_in ? $record->check_in->format('h:i A') : '-' }}</td>
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
            </tr>
            @endforeach
        </table>
        <form method="POST" action="{{ route('logout') }}">
            @csrf 
            <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                logout
            </button>
        </form>
    </div>
</div>
{{-- كود انك تدخل الاحداثيات بنفسك --}}
{{-- <script type="text/javascript">
            //  دالة JavaScript للحصول على الموقع وإرساله إلى Livewire
            function getLocationAndCheckIn() {
                // عرض رسالة 'جاري التحديد'
                document.getElementById('geo-status').innerText = 'جاري تحديد موقعك... 🌐';
                
                if (navigator.geolocation) {

                    const lat = 24.783375;//واقف عند المترو
                    const lng = 46.683176;
                    
                    document.getElementById('geo-status').innerText = 'تم تحديد الموقع. جاري التحقق من النطاق...';
                    
                    // إرسال الإحداثيات إلى دالة checkIn في Livewire
                    Livewire.dispatch('performCheckIn', { lat: lat, lng: lng }); 
                    //طلب تحديد احداثيات المستخدم 
                    navigator.geolocation.getCurrentPosition(

                        //position
                        // في حالة النجاح
                        //(position) => {
                            //const lat = position.coords.latitude;
                            //const lng = position.coords.longitude;

                           // const lat = 46.2156;
                           // const lng = 24.2568;
                            
                            //document.getElementById('geo-status').innerText = 'تم تحديد الموقع. جاري التحقق من النطاق...';
                            
                            // إرسال الإحداثيات إلى دالة checkIn في Livewire
                            //Livewire.dispatch('performCheckIn', { lat: lat, lng: lng }); 
                        //},
                        // في حالة فشل الحصول على الموقع (رفض أو خطأ)
                        (error) => {
                           // document.getElementById('geo-status').innerText = '🚫 فشل تحديد الموقع: يرجى تمكين الموقع والمحاولة مجدداً.';
                            // عرض رسالة خطأ للمستخدم
                            //Livewire.dispatch('sessionMessage', { type: 'error', message: 'يجب السماح بالوصول للموقع لتسجيل الحضور.' });
                            Livewire.dispatch('locationError');
                        },
                        // خيارات إضافية لدقة الموقع
                        //{ enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                    );
                } else {
                    document.getElementById('geo-status').innerText = '⚠ المتصفح لا يدعم تحديد الموقع.';
                }
            }
        </script> --}}
    {{-- الكود الاصلي --}}
        {{-- <script type="text/javascript">
            //  دالة JavaScript للحصول على الموقع وإرساله إلى Livewire
      function getLocationAndCheckIn() {
        // عرض رسالة 'جاري التحديد'
        document.getElementById('geo-status').innerText = 'جاري تحديد موقعك... 🌐';
        
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            // في حالة النجاح
            (position) => {
              const lat = position.coords.latitude;
              const lng = position.coords.longitude;
              
              document.getElementById('geo-status').innerText = 'تم تحديد الموقع. جاري التحقق من النطاق...';
              
              // إرسال الإحداثيات إلى دالة checkIn في Livewire
              Livewire.dispatch('performCheckIn', { lat: lat, lng: lng }); 
            },
            // في حالة فشل الحصول على الموقع (رفض أو خطأ)
            (error) => {
              document.getElementById('geo-status').innerText = '🚫 فشل تحديد الموقع: يرجى تمكين الموقع والمحاولة مجدداً.';
              // عرض رسالة خطأ للمستخدم
              Livewire.dispatch('sessionMessage', { type: 'error', message: 'يجب السماح بالوصول للموقع لتسجيل الحضور.' });
            },
            // خيارات إضافية لدقة الموقع
            { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
          );
        } else {
          document.getElementById('geo-status').innerText = '⚠ المتصفح لا يدعم تحديد الموقع.';
        }
      }
    </script> --}}