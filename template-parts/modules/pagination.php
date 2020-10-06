<?php
  $big = 999999999; // need an unlikely integer
  $pagination_current = max(1, intval($pagination_query->query['paged']));
  $pagination =  paginate_links(array(
      'current' => $pagination_current,
      'total' => $pagination_query->max_num_pages,
      'type' => 'array',
      'prev_next' => false,
      'show_all' => true
  ));
  if ( ! empty( $pagination ) ) :
  $pagination_total = count($pagination);
?>
<div class="pagination" data-page-active="<?php echo $pagination_current; ?>" data-page-total="<?php echo $pagination_total; ?>">
  <?php if ($pagination_current > 1) : ?>
  <a class="pag-button pag-prev" data-page="<?php echo $pagination_current - 1; ?>" href="#">Previous</a>
  <?php endif; ?>
  <?php if ($pagination_current < $pagination_total) : ?>
  <a class="pag-button pag-next" data-page="<?php echo $pagination_current + 1; ?>" href="#">Next</a>
  <?php endif; ?>
  <ul class="pag-jump">
    <li> <span class="pag-jump-label"><strong><?php echo $pagination_current; ?></strong> of <?php echo $pagination_total; ?></span>
      <ul>
        <?php foreach ( $pagination as $key => $page_link ) : ?>
        <?php $page_number = intval(strip_tags($page_link)); ?>
        <li class="<?php if ($pagination_current == $page_number) { echo ' active'; } ?>"><a data-page="<?php echo $page_number; ?>" href="#"><?php echo $page_number; ?></a></li>
        <?php endforeach ?>
      </ul>
    </li>
  </ul>
</div>
<?php endif ?>
