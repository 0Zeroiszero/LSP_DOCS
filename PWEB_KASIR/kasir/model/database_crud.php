<?php

class DatabaseCRUD
{
    private $database;

    /**
     * Mencari koneksi database
     * 
     * @param mysqli $database
     * @return mysqli
     */
    public function __construct(mysqli $database)
    {
        $this->database = $database;
    }

    /**
     * Create (insert into) pada database
     *
     * @param String $table adalah nama tabel
     * @param boolean $for_create_user true untuk menambah user
     * @param String ...$fields adalah post method
     * @return bool
     */
    public function create(String $table, Bool $for_create_user = false, String ...$fields)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $columns = [];
                $values  = [];

                foreach ($fields as $field) {

                    if (isset($_POST[$field])) {
                        $columns[] = $field;

                        $values[]  = mysqli_real_escape_string($this->database, $_POST[$field]);
                    }
                }

                if ($for_create_user && in_array('password', $columns)) {
                    $passwordIndex = array_search('password', $columns);

                    $values[$passwordIndex] = password_hash($values[$passwordIndex], PASSWORD_BCRYPT);
                }

                $columns_sql = implode(', ', $columns);

                $values_sql  = "'" . implode("','", $values) . "'";

                $sql = "INSERT INTO $table ($columns_sql) VALUES ($values_sql)";

                if (mysqli_query($this->database, $sql)) {
                    $_SESSION['create-success'] = '<p style="color: green;">SUCCESS</p>';
                    return true;
                } else {
                    $_SESSION['create-error'] = '<p style="color: red;">ERROR</p>';
                    return false;
                }
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Mengambil data dari database
     *
     * @param String $table adalah nama tabel
     * @param mixed $primary_key diambil dari $_GET dan harus sama dengan fields di database
     * @param String ...$fields adalah field atau kolom database
     * @return array
     */
    public function read(String $table, Mixed $primary_key, String ...$fields)
    {
        try {

            if (count($fields) > 0) {
                $columns = implode(', ', $fields);
            } else {
                $columns = '*';
            }

            if (isset($_GET[$primary_key])) {
                $sql = "SELECT $columns FROM $table WHERE $primary_key = " . $_GET[$primary_key];
            } else {

                $sql = "SELECT $columns FROM $table";
            }

            $result = mysqli_query($this->database, $sql);

            if (!$result) {

                throw new Exception("Gagal baca data: " . mysqli_error($this->database));
            }

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            return $data;
        } catch (Exception $e) {

            return $e;
        }
    }


    /**
     * Mengupdate data
     *
     * @param String $table adalah nama tabel
     * @param Mixed $primary_key diambil dari metode get, mis. id atau user_id atau detail_id
     * @param String ...$fields adalah baris atau kolom
     * 
     */
    public function update(String $table, Mixed $primary_key, String ...$fields)
    {
        try {
            $for_users = (isset($_GET['from']) && $_GET['from'] === 'user');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (!isset($_GET[$primary_key])) {
                    throw new Exception("Primary key '{$primary_key}' tidak ditemukan di \$_GET");
                }
                
                $pkValue = $_GET[$primary_key];

                $setParts = [];

                foreach ($fields as $field) {
                    if (isset($_POST[$field])) {
                        $value = $_POST[$field];

                        if ($for_users && $field === 'password') {
                            $value = password_hash($value, PASSWORD_BCRYPT);
                        }

                        $setParts[] = "{$field} = '{$value}'";
                    }
                }

                if (empty($setParts)) {
                    throw new Exception("Tidak ada field yang ditemukan untuk di-update");
                }

                $setClause = implode(', ', $setParts);

                $sql = "UPDATE {$table} SET {$setClause} WHERE {$primary_key} = '{$pkValue}'";

                $result = mysqli_query($this->database, $sql);
                if ($result) {
                    return true;
                } else {
                    throw new Exception("Gagal update data: " . mysqli_error($this->database));
                }
            }
        } catch (Exception $e) {

            return $e;
        }
    }

    /**
     * Menghapus value database
     *
     * @param String $table nama tabel
     * @param Mixed $primary_key diambil dari $_GET dan harus sama dengan fields di database
     * @return void
     */
    public function delete(String $table, Mixed $primary_key)
    {
        try {

            if (!isset($_GET[$primary_key])) {
                throw new Exception("Primary key '{$primary_key}' tidak ditemukan di \$_GET");
            }

            $pkValue = $_GET[$primary_key];

            $sql = "DELETE FROM {$table} WHERE {$primary_key} = '{$pkValue}'";

            $result = mysqli_query($this->database, $sql);
            if ($result) {
                return true;
            } else {
                throw new Exception("Gagal menghapus data: " . mysqli_error($this->database));
            }
        } catch (Exception $e) {

            return $e;
        }
    }

    /**
     * Menghitung data pada satu buah kolom atau baris
     *
     * @param String $table nama tabel
     * @param String $field kolom atau baris
     * 
     */
    public function count_data(String $table, String $field)
    {
        try {
            $sql = "SELECT $field FROM $table";

            $result = mysqli_query($this->database, $sql);
            if (!$result) {
                throw new Exception("Gagal menghitung data: " . mysqli_error($this->database));
            }

            $count = mysqli_num_rows($result);

            return $count;
        } catch (Exception $e) {

            return $e;
        }
    }
}
