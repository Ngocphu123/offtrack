<?php
/**
* Tour Search Template
 */

get_header();

global $trav_options, $before_article, $after_article, $tour_list, $current_view, $date_from, $date_to, $language_count;

$order_array = array( 'ASC', 'DESC' );
$order_by_array = array(
    'name' => 'post_title',
    /*'price' => 'cast(min_price as unsigned)'*/
);
$order_defaults = array(
    'name' => 'ASC',
    'price' => 'ASC'
);

$s = isset($_REQUEST['s']) ? sanitize_text_field( $_REQUEST['s'] ) : '';
$min_price = ( isset( $_REQUEST['min_price'] ) && is_numeric( $_REQUEST['min_price'] ) ) ? sanitize_text_field( $_REQUEST['min_price'] ) : 0;
$max_price = ( isset( $_REQUEST['max_price'] ) && ( is_numeric( $_REQUEST['max_price'] ) || ( $_REQUEST['max_price'] == 'no_max' ) ) ) ? sanitize_text_field( $_REQUEST['max_price'] ) : 'no_max';
$order_by = ( isset( $_REQUEST['order_by'] ) && array_key_exists( $_REQUEST['order_by'], $order_by_array ) ) ? sanitize_text_field( $_REQUEST['order_by'] ) : 'name';
$order = ( isset( $_REQUEST['order'] ) && in_array( $_REQUEST['order'], $order_array ) ) ? sanitize_text_field( $_REQUEST['order'] ) : 'ASC';
$diadiem = ( isset( $_REQUEST['diadiem'] ) ) ? ( is_array( $_REQUEST['diadiem'] ) ? $_REQUEST['diadiem'] : array( $_REQUEST['diadiem'] ) ):array();
$current_view = isset( $_REQUEST['view'] ) ? sanitize_text_field( $_REQUEST['view'] ) : 'list';
$page = ( isset( $_REQUEST['page'] ) && ( is_numeric( $_REQUEST['page'] ) ) && ( $_REQUEST['page'] >= 1 ) ) ? sanitize_text_field( $_REQUEST['page'] ):1;
$per_page = ( isset( $trav_options['tour_posts'] ) && is_numeric($trav_options['tour_posts']) )?$trav_options['tour_posts']:12;

$date_from = empty( $_REQUEST['date_from'] ) || trav_sanitize_date( $_REQUEST['date_from'] ) == '' ? date( trav_get_date_format('php') ) : $_REQUEST['date_from'];
$date_to = empty( $_REQUEST['date_to'] ) || trav_sanitize_date( $_REQUEST['date_to'] ) == '' || trav_strtotime( $date_from ) > trav_strtotime( $_REQUEST['date_to'] ) ? date( trav_get_date_format('php'), trav_strtotime( $date_from ) + 86400 * 30 ) : $_REQUEST['date_to'];

if ( is_tax() ) {
    $queried_taxonomy = get_query_var( 'taxonomy' );
    $queried_term = get_query_var( 'term' );
    $queried_term_obj = get_term_by('slug', $queried_term, $queried_taxonomy);
    if ( $queried_term_obj ) {
        if ( ( $queried_taxonomy == 'diadiem' ) && ( ! in_array( $queried_term_obj->term_id, $diadiem ) ) ) $diadiem[] = $queried_term_obj->term_id;
    }
}
$tour_list = trav_tour_get_search( array( 's'=>$s, 'order_by'=>$order_by_array[$order_by], 'order'=>$order, 'last_no'=>( $page - 1 ) * $per_page, 'per_page'=>$per_page, 'min_price'=>$min_price, 'diadiem'=>$diadiem ) );

$count = trav_tour_get_search_count( array('diadiem'=>$diadiem ) );
$before_article = '';
$after_article = '';

?>

<!--<section id="content">
    <div class="container">
        <div id="main">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="sort-by-section clearfix box">
                        <div class="col-sm-4 col-md-4">
                        <h4 class="search-results-title"><i class="soap-icon-search"></i><b><?php /*echo esc_html( $count ); */?></b> <?php /*_e( 'results found.', 'trav' ) */?></h4>
                        </div>

                        <div class="col-sm-8 col-md-8">
                        <h4 class="sort-by-title block-sm"><?php /*_e( 'Sort results by:', 'trav' ); */?></h4>
                        <ul class="sort-bar clearfix block-sm">
                            <?php
/*                                foreach( $order_by_array as $key => $value ) {
                                    $active = '';
                                    $def_order = $order_defaults[ $key ];

                                    if ( $key == $order_by ) {
                                        $active = ' active';
                                        $def_order = ( $order == 'ASC' )?'DESC':'ASC';
                                    }

                                    echo '<li class="sort-by-' . esc_attr( $key . $active ) . '"><a class="sort-by-container" href="' . esc_url( add_query_arg( array( 'order_by' => $key, 'order' => $def_order ) ) ) . '"><span>' . esc_html( __( $key, 'trav' ) ) . '</span></a></li>';
                                }
                            */?>
                        </ul>

                        <ul class="swap-tiles clearfix block-sm">
                            <?php
/*                                $views = array(
                                    'list' => __( 'List View', 'trav' ),
                                    'grid' => __( 'Grid View', 'trav' ),
                                    // 'block' => __( 'Block View', 'trav' )
                                );
                                $params = $_GET;

                                foreach( $views as $view => $label ) {
                                    $active = ( $view == $current_view )?' active':'';
                                    echo '<li class="swap-' . esc_attr( $view . $active ) . '">';
                                    echo '<a href="' . esc_url( add_query_arg( array( 'view' => $view ) ) ) . '" title="' . esc_attr( $label ) . '"><i class="soap-icon-' . esc_attr( $view ) . '"></i></a>';
                                    echo '</li>';
                                }
                            */?>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php /*if ( ! empty( $tour_list ) ) { */?>
                    <div class="tour-list list-wrapper">
                        <?php /*if ( $current_view == 'grid' ) {
                            //echo '<div class="row image-box tour listing-style1 add-clearfix">';
                            echo '<div class="tour-packages listing-style1 row add-clearfix image-box">';
                            $before_article = '<div class="col-sm-6 col-md-4">';
                            $after_article = '</div>';
                        } elseif ( $current_view == 'block' ) {
                            echo '<div class="tour-packages listing-style2 row add-clearfix image-box">';
                            $before_article = '<div class="col-sm-6 col-md-4">';
                            $after_article = '</div>';
                        } else {
                            echo '<div class="tour-packages listing-style3 image-box">';
                            $before_article = '';
                            $after_article = '';
                        }

                        trav_get_template( 'tour-list.php', '/templates/tour/'); */?>

                    </div>
                    <?php
/*                    if ( ! empty( $trav_options['ajax_pagination'] ) ) {
                        if ( count( $tour_list ) >= $per_page ) {
                            */?>
                            <a href="<?php /*echo esc_url( add_query_arg( array( 'page' => ( $page + 1 ) ) ) ); */?>" class="uppercase full-width button btn-large btn-load-more-accs" data-view="<?php /*echo esc_attr( $current_view ); */?>" data-search-params="<?php /*echo esc_attr( http_build_query( $_GET, '', '&amp;' ) ) */?>"><?php /*echo __( 'load more listing', 'trav' ) */?></a>
                            <?php
/*                        }
                    } else {
                        unset( $_GET['page'] );

                        $pagenum_link = strtok( $_SERVER["REQUEST_URI"], '?' ) . '%_%';
                        $total = ceil( $count / $per_page );
                        $args = array(
                            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
                            'total' => $total,
                            'format' => '?page=%#%',
                            'current' => $page,
                            'show_all' => false,
                            'prev_next' => true,
                            'prev_text' => __('Previous', 'trav'),
                            'next_text' => __('Next', 'trav'),
                            'end_size' => 1,
                            'mid_size' => 2,
                            'type' => 'list',
                            'add_args' => $_GET,
                        );
                        echo paginate_links( $args );
                    }
                    */?>

                </div>
                <?php /*} else { */?>
                    <div class="travelo-box"><?php /*_e( 'No available tours', 'trav' );*/?></div>
                    <?php /*} */?>
                </div>
            </div>
        </div>
    </div>
</section>-->

<section id="content">
        <div class="container">
            <div id="main">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="sort-by-section clearfix box">
                            <div class="col-sm-4 col-md-4">
                                <h4 class="search-results-title"><i class="soap-icon-search"></i><b><?php echo esc_html( $count ); ?></b> <?php _e( 'results found.', 'trav' ) ?></h4>
                            </div>

                            <div class="col-sm-8 col-md-8">
                                <h4 class="sort-by-title block-sm"><?php _e( 'Sort results by:', 'trav' ); ?></h4>
                                <ul class="sort-bar clearfix block-sm">
                                    <?php
                                    foreach( $order_by_array as $key => $value ) {
                                        $active = '';
                                        $def_order = $order_defaults[ $key ];

                                        if ( $key == $order_by ) {
                                            $active = ' active';
                                            $def_order = ( $order == 'ASC' )?'DESC':'ASC';
                                        }

                                        echo '<li class="sort-by-' . esc_attr( $key . $active ) . '"><a class="sort-by-container" href="' . esc_url( add_query_arg( array( 'order_by' => $key, 'order' => $def_order ) ) ) . '"><span>' . esc_html( __( $key, 'trav' ) ) . '</span></a></li>';
                                    }
                                    ?>
                                </ul>

                                <ul class="swap-tiles clearfix block-sm">
                                    <?php
                                    $views = array(
                                        'list' => __( 'List View', 'trav' ),
                                        'grid' => __( 'Grid View', 'trav' ),
                                        // 'block' => __( 'Block View', 'trav' )
                                    );
                                    $params = $_GET;

                                    foreach( $views as $view => $label ) {
                                        $active = ( $view == $current_view )?' active':'';
                                        echo '<li class="swap-' . esc_attr( $view . $active ) . '">';
                                        echo '<a href="' . esc_url( add_query_arg( array( 'view' => $view ) ) ) . '" title="' . esc_attr( $label ) . '"><i class="soap-icon-' . esc_attr( $view ) . '"></i></a>';
                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <?php generated_dynamic_sidebar("sidebar-cate"); ?>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <?php if ( ! empty( $tour_list ) ) { ?>
                            <div class="cruise-list image-box style3 cruise listing-style1">
                                <div class="row  add-clearfix">
                                    <?php
                                    foreach($tour_list as $result):
                                        $acc_id = trav_acc_clang_id( $result->ID );
                                        $url = esc_url(get_permalink( $acc_id ));
                                        ?>
                                        <div class="col-sm-6 col-md-4">
                                            <article class="box">
                                                <figure>
                                                    <a title="<?php _e( 'View Photo Gallery', 'trav' ); ?>" class="hover-effect " data-post_id="<?php echo esc_attr( $acc_id );?>" href="<?php echo esc_url( $url );?>"><?php echo get_the_post_thumbnail( $acc_id, 'gallery-thumb' ); ?></a>
                                                </figure>
                                                <div class="details">
                            <span class="price">
                              <?php
                              $html_price = '';
                              if (get_field("prices", $acc_id)) {
                                  $html_price .= '<small>Giá Chỉ </small>';
                                  $html_price .= number_format_i18n(get_field("prices", $acc_id)) . ' vnđ';
                              } else {
                                  $html_price .= '<small>Giá</small>';
                                  $html_price .= 'Liên hệ';
                              }
                              echo $html_price;
                              ?>
                            </span>
                                                    <h4 class="box-title"><a href="<?php echo esc_url( $url );?>"><?php echo esc_html( get_the_title( $acc_id ) );?></a><small><?php echo (!empty(get_field("times", $acc_id))) ? get_field("times", $acc_id) : ''; ?></small></h4>
                                                    <div class="feedback">
                                                        <?php
                                                        $star = REVIEW_POINT_DEFAULT;
                                                        $reviews = get_field('reviews', $acc_id);
                                                        if (!empty($reviews)) {
                                                            $star = ONE_STAR_POINT_ * intval($reviews);
                                                        }
                                                        ?>
                                                        <div data-placement="bottom" data-toggle="tooltip" class="five-stars-container" data-original-title="" title="">
                                                            <span style="width:<?php echo $star?>%" class="five-stars"></span>
                                                        </div>
                                                        <!--<span class="review">1221 View</span>-->
                                                    </div>
                                                    <div class="row time">
                                                        <div class="date col-xs-6">
                                                            <i class="soap-icon-clock yellow-color"></i>
                                                            <div>
                                                                <span class="skin-color">Khởi Hành</span><br><?php echo (!empty(get_field("itinerary", $acc_id))) ? get_field("itinerary", $acc_id) : ''; ?>
                                                            </div>
                                                        </div>
                                                        <div class="departure col-xs-6">
                                                            <i class="soap-icon-departure yellow-color"></i>
                                                            <div>
                                                                <span class="skin-color">Địa Điểm</span><br><?php echo (!empty(get_field("locations", $acc_id))) ? get_field("locations", $acc_id) : ''; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="description fourty-space">
                                                        Phương Tiện: <span class="skin-color">
                                <?php
                                $field = get_field_object('transportation', $acc_id);
                                $transportations = $field['value'];
                                if ($transportations) {
                                    $phuong_tien = '';
                                    foreach ($transportations as $pt):
                                        $phuong_tien .= ', '.$field['choices'][ $pt ];
                                    endforeach;
                                    echo ltrim($phuong_tien,',');
                                }
                                ?></span></p>
                                                    <div class="action">
                                                        <a class="button btn-small full-width" href="<?php echo esc_url( $url );?>">XEM TOUR</a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <?php
                                $pagenum_link = strtok( $_SERVER["REQUEST_URI"], '?' ) . '%_%';
                                $total = ceil( $count / $per_page );
                                $args = array(
                                    'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
                                    'total' => $total,
                                    'format' => '?page=%#%',
                                    'current' => $page,
                                    'show_all' => false,
                                    'prev_next' => true,
                                    'prev_text' => __('Previous', 'trav'),
                                    'next_text' => __('Next', 'trav'),
                                    'end_size' => 1,
                                    'mid_size' => 2,
                                    'type' => 'list',
                                    //'add_args' => $_GET,
                                );
                                echo paginate_links( $args );
                                ?>
                            </div>
                        <?php } else { ?>
                            <div class="travelo-box"><?php _e( 'No available accommodations', 'trav' );?></div>
                        <?php } ?>
                        <?php //} //End loop ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

get_footer();