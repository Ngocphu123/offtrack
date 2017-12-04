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
                <div class="cruise-list image-box style3 cruise listing-style1">
                  <div class="row  add-clearfix">
                    <?php
                      foreach($results as $result):
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
                              <div data-placement="bottom" data-toggle="tooltip" class="five-stars-container" data-original-title="" title="">
                                <span style="width:80%" class="five-stars"></span>
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