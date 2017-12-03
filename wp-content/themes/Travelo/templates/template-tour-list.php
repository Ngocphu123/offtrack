<article class="box">
    <figure>
        <a title="<?php _e( 'View Photo Gallery', 'trav' ); ?>" class="hover-effect popup-gallery" data-post_id="<?php echo esc_attr( $acc_id );?>" href="#"><?php echo get_the_post_thumbnail( $acc_id, 'gallery-thumb' ); ?></a>
        <?php if ( ! empty( $discount_rate ) ) { ?>
            <span class="discount"><span class="discount-text"><?php echo esc_html( $discount_rate . '%' . ' ' . __( 'Discount', 'trav' ) ); ?></span></span>
        <?php } ?>
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