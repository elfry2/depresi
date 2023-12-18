# Depresi
Sistem pakar skrining/diagnosis awal tingkat depresi yang saya kembangkan untuk keperluan skripsi. Menggunakan _forward chaining_ terhadap kemunculan gejala, total gejala yang muncul, dan skor frekuensi kemunculan gejala sebagai metode inferensi; dan _naive bayes_ sebagai metode perhitungan probabilitas.

![image](https://user-images.githubusercontent.com/47256917/224542705-9163a030-b322-4709-86da-3b108c12fa16.png)
## Instalasi
Buat basis data, salin berkas ```.env.example``` dan namai sebagai ```.env```, sesuaikan isi berkas ```.env``` dengan konfigurasi lingkugan anda, lalu eksekusi perintah
```bash
composer update && npm install && npm run build && php artisan migrate:fresh --seed && php artisan key:generate && php artisan storage:link
```
## Penggunaan
Eksekusi perintah
```bash
php artisan serve
```
dan kunjungi http://localhost:8000 (atau _port_ manapun yang digunakan ```artisan```) di _browser_ anda.