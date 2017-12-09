<?php
// Do not delete these lines
	if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="no-comments"><?php echo __('This post is password protected. Enter the password to view comments.', 'trav'); ?></p>
	<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	<div class="comments-container block">
		<h2><?php comments_number();?></h2>
		<ul class="comment-list travelo-box">
			<?php wp_list_comments('callback=trav_comment'); ?>
		</ul>
		<?php paginate_comments_links( array( 'type' => 'list' ) ); ?>
	</div>
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="no-comments"><?php echo __('Bình luận bị đóng.', 'trav'); ?></p>

	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<div class="post-comment block" id="respond">
		<div class="travelo-box">
			<?php
				$args = array(  'comment_field' => '<div id="comment-textarea" class="form-group"><label for="comment">' . __( 'Nội dung của bạn', 'trav' ) . '</label><textarea id="comment" name="comment" rows="6" aria-required="true"  class="input-text full-width textarea-comment" placeholder="viết nội dung ở đây"></textarea></div>',
								'title_reply' => __( 'Để lại bình luận', 'trav' ),
								'comment_notes_before' => '<p class="comment-notes">' . __( 'Email của bạn sẽ không được hiển thị công khai. Tất cả các trường đều là bắt buộc.', 'trav' ) . '</p>',
								'id_submit' => 'comment-submit',
								'fields' => array(
										'author' => '<div class="col-xs-6"> <label>' . __( 'Tên của bạn', 'trav' ) . '</label> <input name="author" type="text" class="input-text full-width" value=""> </div>',
										'email' => '<div class="col-xs-6"> <label>' . __( 'Email của bạn', 'trav' ) . '</label> <input name="email" type="text" class="input-text full-width" value=""> </div>',
								),
							);
			 ?>
			<?php comment_form($args); ?>
		</div>
	</div>
<?php endif;