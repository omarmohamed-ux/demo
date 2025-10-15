<div>
    <div>
        
        <h3 class="text-xl font-bold text-gray-800  mt-6">مهامك الحالية ({{ count($tasks) }})</h3>
        <div class="space-y-3">
            @forelse ($tasks as $task)
                @php
                    $cardBorder = $task->is_completed ? 'border-l-4 border-green-500 bg-gray-50' : 'border-l-4 border-blue-500 bg-white hover:bg-gray-50';
                    $titleClass = $task->is_completed ? 'line-through text-gray-500' : 'text-gray-900';
                    $statusColor = $task->is_completed ? 'text-green-600' : 'text-red-500';
                @endphp
                
                <div class="flex items-center justify-between p-4 rounded-lg border {{ $cardBorder }} transition duration-150 shadow-sm">
                    
                    <div class="flex items-center space-x-4 rtl:space-x-reverse flex-grow">
                        
                        <input type="checkbox" 
                            wire:click="toggle_Task({{ $task->id }})" 
                            {{ $task->is_completed ? 'checked' : '' }} 
                            class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">

                        <div>
                            <p class="font-medium text-base {{ $titleClass }}">{{ $task->title }}</p>
                            <span class="text-xs text-gray-500 mt-0.5 inline-block">{{ $task->category->name }}</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 rtl:space-x-reverse">

                        <button 
                            wire:click="delete_Task({{ $task->id }})" 
                            onclick="confirm('هل أنت متأكد من حذف هذه المهمة؟') || event.stopImmediatePropagation()"
                            class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition duration-150"
                            title="حذف المهمة">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 12.14A2 2 0 0116.14 21H7.86a2 2 0 01-1.99-1.86L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 0h-4"/>
                            </svg>
                        </button>

                        <span class="text-sm font-semibold {{ $statusColor }}">
                            @if ($task->is_completed) 
                                ✅ مُنجزة
                            @else
                                ⏳ قيد العمل
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 p-6 border border-gray-200 rounded-lg bg-white text-center">لا توجد مهام حالياً. أضف أول مهمة! ✨</p>
            @endforelse
        </div>
    </div>
</div>
