# Wordpress Theme Development

## A. Wordpress 101 Tutorials
### 10. WordPress 101 - Part 10: Filter the WP_Query with categories

- Selama masa Development jangan hapus source code jika tidak dibutuhkan cukup comment saja
- Template part memudahkan development dengan source yang sama, kita hanya perlu memanggil fungsi`get_template_part()`

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
4. Buat function start_lvl di `walker.php`
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

### 15. WordPress 101 - Part 15: Edit the menu with the Walker Class - Part 2
1. Buat function start_el di `walker.php`
```php
function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) // li a span
{
    $indent     = ($depth) ? str_repeat("\t", $depth) : "";

    $li_attributes  = "";
    $class_names    = $value = "";

    $classes    = empty( $item->classes ) ? array() : (array) $item->classes;

    $classes[]  = ($args->walker->has_children) ? "dropdown" : "";
    $classes[]  = ($item->current || $item->current_item_anchestor) ? 'active' : '';
    $classes[]  = 'menu-item-' . $item->ID;
    if ( $depth && $args->has_children) {
        $classes[] = 'dropdown-submenu';
    }

    $class_names = join( ' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr($class_names) . '" ';

    $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
    $id = strlen( $id ) ? ' id="' . esc_attr($id) . '" ' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = ! empty( $item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= ! empty( $item->target) ? ' target="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= ! empty( $item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= ! empty( $item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $attributes .= ( $args->walker->has_children ) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

    $item_output = $args->before;

    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= ( $depth == 0 && $args->walker->has_children) ? ' <b class="caret"></b></a>' : '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

}
```

### 16. WordPress 101 - Part 16: How to print the bloginfo
Fungsi `bloginfo()` adalah menampilkan data yang diperlukan di header seperti title, charset dan info lain yang diperlukan oleh sebuah halaman

1. Menambah language di html tag
```php
<html <?php language_attributes(); ?>>
```
2. Menambah meta charset
```php
<meta charset="<?php bloginfo('charset') ?>">
```
3. Membuat title menjadi dinamis
```php
<title><?php bloginfo('name') ?><?php the_title('|') ?></title>
```
4. Menambah meta description
```php
<meta name="description" content="<?php bloginfo('description'); ?>">
```
5. Menghapus Wordpress version di header tag  
 Buat function untuk menghapus wordpress version di `functions.php`
```php
function awesome_remove_version() // penamaan function bebas
{
	return '';// mengembalikan string kosong sehingga datanya tidak ada
}
add_filter('the_generator', 'awesome_remove_version');
```
Untuk parameter fungsi `bloginfo()` dan keterangannya bisa langsud baca di codex

### 17. WordPress 101 - Part 17: How to create a custom Archive and 404 page

#### A. Archive
Archive adalah halaman saat kamu mengeklik bulan dan tahun di sidebar menu atau kategori setelah mengeklik link tersebu kita diarahkan ke halaman blog, untuk menangani hal ini kita harus membuat halaman archive.
Langkah-langkah membuat halaman archive:
1. Buat file bernama `archive.php`
2. Copy semua file index dan hapus script yang ada di dalam loop while
3. di dalam while tuliskan
```php
<?php while( have_posts() ): the_post(); ?>

    <?php get_template_part('content', 'archive') ?>

<?php endwhile;?>
```
4. Buat file bernama `content-file.php` pastekan kode berikut
```php
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( sprintf('<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h1>' ); ?>
		<small>Posted on: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?>, in <?php the_category(); ?></small>
	</header>

	<div class="row">

		<?php if( has_post_thumbnail() ): ?>

			<div class="col-xs-12 col-sm-4">
				<div class="thumbnail"><?php the_post_thumbnail('medium'); ?></div>
			</div>
			<div class="col-xs-12 col-sm-8">
				<?php the_excerpt(); ?>
			</div>

		<?php else: ?>

			<div class="col-xs-12">
				<?php the_excerpt(); ?>
			</div>

		<?php endif; ?>
	</div>

</article>
```
#### B. 404 Page

404 page adalah halaman error jika user menginputkan alamat yang salah/tidak ditemukan di dalam web tersebut
Langkah-langkah Membuat 404 Page
1. Buat file bernama `404.php`
2. Pastekan kode berikut:
```php
<?php get_header(); ?>
    <div id="primary" class="container">
        <main id="main" class="site-main" role="main">
            <div class="error-404 not-found">
                <head class="page-header">
                    <h1 class="page-title">Sorry, page not found</h1>
                </head>
                <div class="page-content">
                    <h3>It looks like nothing was found at this location, maybe try one of the links below or a search?</h3>
                    <?php get_search_form()$ // menampilkan search form ?>
                    <?php the_widget('WP_Widget_Recent_Posts'); // Memanggil Recent Post Widget ?>
                    <div class="widget widget_categories">
                        <h3>Check the most used categories</h3>
                        <ul>
                            <?php
                            // membuat custom list categories
                             wp_list_categories( array(
                                 'orderby'  => 'count',
                                 'order'    => 'DESC',
                                 'show_count'   => 1,
                                 'title_li'     => '',
                                 'number'       => 5,
                             ) );
                             ?>
                        </ul>
                    </div>
                    <?php the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content"); // Memanggil Archive widget ?>
                </div>
            </div>
        </main>
    </div>
<?php get_footer(); ?>

```

### 18. WordPress 101 - Part 18: How to create Custom Post Type - Part 1

Post Type adalah custom dari post biasa digunakan untuk membuat review, portfolio dll bisa dibilang post yang khusus untuk tujuan tertentu saja berbeda dengan post yang biasa `post type` memiliki menu sendiri bisa dicustom langsung saja langkah-langkah pembuatan `Custom Post Type`

1. Buka file `function.php`
2. Buat Function `awesome_custom_post_type()` nama bisa bebas
```php
function awesome_custom_post_type()
{
    // code...
}
```
3. Di dalam function buat variabel $labels untuk custom label menu di admin panel
```php
$labels = array(
    'name'          => 'Portfolio',
    'singular_name' => 'Portfolio',
    'add_new'       => 'Add Item',
    'all_items'     => 'All Items',
    'add_new_item'  => 'Add Item',
    'edit_item'     => 'Edit Item',
    'new_item'      => 'New Item',
    'view_item'     => 'View Item',
    'search_item'   => 'Search Portfolio',
    'not_found'     => 'No Item Found',
    'not_found_in_trash' => 'No Item Found In Trash',
    'parent_item_colon'  => 'Parent Item'
);
```
4. Buat variabel $args argument untuk custom post type
```php
$args = array(
    'labels'    => $labels,
    'public'    => true,
    'query_var' => true,
    'rewrite'   => true,
    'has_archive'   => true,
    'hieararchical' => false,
    'menu_position' => 5,
    'capability_type'       => 'post',
    'publicly_queryable'    => true,
    'exclude_form_search'   => false,
    'taxonomies' => array(
        'category',
        'post_tag',
    ),
    'supports' => array(
        'title',
        'editor',
        'excerpt',
        'thumbnail',
        'revisions',
    ),
);
```
5. tambahkan `register_post_type('portfolio', $args);` di akhir fungsi
6. Aktifkan fungsi menggunakan hook tulis diluar fungsi
```php
function awesome_custom_post_type()
{
    // code...
}
add_action('init', 'awesome_custom_post_type');
```

### 19. WordPress 101 - Part 19: How to create Custom Post Type - Part 2

- isikan beberapa post di post type portfolio
- hapus page dengan nama portfolio untuk menghindari error karena memiliki url yang sama misal:
  post url: http://localhost:7000/portfolio/  
  post type url: http://localhost:7000/portfolio/wordpress-template  
- duplicate file `single.php` menjadi `single-portfolio.php` untuk menampilkan detail artikel dari post type
- Duplicate file `archive.php` menjadi `archive-portfolio.php` untuk membuat archive dari portfolio  
  archive post type url: http://localhost:7000/portfolio/  
- tidak bisa mengakses `archive post url` atau `single post type url` kamu harus mengubah settingan permalink di `Settings->Permalinks` pilih salah satu misal plain lalu kembalikan seperti semula buka kembali `single post type url` atau `archive post type url`
- Untuk membuat menunya kita bisa membuat page dengan nama yang berbeda dengan `post type` misal `Work` lalu buat file `page-portfolio-template.php` untuk membuat template page dengan isi list post type portfolio Misal:
```php
<?php

/*
	Template Name: Portfolio Template
*/

get_header(); ?>

	<?php

    $args = array('post_type' => 'portfolio', 'posts_per_page' => 3 );
    $loop = new WP_Query( $args );

	if( $loop->have_posts() ):

		while( $loop->have_posts() ): $loop->the_post(); ?>

            <?php get_template_part('content', 'archive'); ?>

		<?php endwhile;

	endif;

	?>

<?php get_footer(); ?>

```
- edit post `Work` di bagian kanan bawah di panel `Page Attributes` pada bagian `Template` pilih `Portfolio Template`
- buka tampilan wordpress dan klik menu `Work`,













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
- `next_posts_link()` Membuat Pagination Next `di blog`
- `previous_posts_link()` Membuat Pagination Next `di blog`
- `next_post_link()` Membuat Pagination Next `di single`
- `previous_post_link()` Membuat Pagination Next `di single`
- `the_posts_navigation()` Membuat Pagination dengan Numbering ada angkanya
- `the_archive_title($before, $after)` Membuat title di archive page `$before` = sebelum title `$after` = setelah title
- `the_archive_description($before, $after)` Menampilkan deskripsi dari kategori deskripsi `$before` dan `$after`  sama seperti sebelumnya
- `the_widget($widget, $instance, $args)` Memanggil widget tertentu sesuai $widget untuk paramnya bisa di lihat di [the_widget](https://codex.wordpress.org/Function_Reference/the_widget)
- `get_search_form()` Menampilkan searchform
- `wp_list_categories()` Membuat custom category

## Fungsi-Fungsi yang Digunakan di Wordpress Back End

- `add_theme_support()` menambah suport Wordpress
- `wp_enqueue_style()` menambah style di wordpress dari file `functions.php`
- `wp_enqueue_script()` menambah javascript di wordpress dari file `functions.php`
- `add_action()` hook untuk memanggil function yang telah dibuat
- `add_filter()` membuat filter dengan function
- `register_nav_menu()` membuat nav menu
- `register_sidebar()` untuk membuat sidebar widget
- `register_post_type()` membuat post type

## File yang Digunakan di Wordpress

- `index.php` file utama yang dituju saat halaman di load
- `header.php` file yang berisi header web
- `footer.php` file yang berisi footer web
- `sidebar.php` file yang berisi sidebar web
- `single.php` file yang digunakan untuk menampilkan detail dari artikel/post
- `single-{slug}.php` file yang digunakan untuk menampilkan detail dari `Post Type`
- `functions.php` file yang mengatur backend dari Wordpress
- `page-{slug}.php` file yang mereplace halaman yang memiliki slug/url yang sama
- `page-{id}.php` file yang mereplace halaman yang memiliki id yang sama
- `search.php` file yang mengatur tampilan hasil dari search artikel
- `searchform.php` file yang mereplace search form baik yang custem maupun widget
- `404.php` file yang akan tampil jika mengakses url dan halaman tidak ditemukan
- `comment.php` File yang akan menggantikan comment form
- `archive.php` File yang menangani ketika archive link diklik/category di klik
- `author.php`
