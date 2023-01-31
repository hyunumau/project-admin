## Bắt đầu

Chạy lệnh:

```bash
cp .env.example .env
```

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Định nghĩa từ sail `./vendor/bin/sail`

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

```bash
sail composer install
```

```bash
sail artisan key:generate
```

Cài đặt các packages và build

```bash
sail npm install && sail npm run dev
```

## Không dùng docker (laravel sail)

Tạo file chứa các biến môi trường

```bash
cp .env.example .env
```

Cài đặt các package thông qua composer

```bash
composer install
```

```bash
php artisan key:generate
```

```bash
npm install && npm run dev
```

## Cấu hình thông tin kết nối database trong .env

```text
DB_CONNECTION // mặc định là mysql
DB_HOST // mặc định là localhost (Nếu dùng docker thì tên của database service trong docker-compose.yml)
DB_PORT // Mặc định của mysql là 3306, postgres là 5432
DB_DATABASE // Tên database
DB_USERNAME // Username
DB_PASSWORD // Password
```

Chạy lệnh tạo database và thêm dữ liệu mẫu:

```bash
sail artisan migrate --seed
# hoặc không dùng sail
php artisan migrate --seed
```
**Cảm ơn vì đã đọc hướng dẫn trước sử dụng**