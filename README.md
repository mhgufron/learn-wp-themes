# Wordpress Theme Development

## A. Wordpress 101 Tutorials### 10. WordPress 101 - Part 10: Filter the WP_Query with categoriesCatatan Belajar- Selama masa Development jangan hapus source code jika tidak dibutuhkan cukup comment saja- Template part memudahkan development dengan source yang sama, kita hanya perlu memanggil fungsi`get_template_part()`

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

### 11. WordPress 101 - Part 11: The single.php file, tags, edit links and comment template

Catatan Belajar

- `single.php` adalah file yang digunakan untuk menampilkan detail artikel dari blog.
- `single.php` sama seperti index harus di include header dan footernya
-

### 14. WordPress 101 - Part 14: Edit the menu with the Walker Class - Part 1

Terkadang ada menu yang memiliki submenu dan itu akan terlihat jelek. Untuk menangani hal ini kita yang kita perlukan adalah walker class. untuk memuatnya kita dianjurkan untuk membuat file baru dan mengincludnya di `function.php`
Langkah-Langkah Membuat Walker Class

1. Buat class bebas dengan extends Walker_Nav_Menu
```php
class Walker_Nav_Primary extends Walker_Nav_menu
{
    # code...
}
```
2. Didalam class buat function `start_lvl()`, `start_el()`, `end_el()`, `end_lvl()`
3. Contoh kode
```php
function start_lvl() // ul
{
    # code...
}

function start_el() // li a span
{
    # code...
}

function end_el() // closing li a span
{
    # code...
}

function end_lvl() // closing ul
{
    # code...
}
```
4. Buat function start_lvl
```php
function start_lvl( &$output, $depth ) // ul
{
    $indent     = str_repeat("/t", $depth);
    $submenu    = ($depth > 0) ? " sub-menu" : "";
    $output     .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
}
```
5. Tambahkan array walker di `header.php` cari `wp_nav_menu()`
```php
wp_nav_menu(
    array(
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'nav navbar-nav navbar-right',
        'walker'    => new Walker_Nav_Primary(), // tambah kan script disini
    )
);
```





## Fungsi-Fungsi yang Digunakan di Wordpress Front End

- `get_header()` menginclude file header.php
- `get_footer()` menginclude file footer.php
- `get_sidebar()` menginclude file sidebar.php
- `get_template_part()` menginclude file sesuai parameter  
  - `get_template_part('content')` include file content
  - `get_template_part('content','featured')` include file content-featured.php  
- `get_template_directory_uri()` url dari tema wordpress
- `have_posts()` Untuk mengecek apakah ada post di Wordpress
- `has_post_thumbnail()` Untuk mengecek apakah ada featured

## Fungsi-Fungsi yang Digunakan di Wordpress Back End

- `add_theme_support()` menambah suport Wordpress
- `wp_enqueue_style()` menambah style di wordpress dari file `functions.php`
- `wp_enqueue_script()` menambah javascript di wordpress dari file `functions.php`
- `add_action()` hook untuk memanggil function yang telah dibuat
- `register_nav_menu()` membuat nav menu
- `register_sidebar()` untuk membuat sidebar widget

## File yang Digunakan di Wordpress

- `index.php` file utama yang dituju saat halaman di load
- `header.php` file yang berisi header web
- `footer.php` file yang berisi footer web
- `sidebar.php` file yang berisi sidebar web
- `single.php` file yang digunakan untuk menampilkan detail dari artikel/post
- `functions.php` file yang mengatur backend dari Wordpress
- `page-{slug}.php` file yang mereplace halaman yang memiliki slug/url yang sama
- `page-{id}.php` file yang mereplace halaman yang memiliki id yang sama
- `search.php` file yang mengatur tampilan hasil dari search artikel
- `searchform.php` file yang mereplace search form baik yang custem maupun widget
- `404.php` file yang akan tampil jika mengakses url dan halaman tidak ditemukan
- `comment.php` File yang akan menggantikan comment form
- `archive.php`
- `author.php`
