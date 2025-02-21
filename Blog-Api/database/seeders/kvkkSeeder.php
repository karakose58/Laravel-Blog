<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kvkk;

class kvkkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kvkk::create([
'kvkk' => '# Kişisel Verilerin Korunması Kanunu (KVKK) Bilgilendirme

**Giriş**
Bu sayfa, [Site Adı] olarak, Türkiye Cumhuriyeti Kişisel Verilerin Korunması Kanunu’na (KVKK) uygun şekilde kişisel verilerinizi nasıl topladığımızı, işlediğimizi, sakladığımızı ve koruduğumuzu açıklamaktadır.

**Veri Sorumlusu**
[Şirket Adı] olarak, kişisel verilerinizin toplanması, işlenmesi ve korunmasından sorumlu olan veri sorumlusuyuz. İletişim için aşağıdaki bilgileri kullanabilirsiniz:
- [Şirket Adı]
- [Adres]
- [Telefon]
- [E-posta]

**Toplanan Kişisel Veriler**
Aşağıdaki türde kişisel veriler toplanmaktadır:
- Ad, soyad, iletişim bilgileri
- Kullanıcı adı ve şifre bilgileri
- IP adresi ve cihaz bilgileri

**Veri Toplama Amaçları**
Topladığımız kişisel veriler aşağıdaki amaçlarla işlenmektedir:
- Hizmet sunumu
- Kullanıcı deneyimini geliştirme
- Hukuki yükümlülüklerin yerine getirilmesi
- Pazarlama faaliyetleri

**Veri İşleme Yöntemleri**
Kişisel verileriniz, dijital ortamda ve otomatik olmayan yöntemlerle toplanabilir ve işlenebilir.

**Veri Paylaşımı**
Kişisel verileriniz, yalnızca yasal zorunluluklar veya sizin açık rızanızla üçüncü kişilerle paylaşılabilir.

**Veri Sahiplerinin Hakları**
KVKK kapsamındaki kişisel verilerinize ilişkin haklarınız şunlardır:
- Verilerinize erişim hakkı
- Verilerinizi düzeltme veya silme hakkı
- İşlemeye itiraz etme hakkı
- Veri taşınabilirliği hakkı
- Onayınızı geri çekme hakkı

**Veri Güvenliği**
Kişisel verilerinizi korumak amacıyla teknik ve idari tedbirler alıyoruz. Ancak, internet üzerinden veri iletiminde tamamen güvenlik sağlanamayabilir.

**İletişim**
Kişisel verilerinizle ilgili her türlü talep ve soru için bizimle [email@example.com] adresinden iletişime geçebilirsiniz.

',

        ]); 
    }
}
