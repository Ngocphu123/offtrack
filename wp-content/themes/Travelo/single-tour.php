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
		//$city = trav_tour_get_city( $tour_id );
		//$country = trav_tour_get_country( $tour_id );

		//$date_from = ( isset( $_GET['date_from'] ) ) ? trav_tophptime( $_GET['date_from'] ) : date( trav_get_date_format('php') );
		//$date_to = ( isset( $_GET['date_to'] ) ) ? trav_tophptime( $_GET['date_to'] ) : date( trav_get_date_format('php'), trav_strtotime( $date_from ) + 86400 * 30 );
		//$repeated = get_post_meta( $tour_id, 'trav_tour_repeated', true );
		//$multi_book = get_post_meta( $tour_id, 'trav_tour_multi_book', true );
		//$isv_setting = get_post_meta( $tour_id, 'trav_post_media_type', true );
		//$discount = get_post_meta( $tour_id, 'trav_tour_hot', true );
		//$discount_rate = get_post_meta( $tour_id, 'trav_tour_discount_rate', true );
		//$sc_list_pos = get_post_meta( $tour_id, 'trav_tour_sl_first', true );

		//$schedule_types = trav_tour_get_schedule_types( $tour_id );

		// add to user recent activity
		trav_update_user_recent_activity( $tour_id ); ?>

		<section id="content">
			<div class="container tour-detail-page">
				<div class="row">
					<div id="main" class="col-sm-8 col-md-9">
						<div <?php post_class(); ?>>
							<div class="image-box">
								<?php if ( ! empty( $discount ) && ! empty( $discount_rate ) ) : ?>
									<span class="discount"><span class="discount-text"><?php echo esc_html( $discount_rate ) ?>% Discount</span></span>
								<?php endif; ?>
								<?php trav_post_gallery( $tour_id ) ?>
							</div>

							<div id="tour-details" class="travelo-box">
                              <div class="intro2 small-box border-box table-wrapper hidden-table-sms">
                                <div class="image-container table-cell"><img src="https://scontent.fsgn3-1.fna.fbcdn.net/v/t1.0-9/22687679_447154462346867_6175907620238880230_n.jpg?oh=b2cac4e77e596d14bce2dcf49b6f0587&amp;oe=5A734B05" alt="Du Lịch Singapore"></div>
                                <div class="table-cell">
                                  <dl class="term-description">
                                    <dt>Địa điểm:</dt><dd style="color:#6ac610">Singapore</dd>
                                    <dt>Khởi hành:</dt><dd style="color:#6ac610">Hằng Tuần</dd>
                                    <dt>Thời gian:</dt><dd style="color:#6ac610">3 ngày 2 đêm</dd>
                                    <dt>Giá:</dt><dd style="color:#6ac610">9.980.000 vnđ/khách</dd>
                                  </dl>
                                </div>
                                <div class="price-section table-cell"><br><br>Giá chỉ
                                  <div class="price"><div style="color:red" class="price-per-unit">9.980.000 vnđ/khách</div></div>
                                  <a style="background:#01b7f2" href="/lien-he.htm" class="button green btn-small uppercase">Đặt Tour</a>
                                  <p>Giảm 30% cho 100 tour đầu    </p>
                                </div>
                              </div>
								<?php if ( ! empty( $repeated ) ): ?>
									<form id="check_availability_form" method="post">
										<input type="hidden" name="tour_id" value="<?php echo esc_attr( $tour_id ); ?>">
										<input type="hidden" name="action" value="tour_get_available_schedules">
										<?php wp_nonce_field( 'post-' . $tour_id, '_wpnonce', false ); ?>
										<div class="update-search clearfix">
											<div class="alert alert-error" style="display:none;"><span class="message"><?php _e( 'Please select check in date.','trav' ); ?></span><span class="close"></span></div>
											<h4><?php _e( 'Check Availability', 'trav' ) ?></h4>
											<div class="col-md-6">
												<div class="row">
													<div class="col-xs-6">
														<label><?php _e( 'From','trav' ); ?></label>
														<div class="datepicker-wrap validation-field from-today">
															<input name="date_from" type="text" placeholder="<?php echo trav_get_date_format('html'); ?>" class="input-text full-width" value="<?php echo $date_from; ?>" />
														</div>
													</div>
													<div class="col-xs-6">
														<label><?php _e( 'To','trav' ); ?></label>
														<div class="datepicker-wrap validation-field from-today">
															<input name="date_to" type="text" placeholder="<?php echo trav_get_date_format('html'); ?>" class="input-text full-width" value="<?php echo $date_to;?>" />
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<label class="visible-md visible-lg">&nbsp;</label>
												<div class="row">
													<div class="col-xs-12">
														<button id="check_availability" data-animation-duration="1" data-animation-type="bounce" class="full-width icon-check animated bounce" type="submit"><?php _e( "UPDATE", "trav" ); ?></button>
													</div>
												</div>
											</div>
										</div>
									</form>
								<?php endif; ?>

								<?php if ( empty( $sc_list_pos ) ) : ?>

									<div class="entry-content"><?php the_content(); ?></div>
									<div id="schedule-list">
										<?php trav_tour_get_schedule_list_html( array( 'tour_id'=>$tour_id, 'date_from'=>$date_from, 'date_to'=>$date_to ) ); ?>
									</div>

								<?php else : ?>

									<div id="schedule-list">
										<?php trav_tour_get_schedule_list_html( array( 'tour_id'=>$tour_id, 'date_from'=>$date_from, 'date_to'=>$date_to ) ); ?>
									</div>
									<div class="entry-content"><?php the_content(); ?></div>

								<?php endif; ?>

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