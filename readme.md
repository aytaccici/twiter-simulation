# Twitter Api

Kullanılanlar

  - Laravel 6
  - Mysql
  - Swagger
  - Larastan

 
### BILGILENDIRME
Proje Docker Containerlari olarak ayağa kaldırabilir. Container ayağa kalktığında üç adet container olusasacak ve aşağıdaki isimleri alacaklar
  - Nginx Sunucu : webserver
  - Laravel Application  : app
  - Mysql : db

Uygulamayı docker ile containerize etmeden önce env.example dosyasınının adını .env olarak değiştirin. 

DB Ayarları şu şekilde olmalı


```sh

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=app
DB_USERNAME=root
DB_PASSWORD=aDuaCAL4rUE5yMeVlAb9uMUjxw13pdNJ

```

Mail gönderimi için mailtrap kullandım.Buraya kendi Mailtrap bilgilerinizi girebilirsiniz.

```sh

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=7af7d415d37a00
MAIL_PASSWORD=ba50c272806935
MAIL_ENCRYPTION=tls

```


Uygulamayı ayağa kaldırmak için aşağıdaki komutları verebilirsiniz. db:seed komutu ile örnek userlar db oluşturulacaktır.


### INSTALLATION

```sh
$ docker-compose up -d
$ docker-compose exec app php artisan migrate
$ docker-compose exec app php artisan db:seed
```

Eğer Nginx sunucunun yayın yapacağı portları değişrtirmek isterseniz gerekli değişikşikleri docker-compose.yaml dosyasından yapabilirsiniz.
PHP ve NGINX Ayarları için proje ana dizinindeki  : php,nginx klasorlerinden yönetilmektedir Docker Compose ayarları buradan alır. 


### SWAGGER DÖKÜMANI ÜRETME

```php

docker-compose exec app php artisan l5-swagger:generate
```
komutunu vererek swagger dökümanını üretebilirsiniz. Eğer docker kullanarak projeyi ayağa kaldırdıysanız http://0.0.0.0:10080/api/documentation URL'inde Swagger dökümantasyonu oluşacaktır.


### TEST DÖKÜMANI ÜRETME

```sh
   vendor/bin/phpunit 
```
komutunu vererek uygulama testleri koşturabilirsiniz. Dikkat çok sık yapıldığında Mock Api hizmetini sağladığımız sağlayacı Too Many Reqest hatası ile isteği kesiyor.



### STATİK KOD ANALİZİ

Statik kod analizi için Larastan kütüphanesi kullanıldı.


```sh
./vendor/bin/phpstan analyse --memory-limit=2G

````

Komutu verilerek statik kod analizi yapılabilir

License
----

MIT

