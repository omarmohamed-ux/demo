<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // 👈 ضروري لتشفير كلمة المرور

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. استدعاء Seeder المنتجات لإنشاء البيانات
        // هذا السطر الآن يعمل بشكل صحيح لأنه تم توفير ProductSeeder
        $this->call(ProductSeeder::class); 
        
        //  إضافة احداثيات موقع المكتب هنا
        Location::firstOrCreate(
            ['name' => ' مكتب التدريب '],
            [
                'latitude' => 24.7136,
                'longitude' => 46.6753,
                'allowed_radius' => 100, // 100 متر
            ]
        );
        //  إضافة احداثيات موقع الجامعة هنا
        Location::firstOrCreate(
            ['name' => ' الجامعة العربية المفتوحة '],
            [
                'latitude' => 24.768403,
                'longitude' => 46.5904,
                'allowed_radius' => 200, // 200 متر
            ]
        );
        // 2. تعريف مصفوفة المستخدمين المطلوب إضافتهم
        $users = [
            [
                'name' => 'Omar Mohamed Elmetwaly Ahmed',
                'email' => '21510278ksa@aou.edu.sa',
                // تشفير كلمة المرور: يجب استخدام Hash::make
                'password' => Hash::make('12345678'), 
                'role' => 'admin', // 👈 المدير الأول - للوصول إلى /admin
            ],
            [
                'name' => 'Admin 2',
                'email' => 'admin2@demo.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin', // 👈 المدير الثاني - للوصول إلى /admin
            ],
            [
                'name' => 'Omar Mohamed',
                'email' => 'omarmetwaly888@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'user', // 👈 مستخدم عادي - للوصول إلى /user
            ],
            [
                'name' => 'Yousof Fetyani',
                'email' => 'Yousof.fetyani@gmail.com',
                'password' => Hash::make('12345678'), 
                'role' => 'user', // 👈 مستخدم عادي - للوصول إلى /user
            ],
            [
                'name' => 'Ali Mohammed',
                'email' => 'alimohamed5131@gmail.com',
                'password' => Hash::make('12345678'), 
                'role' => 'user', // 👈 مستخدم عادي - للوصول إلى /user
            ],
        ];

        // 3. عمل حلقة تكرار لإنشاء المستخدمين في قاعدة البيانات
        foreach ($users as $userData) {
            // firstOrCreate: ينشئ المستخدم فقط إذا لم يكن الإيميل موجوداً بالفعل
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }
    }
}