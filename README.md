# Laravel-Blog

Proje çalıştığında seeder ile 3 kullaıcı ve 3 kategori oluşturulur

### Kurulum

Projenin çalışması için aşağıdaki adımları takip edebilirsiniz:

1. Depoyu klonlayın
    ```bash
    git clone https://github.com/kullanici_adiniz/proje_adi.git
    ```

2. Backend dizinine gidin
    ```bash
    cd Blog-Api
    ```

3. projeyi çalıştırın
    ```bash
    docker compose up -d --build
    ```

4. Veritabanı migrasyonlarını çalıştırın
    ```bash
    docker compose exec laravel_eleven_app bash
    php artisan migrate --seed
    php artisan schedule:work
    ```

5. Frontend dizinine gidin
    ```bash
    cd Blog-Frontend
    ```

6. Projeyi çalıştırın
    ```bash
    docker compose up -d --build
    ```  

### Portlar

```bash
Backend:6162
Frontend:6161
Phpmyadmin:8383

