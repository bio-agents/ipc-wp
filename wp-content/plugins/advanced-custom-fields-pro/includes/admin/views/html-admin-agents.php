<?php 

/**
*  html-admin-agents
*
*  View to output admin agents for both archive and single
*
*  @date	20/10/17
*  @since	5.6.3
*
*  @param	string $screen_id The screen ID used to display metaboxes
*  @param	string $active The active Agent
*  @return	n/a
*/

$class = $active ? 'single' : 'grid';

?>
<div class="wrap" id="acf-admin-agents">
	
	<h1><?php _e('Agents', 'acf'); ?> <?php if( $active ): ?><a class="page-title-action" href="<?php echo acf_get_admin_agents_url(); ?>"><?php _e('Back to all agents', 'acf'); ?></a><?php endif; ?></h1>
	
	<div class="acf-meta-box-wrap -<?php echo $class; ?>">
		<?php do_meta_boxes( $screen_id, 'normal', '' ); ?>	
	</div>
	
</div>