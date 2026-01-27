<div>
    <div>
        <div style="position: fixed; top: 15px; {{ app()->getLocale() == 'ar' ? 'left: 15px;' : 'right: 15px;' }} z-index: 9999;">
            <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" 
            style="background: #ffffff; color: #1f2937; padding: 8px 16px; border-radius: 8px; border: 1px solid #ddd; text-decoration: none; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}
            </a>
        </div>
        <h2 class="text-2xl md:text-4xl p-5 font-bold mx-auto w-fit">
            <strong class="text-green-600">{{ __('messages.Attendance records for all employees') }}</strong>
        </h2>
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
                {{-- ✅ التكرار الأول: التكرار على مجموعات الموظفين --}}
                @foreach($records as $userName => $userRecords)
                    
                    {{-- صف لاسم الموظف (العنوان الرئيسي) --}}
                    <tr class="bg-gray-200">
                        <td colspan="5" class="px-6 py-2 text-left text-sm font-extrabold text-gray-900 uppercase">
                            {{ $userName }}
                        </td>
                    </tr>

                    {{-- ✅ التكرار الثاني: التكرار على سجلات الموظف الواحد --}}
                    @foreach($userRecords as $index => $record)
                        @php
                            $dailyStatus = $this->getDailyStatusAndColor($record);
                            $colorClass = ($dailyStatus['status'] === '🟢 The required time has been achieved.') ? 'text-green-600' : 
                                          (($dailyStatus['status'] === '🟡 Less time than required') ? 'text-yellow-600' : 'text-red-600');
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $colorClass }}">
                                {{ $dailyStatus['status'] }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <form method="POST" action="{{ route('logout')}}">
            @csrf 
            <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                {{ __('messages.logout') }}
            </button>
        </form>
    </div>
</div>
