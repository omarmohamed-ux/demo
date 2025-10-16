# ✅ استخدم صورة FrankenPHP الرسمية
FROM dunglas/frankenphp:1.0.4-php8.3

# ✅ إعداد بيئة العمل
WORKDIR /app

# ✅ نسخ ملفات Laravel الأساسية
COPY . .

# ✅ تثبيت أدوات النظام المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# ✅ تثبيت Composer (إن لم يكن مثبتاً مسبقاً)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ✅ تثبيت مكتبات Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ✅ نسخ إعدادات PHP
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# ✅ إعداد صلاحيات Laravel
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data /app

# ✅ نسخ ملف Caddyfile بعد كل شيء
COPY Caddyfile /etc/caddy/Caddyfile

# ✅ المنفذ الأساسي
EXPOSE 80

# ✅ أمر التشغيل النهائي
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--worker", "0"]