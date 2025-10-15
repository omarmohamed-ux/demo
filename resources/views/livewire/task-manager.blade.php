<div class="flex min-h-screen">
    {{-- [الشريط الجانبي الايمن] يعرض التصنيفات (أنواع المهام) --}}
    
    <div class="w-64 bg-white-100 border-l border-gray-200 p-6 shadow-lg order-last">
        
        {{-- [عنوان] أنواع المهام/التصنيفات --}}
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">أنواع المهام (التصنيفات)</h3>

        {{-- [قائمة] عرض كل التصنيفات المتاحة --}}
        <ul class="space-y-2">
            {{-- [فئة افتراضية] لإظهار كل المهام --}}
            <li class="flex justify-between items-center text-sm p-2 rounded bg-blue-50 text-blue-700 font-semibold transition cursor-pointer">
                <span>كل المهام</span>
            </li>
            @foreach ($tasks as $task)
                @foreach ($categories as $category)
                    {{-- [عنصر القائمة] --}}
                    <li class="flex justify-between items-center text-sm p-2 rounded hover:bg-gray-200 transition cursor-pointer">
                        <span>{{ $category->name }} {
                            {{ $task->title}} }
                        </span>
                        {{-- ملاحظة: يمكن هنا إضافة دالة wire:click لفلترة المهام حسب التصنيف --}}
                    </li>
                @endforeach
            @endforeach
        </ul>       
    </div>
    
    {{-- ------------------------------------------------------------- --}}
    {{-- [المحتوى الرئيسي] عمود مرن يأخذ المساحة المتبقية على اليمين --}}
    {{-- ------------------------------------------------------------- --}}
    {{-- [الحاوية] تستخدم order-first لتبقى على اليمين وتأخذ المساحة الأكبر --}}
    <div class="flex-grow py-8 px-4 max-w-4xl mx-auto space-y-8 order-first">
    
        {{-- **2. نموذج إضافة تصنيف جديد (مكانه الحالي)** --}}
        <div class="bg-white p-5 border border-gray-200 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">إضافة تصنيف جديد 🏷️</h2>
            <form wire:submit="save_category" class="flex flex-col sm:flex-row gap-3">
                <input type="text" 
                    wire:model="category_name" 
                    placeholder="اسم التصنيف" 
                    class="flex-grow p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-base">
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition duration-150 shadow-md min-w-[100px]">
                    حفظ التصنيف
                </button>
            </form>
            @error('category_name') 
                <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> 
            @enderror
        </div>

        {{-- **3. نموذج إضافة مهمة جديدة** --}}
        <form wire:submit="save_task" class="bg-white p-6 border border-gray-200 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-5 text-gray-800">أضف المهمة القادمة 🚀</h2>
            
            <div class="space-y-4">
                <input type="text" 
                    wire:model="title" 
                    placeholder="أدخل عنوان المهمة..." 
                    class="w-full p-2 border-b border-gray-300 focus:border-blue-500 focus:ring-0 text-base">
                
                <div class="flex flex-col sm:flex-row gap-3 items-center">
                    <select wire:model="category_id" 
                            class="w-full sm:w-1/2 p-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- اختر تصنيف --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    
                    <button type="submit" 
                            class="w-full sm:w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-150 shadow-md">
                        حفظ المهمة
                    </button>
                </div>
            </div>
            @error('title') <span class="text-red-500 block text-xs mt-2">{{ $message }}</span> @enderror
            @error('category_id') <span class="text-red-500 block text-xs mt-2">{{ $message }}</span> @enderror
        </form>

        {{-- **4. قائمة عرض المهام الحالية** --}}
        <h3 class="text-xl font-bold text-gray-800 pt-4 border-t mt-6">مهام الموظف الحالية ({{ count($tasks) }})</h3>
        
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