<?php
  $event_in_past = false;
  $event_link = get_the_permalink();
  $event_link_register = get_the_permalink() . "?register=true";
  $event_link_target = "";
  $event_link_class = "";
  $event_link_title = "Register";
  $event_status = ad_event_status(get_field('show_event_start_date_time'), get_field('show_event_end_date_time'));

  if (get_field('external_event_link')) {
    $event_link = get_field('external_event_link');
    $event_link_title = get_field('event_link_text');
    $event_link_register = $event_link;
    $event_link_target = 'target="_blank"';
    if ($event_status === "Live") {
      $event_link_title = "Enter Event";
    }
    elseif ($event_status === "Post") {
      $event_in_past = true;
      $event_link_title = "Watch Recap";
    }
  }
  else {
    if ($event_status === "Post") {
      $event_in_past = true;
      $event_link_register = $event_link;
      $event_link_title = "Watch Recap";
    }
    elseif (ad_registered_event(get_the_id())) {
      $event_link_register = $event_link;
      $event_link_class = "secondary";
      if ($event_status === "Pre") {
        $event_link_title = "Registered";
      }
      else {
        $event_link_title = "Enter Event";
        $event_link_class = "secondary";
      }
    }
  }
?>
<div class="card zoom-trigger">
  <div class="card__image">
    <a href="<?php echo $event_link; ?>" <?php echo $event_link_target; ?>>
      <img class="zoom-img" src="<?php echo get_field('thumbnail')['sizes']['event-thumb']; ?>" width="400" height="230" alt="<?php echo esc_attr(get_field('thumbnail')['alt']); ?>" />
    </a>
  </div>
  <div class="card__body">
    <h3 class="card__headline"><a href="<?php echo $event_link; ?>" <?php echo $event_link_target; ?>><?php the_title(); ?></a></h3>
    <div class="card__meta">
      <?php $date = get_field('date'); $date = DateTime::createFromFormat('Ymd', $date); ?>
      <span><?php echo $date->format('F j, Y'); ?></span>
      <?php if (!$event_in_past) : ?>
        <?php
          $start_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('start_time'));
          $end_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('end_time'));
        ?>
        <span><?php echo $start_time; ?> - <?php echo $end_time; ?> <?php echo get_field('time_zone')['label']; ?></span>
      <?php endif; ?>
    </div>
    <div class="card__overview">
      <p><?php the_field('overview'); ?></p>
    </div>
  </div>
  <div class="card__action">
    <a class="button <?php echo $event_link_class; ?>" href="<?php echo $event_link_register; ?>" <?php echo $event_link_target; ?>><span><?php echo $event_link_title; ?></span></a>
  </div>
</div>
