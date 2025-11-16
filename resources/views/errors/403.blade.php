<div>
    <div style="text-align: center; padding: 50px; background-color: #f8f8f8; border-radius: 10px; max-width: 600px; margin: 50px auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <h1 style="color: #DC2626; font-size: 2.5rem; margin-bottom: 15px;">403 - وصول غير مصرح به</h1>
        
        <p style="color: #333; font-size: 1.2rem; margin-bottom: 30px;">
            عذراً، لا تمتلك الصلاحية للوصول إلى هذه الصفحة.
        </p>
        @php
            // تحديد مسار العودة بناءً على دور المستخدم بعد المصادقة
            $targetRoute = auth()->check() ? 
                (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : 
                route('login');
        @endphp

        <a href="{{ $targetRoute }}" 
        style="display: inline-block; padding: 12px 25px; background-color: #10B981; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; transition: background-color 0.3s;">
            اضغط للعودة إلى لوحة التحكم الخاصة بك
        </a>
    </div>
</div>    