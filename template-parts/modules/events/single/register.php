<section class="section section--bg section--bg-top section--bg-bottom pt10 pb10" style="background-image:url('/wp-content/uploads/colby-bg.jpg')">
  <div class="row row-site column">
    <div class="account-box">
      <div class="event-register">
        <!-- Begin Event Register Header -->
        <div class="event-register__header">
          <h1 class="event-register__headline"><?php the_title(); ?></h1>
          <div class="event-register__meta">
            <?php $date = get_field('date'); $date = DateTime::createFromFormat('Ymd', $date); ?>
            <span><?php echo $date->format('F j, Y'); ?></span>
            <?php
              $start_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('start_time'));
              $end_time = str_replace(array('am','pm'),array('a.m.','p.m.'),get_field('end_time'));
            ?>
            <span><?php echo $start_time; ?> - <?php echo $end_time; ?> <?php echo get_field('time_zone')['label']; ?></span>
          </div>
          <div class="event-card__overview">
            <p><?php the_field('overview'); ?></p>
          </div>
          <?php if (!is_user_logged_in()) : ?>
          <div class="event-register__login slide-toggle-container">
            <p class="event-register__login-link slide-toggle">Already Registered? <a href="#">Login</a></p>
            <div class="slide-content">
              <form class="js-login" data-view-"register" data-redirect="">
                <?php wp_nonce_field( 'ajax-login-nonce', 'login-security' ); ?>
                <div class="row column">
                  <label for="LoginEmail">Email Address
                  <input id="LoginEmail" type="email" name="username" placeholder="Enter Email" required />
                  </label>
                </div>
                <div class="row column">
                  <div class="alert"></div>
                </div>
                <div class="row column">
                  <button type="submit" class="btn-brush"><span>Login</span></button>
                </div>
              </form>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <!-- End Event Register Header -->
        <?php if (!is_user_logged_in()) : ?>
          <!-- Begin Non-Loggedin User - Event Register Form -->
          <form class="js-register" data-redirect="<?php the_permalink(); ?>">
            <?php wp_nonce_field( 'ajax-register-nonce', 'register-security' ); ?>
            <input type="hidden" name="action" value="ajax_register" readonly autocomplete="off" />
            <input type="hidden" name="acf[event]" value="<?php the_id(); ?>" readonly autocomplete="off" />

            <div class="row">
              <div class="large-6 columns">
                <label for="first_name">First Name <span class="req">*</span>
                <input type="text" name="first_name" id="first_name" placeholder="Enter First Name" required>
                </label>
              </div>
              <div class="large-6 columns">
                <label for="last_name">Last Name <span class="req">*</span>
                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name" required>
                </label>
              </div>
            </div>
            <div class="row column">
              <label for="user_email">Email <span class="req">*</span>
              <input type="text" name="user_email" id="user_email" placeholder="Enter Email" required>
              </label>
            </div>
            <div class="row">
              <div class="large-6 columns">
                <label for="rcp_member_affiliation">Affiliation <span class="req">*</span>
                <select class="js-affiliation-toggle" name="rcp_member_affiliation" id="rcp_member_affiliation" required>
                  <option value="">-- Select Affiliation -- </option>
                  <option value="Alumni">Alumni</option>
                  <option value="Parent">Parent</option>
                  <option value="Friends">Friends</option>
                  <option value="Student">Student</option>
                  <option value="Faculty/Staff">Faculty/Staff</option>
                  <option value="Other">Other</option>
                </select>
                </label>
              </div>
              <div class="large-6 columns js-affiliation-class-year" style="display:none;">
                <label for="rcp_member_class_year"><span class="parent-label" style="display:none;">Parent</span> Class Year <span class="req">*</span>
                <input type="text" name="rcp_member_class_year" id="rcp_member_class_year" placeholder="Enter Class Year">
                </label>
              </div>
              <div class="large-6 columns js-affiliation-reason" style="display:none;">
                <label for="rcp_member_reason_attending">Reason for Attending <span class="req">*</span>
                <input type="text" name="rcp_member_reason_attending" id="rcp_member_reason_attending" placeholder="Enter Reason for Attending">
                </label>
              </div>
              <script>
                $(".js-affiliation-toggle").change(function(){
                  $(".js-affiliation-class-year, .js-affiliation-class-year .parent-label, .js-affiliation-reason").hide();
                  $(".js-affiliation-class-year input").attr("placeholder", "Enter Class Year").val("");
                  $(".js-affiliation-class-year input, .js-affiliation-reason input").removeAttr("required");

                  if ($(this).val() === "Alumni" || $(this).val() === "Parent" || $(this).val() === "Student") {
                    $(".js-affiliation-class-year").show();
                    $(".js-affiliation-class-year input").attr("required", "");
                  }
                  else if ($(this).val() === "Other") {
                    $(".js-affiliation-reason").show();
                    $(".js-affiliation-reason input").attr("required", "");
                  }

                  if ($(this).val() === "Parent") {
                    $(".js-affiliation-class-year .parent-label").show();
                    $(".js-affiliation-class-year input").attr("placeholder", "Enter Parent Class Year");
                  }
                });
              </script>
            </div>
            <?php if (get_field('registration_form_settings')['questions']) : ?>
            <div class="row column">
              <label for="member_questions">Question for our panel speakers:
              <textarea name="acf[question]" id="member_questions"></textarea>
              </label>
            </div>
            <?php endif; ?>
            <div class="row column">
              <div class="checkbox">
                <label for="member_attendee_visibility"><input id="member_attendee_visibility" name="member_attendee_visibility" type="checkbox" value="1"><span class="checkbox__check"></span> <span class="checkbox__label">Allow others to see I’m attending.</span></label>
              </div>
            </div>
            <div class="row column">
              <div class="alert"></div>
            </div>
            <div class="row column center">
              <button type="submit" class="btn-brush"><span>Register</span></button>
              <p class="event-register__note">By clicking on Register, you agree to our <a href="http://www.colby.edu/generalcounsel/privacy-policy/" target="_blank">terms, data<br /> policy, and cookie policy</a>.</p>
            </div>
          </form>
          <!-- Begin Non-Loggedin User - Event Register Form -->
        <?php elseif (is_user_logged_in()) : $current_user = wp_get_current_user(); ?>
          <!-- Begin Loggedin User - Not Registered - Event Register Form -->
          <form class="js-register" data-redirect="<?php the_permalink(); ?>">
            <?php wp_nonce_field( 'ajax-register-nonce', 'register-security' ); ?>
            <input type="hidden" name="action" value="ajax_event_register" readonly autocomplete="off" />
            <input type="hidden" name="acf[event]" value="<?php the_id(); ?>" readonly autocomplete="off" />
            <div class="row column">
              <label for="user_email">Email <span class="req">*</span>
              <input type="text" name="user_email" id="user_email" placeholder="Enter Email" readonly autocomplete="off" value="<?php echo $current_user->user_login; ?>" required>
              </label>
            </div>
            <?php if (get_field('registration_form_settings')['questions']) : ?>
            <div class="row column">
              <label for="member_questions">Question for our panel speakers:
              <textarea name="acf[question]" id="member_questions"></textarea>
              </label>
            </div>
            <?php endif; ?>
            <div class="row column">
              <div class="checkbox">
                <label for="member_attendee_visibility"><input id="member_attendee_visibility" name="member_attendee_visibility" type="checkbox"><span class="checkbox__check"></span> <span class="checkbox__label">Allow others to see I’m attending.</span></label>
              </div>
            </div>
            <div class="row column">
              <div class="alert"></div>
            </div>
            <div class="row column center">
              <button type="submit" class="btn-brush"><span>Register</span></button>
              <p class="event-register__note">By clicking on Register, you agree to our <a href="http://www.colby.edu/generalcounsel/privacy-policy/" target="_blank">terms, data<br /> policy, and cookie policy</a>.</p>
            </div>
          </form>
          <!-- Begin Loggedin User - Not Registered - Event Register Form -->
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
