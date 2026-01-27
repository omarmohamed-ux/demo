<div>

    <header >
        <nav class="bg-green-800 p-4 shadow-md w-full flex justify-between items-center sticky top-0 z-50">
        <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
              <span class="sr-only">Your Company</span>
              <img src="https://alnaierh.com/storage/de/pa/designpageiconsaeidii_1702195768.png" alt="" class="h-16 w-auto" />
            </a>
        </div>
        <div style="position: fixed; top: 15px; {{ app()->getLocale() == 'ar' ? 'left: 15px;' : 'right: 15px;' }} z-index: 9999;">
            <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" 
            style="background: #ffffff; color: #1f2937; padding: 8px 16px; border-radius: 8px; border: 1px solid #ddd; text-decoration: none; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}
            </a>
        </div>
        {{-- مسافه في ناف بار --}}
        <el-popover-group class="hidden lg:flex lg:gap-x-8"> 

        <div class="relative">
        <button popovertarget="employee-units-menu" class="flex items-center gap-x-1 text-sm/6 font-semibold text-white bg-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-900 transition">
            إدارة الوحدات السكنية
            <svg viewBox="0 0 20 20" fill="currentColor" class="size-5 flex-none text-indigo-200">
                <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" />
            </svg>
        </button>

    <div id="employee-units-menu" anchor="bottom" popover class="w-screen max-w-md overflow-hidden rounded-3xl bg-gray-700 border border-white/10 shadow-2xl transition transition-discrete [--anchor-gap:12px] open:block data-closed:opacity-0 data-closed:translate-y-2 data-enter:duration-200">
        
        <div class="p-4">
            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-white/5">
                <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-blue-500/10 group-hover:bg-blue-500/20">
                    <svg class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                
                <div class="flex-auto">
                    <button wire:click="toggleMainModal" class="block font-semibold text-white">
                        إضافة وحدات جديدة
                        <span class="absolute inset-0"></span>
                    </button>
                    @if($showMainModal)
                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-60 backdrop-blur-sm">
                            
                            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
                                
                                <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-gray-800">إدارة الوحدات السكنية</h3>
                                    <button wire:click="toggleMainModal" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
                                </div>

                                <div class="p-8">
                                    @if(!$showAddUnitForm)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <button wire:click="openAddUnit" class="flex items-center justify-center p-4 border-2 border-dashed border-blue-400 rounded-lg hover:bg-blue-50 transition">
                                                <span class="text-blue-600 font-semibold">+ إضافة وحدات سكنية جديدة</span>
                                            </button>
                                            
                                            <button class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                                <span class="text-gray-700 font-semibold">عرض خريطة الوحدات</span>
                                                {{--  او  /او ربطها مع تقارير سريعه href /اضافه داله لعرض الوحدات --}}
                                            </button>
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            <h4 class="font-bold text-blue-600 border-b pb-2">إضافة وحدة جديدة للمجمع</h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">موقع الوحدة</label>
                                                    <select 
                                                        wire:model="unitType" 
                                                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 bg-white appearance-none cursor-pointer">
                                                        <option value="">اختر الموقع...</option>
                                                        <option value="apartment">شمال</option>
                                                        <option value="villa">جنوب</option>
                                                        <option value="duplex">شرق</option>
                                                        <option value="office">غرب</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">نوع الوحدة</label>
                                                    <select 
                                                        wire:model="unitType" 
                                                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 bg-white appearance-none cursor-pointer">
                                                        <option value="">اختر النوع...</option>
                                                        <option value="apartment">شقة</option>
                                                        <option value="villa">فيلا</option>
                                                        <option value="duplex">دوبلكس</option>
                                                        <option value="office">مكتب</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">رقم الوحدة</label>
                                                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">عدد الوحدات</label>
                                                    <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                            </div>
                                            <div class="flex justify-end space-x-2 space-x-reverse mt-4">
                                                <button wire:click="$set('showAddUnitForm', false)" class="text-gray-600 px-4 py-2">رجوع</button>
                                                <button class="bg-green-600 text-white px-6 py-2 rounded-lg">حفظ البيانات</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endif
                    <p class="mt-1 text-gray-400">إدخال بيانات وحدات سكنية جديدة للكومبوند</p>
                    
                </div>
            </div>

            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-white/5">
                <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-green-500/10 group-hover:bg-green-500/20">
                    <svg class="size-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0V12m0 4.5V21m3-4.5V18m0-1.5h.008v.008H13.5V16.5Zm3-2.25V12m0 2.25V21" />
                    </svg>
                </div>
                <div class="flex-auto">
                    <a href="#" class="block font-semibold text-white">
                        إحصائيات الإشغال
                        <span class="absolute inset-0"></span>
                    </a>
                    {{-- popup --}}
                    <p class="mt-1 text-gray-400">نسبة الوحدات المحجوزة والمتاحة حالياً</p>
                </div>
            </div>

            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-white/5">
                <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-yellow-500/10 group-hover:bg-yellow-500/20">
                    <svg class="size-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.423 20.246L10.687 18.235m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM4.5 18.75h15" />
                    </svg>
                </div>
                <div class="flex-auto">
                    <a href="#" class="block font-semibold text-white">
                        طلبات الصيانة
                        <span class="absolute inset-0"></span>
                      {{-- popup --}}
                    </a>
                    <p class="mt-1 text-gray-400">متابعة بلاغات الأعطال في الوحدات السكنية</p>
                </div>
            </div>

            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-white/5">
                <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-red-500/10 group-hover:bg-red-500/20">
                    <svg class="size-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.744c0 5.548 4.076 10.21 9 11.109 4.924-.899 9-5.561 9-11.109 0-1.258-.194-2.47-.557-3.613A11.959 11.959 0 0112 2.714z" />
                    </svg>
                </div>
                <div class="flex-auto">
                    <a href="#" class="block font-semibold text-white">
                        تصاريح الدخول
                        <span class="absolute inset-0"></span>
                        {{-- popup --}}
                    </a>
                    <p class="mt-1 text-gray-400">إدارة تصاريح الزوار والملاك للوحدات</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 divide-x divide-white/10 bg-gray-800/50">
            <a href="#" class="flex items-center justify-center gap-x-2.5 p-3 text-sm/6 font-semibold text-white hover:bg-gray-700">
                <svg class="size-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                تقرير سريع
                {{-- popup --}}
            </a>
            <a href="#" class="flex items-center justify-center gap-x-2.5 p-3 text-sm/6 font-semibold text-white hover:bg-gray-700">
                <svg class="size-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                </svg>
                اتصال بالمشرف 
                {{-- popup --}}
            </a>
        </div>
    </div>
</div>

        <a href="/employeetaskview" class="inline-flex items-center gap-x-2 text-sm/6 font-semibold text-white bg-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-900 transition flex-row-reverse">
            <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>المهام</span>
        </a>
        <a href="#" class="text-sm/6 font-semibold text-white bg-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-900 transition">
            <span class="hidden md:inline">الإشعارات</span>
        </a>
        <a href="/user" class="text-sm/6 font-semibold text-white bg-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-900 transition">الحضور/الانصراف</a>
        </el-popover-group>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <a href="/" class="text-sm/6 font-semibold text-white bg-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-900 transition">Log in/Log out <span aria-hidden="true">&rarr;</span></a>
        </div>
        
    </nav>
    
    {{-- <el-dialog>
        <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
            <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
                </a>
                <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-400">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-white/10">
                <div class="space-y-2 py-6">
                    <div class="-mx-3">
                    <button type="button" command="--toggle" commandfor="products" class="flex w-full items-center justify-between rounded-lg py-2 pr-3.5 pl-3 text-base/7 font-semibold text-white hover:bg-white/5">
                        Product
                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 flex-none in-aria-expanded:rotate-180">
                        <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </button>
                    <el-disclosure id="products" hidden class="mt-2 block space-y-2">
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Analytics</a>
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Engagement</a>
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Security</a>
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Integrations</a>
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Automations</a>
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Watch demo</a>
                        <a href="#" class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-white hover:bg-white/5">Contact sales</a>
                    </el-disclosure>
                    </div>
                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Features</a>
                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Marketplace</a>
                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Company</a>
                </div>
                <div class="py-6">
                    <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                </div>
                </div>
            </div>
            </el-dialog-panel>
        </div>
        </dialog>
    </el-dialog> --}}
    </header>
    <body>
        aslamalikom omar is in the house
        <h1>locale is {{ app()->getLocale() }}</h1>
        {{ __("auth.throttle") }}
        href to switch language:
        <a href="lang/en">English</a> |
        <a href="lang/ar">Arabic</a>
        <p>I will display &#x1F3CB;</p>
        
    </body>
</div>