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
              <?php generated_dynamic_sidebar("sidebar-cate"); ?>
          </div>
          <div class="col-sm-8 col-md-9">
            <div class="sort-by-section clearfix box">
              <h4 class="sort-by-title block-sm"><?php single_term_title(); ?></h4>
            </div>
              <?php
              $cat   =  get_queried_object();
              $count = $cat->count;
              $results = get_posts(
                  array(
                      'posts_per_page' => $per_page,
                      'post_type' => 'post',
                      'paged' => $page,
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'category',
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
                              <h4 class="box-title"><a href="<?php echo esc_url( $url );?>"><?php echo esc_html( get_the_title( $acc_id ) );?></a><small><?php echo (!empty(get_field("times", $acc_id))) ? get_field("times", $acc_id) : ''; ?></small></h4>
                              <p class="description fourty-space">
                                <?php
                                  $content = apply_filters('the_content', get_post_field('post_content', $acc_id));
                                  $content = wp_trim_words($content, 20, '...');
                                  echo wp_kses_post($content);
                                ?>
                              </p>
                              <div class="action">
                                <a class="button btn-small full-width" href="<?php echo esc_url( $url );?>">CHI TIẾT</a>
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