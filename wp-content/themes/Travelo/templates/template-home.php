<?php
/*
Template Name: Home Page Template
*/
global $trav_options, $search_max_rooms, $search_max_adults, $search_max_kids, $def_currency;
$all_features = array( 'tour', '' );
$enabled_features = array();
foreach( $all_features as $feature ) {
    if ( empty( $trav_options['disable_' . $feature ] ) ) $enabled_features[] = $feature;
}
get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $slider_active = get_post_meta( get_the_ID(), 'trav_page_slider', true );
        $slider        = ( $slider_active == '' ) ? 'Deactivated' : $slider_active;
        if ( class_exists( 'RevSlider' ) && $slider != 'Deactivated' ) {
            echo '<div id="slideshow">';
            putRevSlider( $slider );
            echo '</div>';
        } ?>
        <section id="content"<?php if ( count( $enabled_features ) > 1 ) echo ' class="no-padding"' ?>>
            <div class="search-box-wrapper">
                <div class="search-box container">
                    <?php if ( count( $enabled_features ) > 1 ) : ?>
                        <ul class="search-tabs clearfix">
                            <?php if ( in_array('tour', $enabled_features) ) : ?>
                                <li <?php if ( $enabled_features[0] == 'tour' ) echo 'class="active"' ?> ><a href="#tours-tab" data-toggle="tab"><?php _e( 'TOURS', 'trav' ) ?></a></li>
                            <?php endif; ?>
                            <?php if ( in_array('acc', $enabled_features) ) : ?>
                                <li <?php if ( $enabled_features[0] == 'acc' ) echo 'class="active"' ?> ><a href="#hotels-tab" data-toggle="tab"><?php _e( 'HOTELS', 'trav' ) ?></a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="visible-mobile">
                            <ul id="mobile-search-tabs" class="search-tabs clearfix">
                                <?php if ( in_array('acc', $enabled_features) ) : ?>
                                    <li <?php if ( $enabled_features[0] == 'acc' ) echo 'class="active"' ?> ><a href="#hotels-tab" data-toggle="tab"><?php _e( 'HOTELS', 'trav' ) ?></a></li>
                                <?php endif; ?>
                                <?php if ( in_array('tour', $enabled_features) ) : ?>
                                    <li <?php if ( $enabled_features[0] == 'tour' ) echo 'class="active"' ?> ><a href="#tours-tab" data-toggle="tab"><?php _e( 'TOURS', 'trav' ) ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="search-tab-content">
                        <?php if ( in_array('acc', $enabled_features) ) : ?>
                            <?php if ( count( $enabled_features ) > 1 ) : ?>
                                <div class="tab-pane fade<?php if ( $enabled_features[0] == 'acc' ) echo ' active in' ?>" id="hotels-tab">
                            <?php endif; ?>
                            <form role="search" method="get" id="searchform" class="acc-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <input type="hidden" name="post_type" value="accommodation">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-3">
                                        <h4 class="title"><?php _e( 'Where','trav' ); ?></h4>
                                        <label><?php _e( 'Your Destination','trav' ); ?></label>
                                        <input type="text" name="s" class="input-text full-width" placeholder="<?php _e( 'Enter a destination or hotel name', 'trav') ?>" />
                                    </div>

                                    <div class="form-group col-sm-6 col-md-4">
                                        <h4 class="title"><?php _e( 'When','trav' ); ?></h4>
                                        <div class="row search-when" data-error-message1="<?php echo __( 'Your check-out date is before your check-in date. Have another look at your date and try again.' , 'trav') ?>" data-error-message2="<?php echo __( 'Please select current or future dates for check-in and check-out.' , 'trav') ?>">
                                            <div class="col-xs-6">
                                                <label><?php _e( 'CHECK IN','trav' ); ?></label>
                                                <div class="datepicker-wrap from-today">
                                                    <input name="date_from" type="text" class="input-text full-width" placeholder="<?php echo trav_get_date_format('html'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label><?php _e( 'CHECK OUT','trav' ); ?></label>
                                                <div class="datepicker-wrap from-today">
                                                    <input name="date_to" type="text" class="input-text full-width" placeholder="<?php echo trav_get_date_format('html'); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 col-md-3">
                                        <h4 class="title"><?php _e( 'Who','trav' ); ?></h4>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label><?php _e( 'Rooms','trav' ); ?></label>
                                                <div class="selector">
                                                    <select name="rooms" class="full-width">
                                                        <?php
                                                        $rooms = ( isset( $_GET['rooms'] ) && is_numeric( (int) $_GET['rooms'] ) )?(int) $_GET['rooms']:1;
                                                        for ( $i = 1; $i <= $search_max_rooms; $i++ ) {
                                                            $selected = '';
                                                            if ( $i == $rooms ) $selected = 'selected';
                                                            echo '<option value="' . esc_attr( $i ) . '" ' . $selected . '>' . esc_html( $i ) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label><?php _e( 'Adults','trav' ); ?></label>
                                                <div class="selector">
                                                    <select name="adults" class="full-width">
                                                        <?php
                                                        $adults = ( isset( $_GET['adults'] ) && is_numeric( (int) $_GET['adults'] ) )?(int) $_GET['adults']:1;
                                                        for ( $i = 1; $i <= $search_max_adults; $i++ ) {
                                                            $selected = '';
                                                            if ( $i == $adults ) $selected = 'selected';
                                                            echo '<option value="' . esc_attr( $i ) . '" ' . $selected . '>' . esc_html( $i ) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label><?php _e( 'Kids','trav' ); ?></label>
                                                <div class="selector">
                                                    <select name="kids" class="full-width">
                                                        <?php
                                                        $kids = ( isset( $_GET['kids'] ) && is_numeric( (int) $_GET['kids'] ) )?(int) $_GET['kids']:0;
                                                        for ( $i = 0; $i <= $search_max_kids; $i++ ) {
                                                            $selected = '';
                                                            if ( $i == $kids ) $selected = 'selected';
                                                            echo '<option value="' . esc_attr( $i ) . '" ' . $selected . '>' . esc_html( $i ) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="age-of-children no-display">
                                            <h5><?php _e( 'Age of Children','trav' ); ?></h5>
                                            <div class="row">
                                                <div class="col-xs-4 child-age-field">
                                                    <label><?php echo __( 'Child ', 'trav' ) . '1' ?></label>
                                                    <div class="selector validation-field">
                                                        <select name="child_ages[]" class="full-width">
                                                            <?php
                                                            $max_kid_age = 17;
                                                            for ( $i = 0; $i <= $max_kid_age; $i++ ) {
                                                                echo '<option value="' . esc_attr( $i ) . '">' . esc_html( $i ) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 col-md-2 fixheight">
                                        <label class="hidden-xs">&nbsp;</label>
                                        <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1"><?php _e( 'Tìm kiếm ngay', 'trav') ?></button>
                                    </div>
                                </div>
                            </form>
                            <?php if ( count( $enabled_features ) > 1 ) : ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ( in_array('tour', $enabled_features) ) : ?>
                            <?php if ( count( $enabled_features ) > 1 ) : ?>
                                <div class="tab-pane fade<?php if ( $enabled_features[0] == 'tour' ) echo ' active in' ?>" id="tours-tab">
                            <?php endif; ?>
                            <form role="search" method="get" id="searchform" class="tour-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <input type="hidden" name="post_type" value="tour">
                                <div class="row">
                                    <div class="form-group col-sm-4 col-md-4">
                                        <!--<h4 class="title"><?php /*_e( 'Chào mừng bạn đến với Công ty du lịch Offtrack Travel','trav' ); */?></h4>-->
                                        <label><?php _e( 'Tìm địa chỉ', 'trav' ) ?></label>
                                        <input type="text" name="s" class="input-text full-width" placeholder="<?php _e( 'Nhập địa chỉ bạn muốn đi', 'trav') ?>" />
                                    </div>

                                    <div class="form-group col-sm-4 col-md-4">
                                        <?php $danhsach_diadiem = get_terms( 'diadiem', array( 'orderby' => 'parent', 'order' => 'ASC', 'hide_empty' => false ) ); ?>
                                        <?php if ( ! empty( $danhsach_diadiem ) ) : ?>
                                                <div>
                                                    <label><?php _e( 'Bạn muốn đi đâu', 'trav' ) ?></label>
                                                    <div class="selector">
                                                        <select name="diadiem" class="full-width">
                                                            <option value=""><?php _e( 'Tất cả', 'trav' ) ?></option>
                                                            <?php foreach ( $danhsach_diadiem as $diadiem ) : ?>
                                                                <?php if ($diadiem->parent != 0) :?>
                                                                    <option value="<?php echo $diadiem->term_id ?>"><?php _e( $diadiem->name, 'trav' ) ?></option>
                                                                <?php endif;?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-sm-4 col-md-4">
                                        <label class="hidden-xs">&nbsp;</label>
                                        <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1"><?php _e( 'Tìm kiếm ngay', 'trav') ?></button>
                                    </div>
                                </div>
                            </form>
                            <?php if ( count( $enabled_features ) > 1 ) : ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="entry-content">
                <?php the_content(); ?>
                <div class="container">
                    <div class="block">
                        <div>
                            <h1>Offtrack travel</h1>
                        </div>
                        <div class="vc_row wpb_row vc_inner row">
                            <div class="wpb_column col-sm-12 col-md-4">
                                <div class="vc_column-inner ">
                                    <div class="wpb_wrapper">
                                        <div class="icon-box style5">
                                            <i class="soap-icon-phone"></i>
                                            <div class="description">
                                                <small>Hotline 24/7</small>
                                                <h5>086 890 8879</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wpb_column col-sm-12 col-md-4">
                                <div class="vc_column-inner ">
                                    <div class="wpb_wrapper">
                                        <div class="icon-box style5">
                                            <i class="soap-icon-message"></i>
                                            <div class="description"><small>Gửi mail cho chúng tôi</small>
                                                <h5>info@offtracktravel.com</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wpb_column col-sm-12 col-md-4">
                                <div class="vc_column-inner ">
                                    <div class="wpb_wrapper">
                                        <div class="icon-box style5">
                                            <i class="soap-icon-address"></i>
                                            <div class="description"><small>Trụ sở tại</small>
                                                <h5>USA, P.O Box, 353 Three Avenue</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="block">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul class="travel-news">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.486670478275!2d106.70126171435047!3d10.773988692323224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f46bf7d119d%3A0xebf6179d9abce572!2zTmd1ecOqzINuIEh1w6rMoywgQuG6v24gTmdow6ksIFF14bqtbiAxLCBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1513309849409" width="100%" height="300"></iframe>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile;
endif;
get_footer();