<div>
    <div>
        <nav class="bg-gray-800 p-6 rounded-b-lg shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                
                <div class="flex items-center gap-4">
                    <a href="/admin" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img src="https://as2.ftcdn.net/jpg/04/92/02/53/1000_F_492025360_Ie3uQ8atn7SKumbIX1dj9eMJccHP8a5N.jpg" 
                            alt="Logo" class="h-12 w-auto rounded" />
                    </a>

                    @auth
                        <h1 class="text-white text-lg font-bold">
                            {{ __('messages.Welcome admin') }}, 
                            <span class="text-white">{{ auth()->user()->name }}</span>
                        </h1>
                    @endauth
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" 
                    class="bg-white text-gray-800 px-4 py-2 rounded-lg border border-gray-300 font-bold shadow-sm hover:bg-gray-50 transition text-sm">
                        {{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold shadow-sm hover:bg-red-700 transition text-sm">
                            logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>
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
                            <button popovertarget="employee-units-menu" class="flex items-center gap-x-1 text-sm/6 font-semibold text-white bg-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-900 transition">
                            {{ $userName }}
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 flex-none text-indigo-200">
                                    <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" />
                                </svg>
                            </button>
                            <div id="employee-units-menu" anchor="bottom"></div>                              
                        </td>
                    </tr>
                    {{-- ✅ التكرار الثاني: التكرار على سجلات الموظف الواحد --}}
                    @foreach($userRecords as $index => $record)
                        @php
                            $dailyStatus = $this->getDailyStatusAndColor($record);
                            $colorClass = ($dailyStatus['status'] === __('messages.🟢 The required time has been achieved.')) ? 'text-green-600' : 
                                          (($dailyStatus['status'] === __('messages.🟡 Less time than required')) ? 'text-yellow-600' : 'text-red-600');
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
                </h1>    
                @endforeach
            </tbody>
        </table>
        <hr class="my-6 border-gray-300">
    </div>
</div>
