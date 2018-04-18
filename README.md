# Wordpress Theme Development

## A. Wordpress 101 Tutorials

### 1. WordPress 101 - Part 10: Filter the WP_Query with categories

Catatan Belajar
- Selama masa Development jangan hapus source code jika tidak dibutuhkan cukup comment saja

- Template part memudahkan development dengan source yang sama, kita hanya perlu memanggil fungsi
`get_template_part()`

```php
$args = array(
    'type' => 'post',
    'posts_per_page' => 3, // Jumlah post yang tampil
    'category__in' => array( 8, 10, 11 ), // kategori yang ingin di tampilkan
    'category__not_in' => array( 9 ), // selain kategori yang memiliki id di dalam array tidak ditampilkan
);
$lastBlog = new WP_Query($args);
```
- Cara menampilkan lates post per kategori
    1. Buat perulangan category id
    2. Didalam perulangan buat array $args seperti sebelumnya
     - 'type' => 'post',
     - 'posts_per_page' => 1,
     - 'category__in' => $cat_id,
     - 'category__not_in' => array( 9 ),
    3. Contoh Code
    ```php
    $categories = array( 8, 10, 11 ); //kategori id yang ingin ditampilkan
    foreach ($categories as $category) :

        $args = array(
            'type' => 'post',
            'posts_per_page' => 1,
            'category__in' => $category->term_id,
            'category__not_in' => array( 9 ),
        );
        $lastBlog = new WP_Query($args);

    endforeach;
    ```
- Nested Looping adalah looping didalam looping, hal ini bisa memberatkan server jika data yang di load banyak, jika datanya banyak lebih baik jangan digunakan
