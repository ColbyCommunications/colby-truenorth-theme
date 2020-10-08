<?php
  $event_link_register = get_the_permalink() . "?register=true";
  $event_link_target = "";

  if (get_field('external_event_link')) {
    $event_link_register = get_field('external_event_link');
    $event_link_target = 'target="_blank"';
  }

  // Event Date
  $date_event_start = new DateTime(get_field('date'));
  // Event Start Time
  $time_event_start = new DateTime(get_field('start_time'));
  // Event Time Zone
  $date_cal_timezone = get_field('time_zone');

  // Format Event Start Date For Countdown
  $date_event_start_format = $date_event_start->format('m/d/Y');
  // Format Event Start Time For Countdown
  $time_event_start_format = $time_event_start->format('H:i:s');

  // Add to Calendar Date/Time Format
  $add_to_cal = ad_event_dates(get_field('date'), get_field('start_time'), get_field('end_time'), get_field('time_zone'));
?>
<section class="section pt10 pb10">
  <div class="row row-site column">
    <div class="event-card">
      <div class="event-card__image"><img class="zoom-img" src="<?php echo get_field('thumbnail')['sizes']['event-thumb']; ?>" width="400" height="230" alt="<?php echo esc_attr(get_field('thumbnail')['alt']); ?>" /></div>
      <div class="event-card__body">
        <?php if (!ad_registered_event(get_the_id())) : ?>
          <div class="event-card__details">
            <h1 class="event-card__headline"><?php the_title(); ?></h1>
            <div class="event-card__meta">
              <?php $date = get_field('date'); $date = DateTime::createFromFormat('Ymd', $date); ?>
              <span><?php echo $date->format('F j, Y'); ?></span>
              <?php
                $start_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('start_time'));
                $end_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('end_time'));
              ?>
              <span><?php echo $start_time; ?> - <?php echo $end_time; ?> <?php echo $date_cal_timezone['label']; ?></span>
            </div>
            <div class="event-card__overview">
              <p><?php the_field('overview'); ?></p>
            </div>
            <div class="event-card__countdown countdown js-countdown" data-countdown="<?php echo $date_event_start_format . ' ' . $time_event_start_format; ?>"></div>
            <div class="event-card__action">
              <a class="button" href="<?php echo $event_link_register; ?>" <?php echo $event_link_target; ?>><span>Register</span></a>
            </div>
          </div>
        <?php else : ?>
          <div class="event-card__details event-card__details--registered">
            <h1 class="event-card__headline">You have been registered for:</h1>
            <h2 class="event-card__subheadline h3 subheader"><?php the_title(); ?></h2>
            <div class="event-card__meta">
              <?php $date = get_field('date'); $date = DateTime::createFromFormat('Ymd', $date); ?>
              <span><?php echo $date->format('F j, Y'); ?></span>
              <?php
                $start_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('start_time'));
                $end_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('end_time'));
              ?>
              <span><?php echo $start_time; ?> - <?php echo $end_time; ?> <?php echo $date_cal_timezone['label']; ?></span>
            </div>
            <?php if (!empty($add_to_cal['date_cal_start_iso']) && !empty($add_to_cal['date_cal_end_iso'])) : ?>
            <span class="label label--secondary">Add to Calendar</span>
            <div class="addtocal event-card__addtocal">
              <div class="addtocal__data addtocal__data-title"><?php the_title(); ?></div>
              <div class="addtocal__data addtocal__data-start"><?php echo $add_to_cal['date_cal_start_iso']; ?></div>
              <div class="addtocal__data addtocal__data-end"><?php echo $add_to_cal['date_cal_end_iso']; ?></div>
              <div class="addtocal__data addtocal__data-address"></div>
              <div class="addtocal__data addtocal__data-description"><b>Event link: <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></b><br><br><?php the_field('overview'); ?></div>
              <ul class="addtocal__list"></ul>
            </div>
            <?php endif; ?>
            <div class="event-card__overview">
              <p><?php the_field('overview'); ?></p>
            </div>
            <span class="label label--secondary">Event Starts</span>
            <div class="event-card__countdown countdown js-countdown" data-countdown="<?php echo $date_event_start_format . ' ' . $time_event_start_format; ?>"></div>
            <?php
            // Total Registered Members
            $total_registered_members_args = array(
              'post_type' => 'event_registrations',
              'post_status' => 'publish',
              'posts_per_page'=> -1,
              'meta_query'	=> array(
                array(
                  'key'=> 'event',
                  'value'=> get_the_id(),
                )
              )
            );
            $total_registered_members_query = new WP_Query($total_registered_members_args);
            $total_registered_members = $total_registered_members_query->found_posts;

            $visible_registered_members_args = array(
              'post_type' => 'event_registrations',
              'post_status' => 'publish',
              'posts_per_page'=> -1,
              'meta_query'	=> array(
                array(
                  'key'=> 'visible',
                  'value'=> '1',
                ),
                array(
                  'key'=> 'event',
                  'value'=> get_the_id(),
                )
              ),
              'meta_key'=> 'name',
              'orderby'=> 'meta_value',
              'order'=> 'ASC'
            );
            $visible_registered_members_query = new WP_Query($visible_registered_members_args);
            $visible_registered_members = $visible_registered_members_query->found_posts;

            $additional_registered_members = $total_registered_members - $visible_registered_members;
            ?>
            <?php if($visible_registered_members_query->have_posts()) : ?>
            <span class="label label--secondary">See Who is Attending..</span>
            <ul class="event-card__attendees">
              <?php while($visible_registered_members_query->have_posts()) : $visible_registered_members_query->the_post(); ?>
                <?php
                  $class_year_output = "";
                  $user = get_field('user');
                  if ($user) {
                    $user_id = $user['ID'];
                    $user_affiliation = get_user_meta($user_id, 'rcp_member_affiliation', true );
                    if ($user_affiliation === "Alumni" || $user_affiliation === "Parent" || $user_affiliation === "Student") {
                      $class_year_prefix = "";
                      $user_class_year = get_user_meta($user_id, 'rcp_member_class_year', true);
                      $user_class_year = substr($user_class_year, 2);
                      if ($user_affiliation === "Parent") {
                        $class_year_prefix = "P";
                      }
                      $class_year_output = $class_year_prefix . "'" . $user_class_year;
                    }
                  }
                ?>
                <li><?php the_field('name'); ?> <?php echo $class_year_output; ?></li>
              <?php endwhile; ?>
              <?php if ($additional_registered_members > 0) : ?><li>...And <?php echo $additional_registered_members; ?> more attendee<?php if ($additional_registered_members > 1) : ?>s<?php endif; ?></li><?php endif; ?>
            </ul>
            <?php endif; wp_reset_postdata(); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!-- Begin Components - Pre Events -->
<?php if (have_rows('pre_event_components')) : while (have_rows('pre_event_components')) : the_row(); ?>
  <?php include( locate_template( 'template-parts/components/loop-conditionals.php', false, false ) ); ?>
<?php endwhile; endif; ?>
<!-- Begin Components - Pre Events -->
