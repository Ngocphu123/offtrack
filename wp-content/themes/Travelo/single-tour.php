<?php
/*
 * Single Tour Page Template
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();

		//init variables
		$tour_id = get_the_ID();
		// add to user recent activity
		trav_update_user_recent_activity( $tour_id ); ?>

		<section id="content">
			<div class="container tour-detail-page">
				<div class="row">
					<div id="main" class="col-sm-8 col-md-9">
						<div <?php post_class(); ?>>
							<div class="image-box">
								<?php trav_post_gallery( $tour_id ) ?>
							</div>

							<div id="tour-details" class="travelo-box">
                <div class="intro2 small-box border-box table-wrapper hidden-table-sms">
                  <div class="image-container table-cell">
                      <?php echo the_post_thumbnail( 'thumbnail' );  ?>
                  </div>
                  <div class="table-cell">
                    <dl class="term-description">
                      <dt>Địa điểm:</dt>
                      <dd class="text-green"><?php echo (!empty(get_field("locations", $tour_id))) ? get_field("locations", $tour_id) : ''; ?></dd>
                      <dt>Khởi hành:</dt>
                      <dd class="text-green"><?php echo (!empty(get_field("itinerary", $tour_id))) ? get_field("itinerary", $tour_id) : ''; ?></dd>
                      <dt>Thời gian:</dt>
                      <dd class="text-green"><?php echo (!empty(get_field("times", $tour_id))) ? get_field("times", $tour_id) : ''; ?></dd>
                      <dt>Giá:</dt>
                      <dd class="text-green">
                          <?php $html_price = '';
                          if (get_field("prices", $tour_id)) {
                              $html_price .= number_format_i18n(get_field("prices", $tour_id)) . ' VNĐ';
                          } else {
                              $html_price .= 'Liên hệ';
                          }
                          echo $html_price;
                          ?>
                      </dd>
                    </dl>
                  </div>
                  <div class="price-section table-cell"><br><br>Giá
                    <div class="price"><div style="color:red" class="price-per-unit"><?php echo $html_price;?></div></div>
                    <a  href="<?php echo get_site_url();?>/lien-he" class="button btn-small uppercase">Đặt Tour</a>
                    <!--<p>Giảm 30% cho 100 tour đầu    </p>-->
                  </div>
                </div>
                <div class="entry-content">
                  <?php
                    $maps = (!empty(get_field("maps", $tour_id,true))) ? get_field("maps", $tour_id) : '';
                    if(!empty($maps)):
                  ?>
                    <div id="map1" style="width: 100%; height: 255px; position: relative; overflow: hidden; margin-bottom: 15px;">
                      <?php echo $maps; ?>
                    </div>
              <?php endif; ?>
                    <?php the_content(); ?>
                    <?php
                    $tabs_content = array();
                    $title_default = [
                        1 => 'Giá tour bao gồm',
                        2 => 'Giá tour không bao gồm',
                        3 => 'Quy Định Đăng Ký Tour',
                        4 => 'Lưu ý',
                    ];
                    for ($i=1; $i <=4; $i++){
                      $tabs_content[] = [
                          'id'      => "no{$i}",
                          'title'   => (!empty(get_field("title_tab{$i}", $tour_id))) ? get_field("title_tab{$i}", $tour_id) : $title_default[$i],
                          'content' => get_field("content_tab{$i}", $tour_id),
                      ];
                    }

                    $html = ''; $html_title = ''; $html_content = '';
                    if(!empty($tabs_content)){
                      $html .= '<div class="tab-container clearfix style1">';
                        $count = 0;
                        $sum_arr = count($tabs_content);
                        foreach ($tabs_content as $tab){
                          $count++;
                          $active_class = ($count === 1) ? 'active' : '';
                          $active_content = ($count === 1) ? ' active in ' : '';
                            if($count == 1){
                                $html_title .= '<ul class="tabs clearfix">';
                                $html_content .= '<div class="tab-content">';
                            }

                            $html_title .= '<li class="'.$active_class.'"><a href="#'.$tab['id'].'" data-toggle="tab">'.$tab['title'].'</a></li>';
                            $html_content .= '<div id="'.$tab['id'].'" class="tab-pane fade '.$active_content.'">
                                                <div>'.$tab['content'].'</div>
                                              </div>';
                            if($count == $sum_arr){
                                $html_title .= '</ul>';
                                $html_content .= '</div>';
                            }
                        }
                        $html .= $html_title.$html_content;
                      $html .= ' </div>';
                    }
                    echo $html;

                    ?>
                </div>
							</div>
                  <?php comments_template(); ?>
						</div>
					</div>

					<div class="sidebar col-sm-4 col-md-3">
						<?php generated_dynamic_sidebar(); ?>
					</div>
				</div>
        <div class="row">
          <div class="col-sm-12 ">
            <div class="container">
              <?php
              // get the custom post type's taxonomy terms
              global $post;
              $custom_taxterms = wp_get_object_terms( $post->ID, 'diadiem', array('fields' => 'ids') );
              // arguments
              $args = array(
                  'post_type' => 'tour',
                  'post_status' => 'publish',
                  'posts_per_page' => 4, // you may edit this number
                  'orderby' => 'rand',
                  'tax_query' => array(
                      array(
                          'taxonomy' => 'diadiem',
                          'field' => 'id',
                          'terms' => $custom_taxterms
                      )
                  ),
                  'post__not_in' => array ($post->ID),
              );
              $related_items = new WP_Query( $args );
              // loop over query
              if ($related_items->have_posts()) :
                  echo '<div><h2>CÁC TOUR TƯƠNG TỰ</h2></div> 
                    <div class="cruise-list image-box style3 cruise listing-style1">
                      <div class="row  add-clearfix">';
                          while ( $related_items->have_posts() ) : $related_items->the_post();
                              $acc_id = trav_acc_clang_id( $related_items->post->ID );
                              $url = esc_url(get_permalink( $acc_id ));
                            ?>
                            <div class="col-sm-6 col-md-3">
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
                              <?php
                          endwhile;
                          echo ' </div>
                  </div>';
              endif;
              // Reset Post Data
              wp_reset_postdata();

              ?>
          </div>
        </div>
			</div>
		</section>


	<?php 
	endwhile;
}

get_footer();