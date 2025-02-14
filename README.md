# PWEB CRUD  

Membuat Website Kasir
------------



| FITUR  | ADMINISTRATOR  | PETUGAS  |
| ------------ | ------------ | ------------ |
| LOGIN  | YA  | YA  |
| LOGOUT  |  YA | YA  |
| REGISTRASI  | YA  | -  |
| PENDATAAN BARANG  | YA  | YA  |
|  PEMBELIAN | -  | -  |
|  STOK BARANG | YA  | YA  |

## DOKUMENTASI PWEB

folder: `model/`

### class DatabaseCRUD
```php
class DatabaseCRUD::__construct();
```
Mencari koneksi database
@param mysqli $database
@return mysqli

```php
DatabaseCRUD::create();
```
Create (insert into) pada database
@param String $table adalah nama tabel
@param boolean $for_create_user true untuk menambah user
@param String ...$fields adalah post method
@return bool

```php
DatabaseCRUD::read();
```
Mengambil data dari database
@param String $table adalah nama tabel
@param mixed $primary_key diambil dari $_GET dan harus sama dengan fields di database
@param String ...$fields adalah field atau kolom database
@return array

```php
DatabaseCRUD::update();
```
Mengupdate data
@param String $table adalah nama tabel
@param Mixed $primary_key diambil dari metode get, mis. id atau user_id atau detail_id
@param String ...$fields adalah baris atau kolom

```php
DatabaseCRUD::delete();
```
Menghapus value database
@param String $table nama tabel
@param Mixed $primary_key diambil dari $_GET dan harus sama dengan fields di database
@return void

```php
DatabaseCRUD::count_data();
```
Menghitung data pada satu buah kolom atau baris
@param String $table nama tabel
@param String $field kolom atau baris

### class LoginValidator
```php
LoginValidator::__construct();
```
Mencari koneksi database
@param mysqli $database
@return mysqli

```php
LoginValidator::validate();
```
Validasi login dengan username dan password
@param String $username
@param String $password
@return bool

```php
LoginValidator::check_login_status();
```
true jika user telah login false jika belum
@param array $session - sesi dari session_start
@return bool

## Dokumentasi Java
Menggunakan CRUD untuk staff_kasir

folder: `staff_kasir`