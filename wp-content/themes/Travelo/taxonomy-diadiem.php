<?php
/**
 * Diadiem taxonomy template
 */

get_header();
global $trav_options;
$page = (isset($_REQUEST[ 'page' ]) && (is_numeric($_REQUEST[ 'page' ])) && ($_REQUEST[ 'page' ] >= 1)) ? sanitize_text_field($_REQUEST[ 'page' ]) : 1;
$per_page = (isset($trav_options[ 'tour_posts' ]) && is_numeric($trav_options[ 'tour_posts' ])) ? $trav_options[ 'tour_posts' ] : 12;
?>

  <section id="content">
    <div class="container">
      <div id="main">
        <div class="row">
          <div class="col-sm-4 col-md-3">
            <div class="toggle-container style1 filters-container">
              <?php
              $terms = get_terms(array(
                  'taxonomy'   => 'diadiem',
                  'hide_empty' => false,
                  'orderby'    => 'id'
              ));
              ?>
                <div class="panel style1 arrow-right">
                    <?php if (!empty($terms)):
                        foreach ($terms as $term):
                            ?>
                          <h4 class="panel-title"><a href="<?php echo get_term_link($term); ?>" class="collapsed"><?php echo $term->name ?></a></h4>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>

            </div>
          </div>
          <div class="col-sm-8 col-md-9">
            <div class="sort-by-section clearfix box">
              <h4 class="sort-by-title block-sm"><?php single_term_title(); ?></h4>
            </div>
              <?php
              $cat   =  get_queried_object();
              $count = $cat->count;
             // foreach ( $categories as $cat ) {
// here's my code for getting the posts for custom post type

              $results = get_posts(
                  array(
                      'posts_per_page' => $per_page,
                      'post_type' => 'tour',
                      'paged' => $page,
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'diadiem',
                              'field' => 'term_id',
                              'terms' => $cat->term_id,
                          )
                      )
                  )
              );
              ?>
              <?php if ( ! empty( $results ) ) { ?>
                <div class="hotel-list list-wrapper">
                  <div class="row image-box hotel listing-style1 add-clearfix">
                    <?php
                      foreach($results as $result):
                        $acc_id = trav_acc_clang_id( $result->ID );
                        $avg_price = get_post_meta( $acc_id, 'trav_accommodation_avg_price', true );
                        $review = get_post_meta( trav_acc_org_id( $acc_id ), 'review', true );
                        $review = ( ! empty( $review ) )?round( $review, 1 ):0;
                        $brief = get_post_meta( $acc_id, 'trav_accommodation_brief', true );
                        if ( empty( $brief ) ) {
                            $brief = apply_filters('the_content', get_post_field('post_content', $acc_id));
                            $brief = wp_trim_words( $brief, 20, '' );
                        }
                        $loc = get_post_meta( $acc_id, 'trav_accommodation_loc', true );
                        $url = esc_url(get_permalink( $acc_id ));
                    ?>
                      <div class="col-sm-6 col-md-4">
                        <article class="box">
                          <figure>
                            <a title="<?php _e( 'View Photo Gallery', 'trav' ); ?>" class="hover-effect popup-gallery" data-post_id="<?php echo esc_attr( $acc_id );?>" href="#"><?php echo get_the_post_thumbnail( $acc_id, 'gallery-thumb' ); ?></a>
                          </figure>
                          <div class="details">
                  <span class="price">
                      <small><?php _e( 'avg/night', 'trav' ) ?></small><?php echo esc_html( trav_get_price_field( $avg_price ) ); ?>
                  </span>
                    <h4 class="box-title"><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_title( $acc_id ) );?></a><?php echo trav_acc_get_star_rating( $acc_id ); ?><small><?php echo esc_html( trav_acc_get_city( $acc_id ) . ' ' . trav_acc_get_country( $acc_id ) ); ?></small></h4>
                    <div class="feedback">
                      <div data-placement="bottom" data-toggle="tooltip" class="five-stars-container" title="<?php echo esc_attr( $review . ' ' . __( 'stars', 'trav' ) ) ?>"><span style="width: <?php echo esc_html( $review / 5 * 100 ) ?>%;" class="five-stars"></span></div>
                      <span class="review"><?php echo esc_html( trav_get_review_count( $acc_id ) . ' ' .  __('reviews', 'trav') ); ?></span>
                    </div>
                    <p class="description"><?php echo wp_kses_post( $brief ); ?></p>
                    <div class="action">
                      <a title="<?php _e( 'View Detail', 'trav' ); ?>" class="button btn-small" href="<?php echo esc_url( $url ); ?>"><?php _e( 'SELECT', 'trav' ); ?></a>
                      <a title="<?php _e( 'View On Map', 'trav' ); ?>" class="button btn-small yellow popup-map" href="#" data-box="<?php echo esc_attr( $loc ) ?>"><?php _e( 'VIEW ON MAP', 'trav' ); ?></a>
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