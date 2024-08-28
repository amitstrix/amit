LINK STYLESHEET IN HEADER (WP)

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/style.css'?>">

/////////////////////////////////////

Woocommerce category call
<?php 
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 10, // Number of products to retrieve
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'accessories', // Replace with your category slug
        ),
    ),
);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) {
        $loop->the_post();
        global $product;

        echo '<div class="product">';
       // echo '<h2>' . $product->get_name() . '</h2>'; // Display the product name
        echo '<img src="' . wp_get_attachment_url( $product->get_image_id() ) . '" alt="' . $product->get_name() . '"/>'; // Display the product image
        echo '<p>' . wc_price( $product->get_price() ) . '</p>'; // Display the product price
        echo '</div>';
    }
} else {
    echo 'No products found';
}

// Restore original Post Data
wp_reset_postdata();
?>


///////////////////////////////////////////////////////////////////////////////////////


SINGLE PRODUCT-PAGE (WOOCOMMERCE)

<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>


    <header class="page-banner product-header container-fluid">
        <div class="container">
            <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                <?php echo woocommerce_template_single_title(); ?>
            <?php endif; ?>
            <?php woocommerce_breadcrumb(); ?>
            <?php do_action('woocommerce_archive_description'); ?>
        </div>
    </header>

    <section class="single-product container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <?php
                        /**
                         * woocommerce_sidebar hook.
                         *
                         * @hooked woocommerce_get_sidebar - 10
                         */
                        do_action( 'woocommerce_sidebar' );
                    ?>
                </div>
                <div class="col-8">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'single-product' ); ?>

                    <?php endwhile; // end of the loop. ?>
                </div>
            </div>
        </div>
    </section>

<?php get_footer( 'shop' ); ?>




///////////////////////////////////////////////////////////////////////////////////////////////////////

SLIDER PRODUCT (WOOCOMMERCE)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.0/slick-theme.min.css" integrity="sha512-thJaDRSHpaG+2IBMnToE9jNFJ9e/UVfhT/5FXynKw2aHuMrOq7n/1bQBJsKPvHqXCtsfzK0ZPayjvOuM4oXtEg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="main-wapper-silder">
        <div class="main-slider">
            <div>
                <div class="slider-inner-main">
                    <div class="slides-one-way-one">
                        <?php
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 10, // Number of products to retrieve
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'accessories', // Replace with your category slug
        ),
    ),
);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) {
        $loop->the_post();
        global $product;

        echo '<div class="product">';
        echo '<a href="' . get_permalink() . '">'; // Link to the custom single product page
        echo '<img src="' . wp_get_attachment_url( $product->get_image_id() ) . '" alt="' . $product->get_name() . '"/>'; // Display the product image
      //  echo '<h2>' . $product->get_name() . '</h2>'; // Display the product name
        echo '<p>' . wc_price( $product->get_price() ) . '</p>'; // Display the product price
        echo '</a>';
        echo '</div>';
    }
} else {
    echo 'No products found';
}

// Restore original Post Data
wp_reset_postdata();
?>
                    </div>
                </div>
            </div>
        </div>
    </div>



 <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.0/slick.min.js" integrity="sha512-NiN2VC4cbtZR7LCwx4RGDb5/EYwZX6BI/zKBmBrjP388hfzrI+ZrMauhcEHO1mwmTYttqmSWtEzvoNXigaYY2Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $('.slides-one-way-one').slick({
  centerMode: true,
  slidesToShow: 3,
  autoplay:true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
</script>

<?php get_footer(); 


