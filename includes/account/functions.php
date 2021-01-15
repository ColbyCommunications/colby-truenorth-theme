<?php

class AD_Account {

  // Account Options
  private $options = array(
    'rcp' => true
  );

  private $account_settings = array(
    'user_role' => 'member',
    'account_password' => 'A05ZVRIyytcw5N&qXh&$yA7OA8Ma*N', // Do not change this otherwise all users already registered with this password will not be able to login
    'account_pages' => array(
      'login' => 387,
      'dashboard' => 66
    )
  );

  // Define RCP
  private $rcp_module = null;

  public function __construct() {
    // Check if RCP is enabled and initiate Class
    if($this->options['rcp']) {
      require_once(get_template_directory() . '/includes/account/rcp.php');
      $this->rcp_module = new AD_Account_RCP($this->account_settings);
    }
    // Login
    add_action('wp_ajax_nopriv_ajax_login', array($this, 'ajax_login'));
    // Logout
    add_action('wp_ajax_ajax_logout', array($this, 'ajax_logout'));
    add_action('wp_ajax_nopriv_ajax_logout', array($this, 'ajax_logout'));
    // Registration
    add_action('wp_ajax_ajax_register', array($this, 'ajax_register'));
    add_action('wp_ajax_nopriv_ajax_register', array($this, 'ajax_register'));
    // Event Registration
    add_action('wp_ajax_ajax_event_register', array($this, 'ajax_event_register'));
    add_action('wp_ajax_nopriv_ajax_event_register', array($this, 'ajax_event_register'));
    // Notifications - Update WP Notification Email Content Types
    #add_filter('wp_mail_content_type', array($this, 'set_email_content_type'));
    // Notifications - Registration Email
    #add_filter('wp_new_user_notification_email', array($this, 'registration_email'), 10, 3);
    // Force Remove Admin Bar For Users
    add_action('after_setup_theme', array($this, 'remove_admin_bar'));
    // Redirect Members From Accessing WP Admin Dashboard or Profile Page
    add_action('admin_init', array($this, 'admin_redirect'));
    // Add private/draft/future/pending pages to parent dropdown.
    add_filter( 'page_attributes_dropdown_pages_args', array($this, 'private_draft_add_parents'));
    add_filter( 'quick_edit_dropdown_pages_args', array($this, 'private_draft_add_parents'));
    // Secure Redirects
    add_action('template_redirect', array($this,'account_redirects'));
    // Account Shortcode
    add_shortcode('account', array($this,'account_shortcode'));
  }

  //////////////////////////////////////////////////////////////////////
  // Login Functions
  /////////////////////////////////////////////////////////////////////
  public function ajax_login(){

    // First check the nonce, if it fails the function will break
    // check_ajax_referer( 'ajax-login-nonce', 'login-security', false );

    // Login View
    $login_view = "";
    if (isset($_POST['view'])) {
      $login_view = $_POST['view'];
    }

    // Nonce is checked, get the POST data and sign user on
    $user = array();
    $user['user_login'] = sanitize_email($_POST['username']);
    $user['user_password'] = $this->account_settings['account_password'];
    $user['remember'] = true;

    // Get user data if email address is entered in
    $member = get_user_by('email', $user['user_login']);

    // Log user in by username if email is entered in
    if ($member) {
      $user['user_login'] = $member->user_login;
    }

    // Sign WP user on.
    $user_signon = wp_signon( $user, false );

    // If incorrect password (members password was updated accidentally) and member is only part of the members role, reset their password
    if (in_array("incorrect_password", $user_signon->get_error_codes()) && count($member->roles) == 1 && in_array("member", $member->roles)) {
      wp_set_password($this->account_settings['account_password'], $member->ID);
      $user_signon = wp_signon( $user, false );
    }

    // Error handling
    $login_error_message = "Incorrect email address. Please try again or register below.";

    if ($login_view === "login") {
      $login_error_message = 'Incorrect email address. Try again or <a href="/attend">register for an event</a> to sign up.';
    }

    if (is_wp_error($user_signon)){
        echo json_encode(array('status'=> false, 'message'=> $login_error_message));
    } else {
        echo json_encode(array('status'=> true, 'message'=> 'Success'));
    }

    die();

  }

  //////////////////////////////////////////////////////////////////////
  // Logout Functions
  /////////////////////////////////////////////////////////////////////
  public function ajax_logout(){

      // First check the nonce, if it fails the function will break
      // check_ajax_referer( 'ajax-logout-nonce', 'logout-security', false );

      // Log User Out
      $user_logout = wp_logout();

      if (is_wp_error($user_logout)){
          echo json_encode(array('status'=> false, 'message'=> 'Error'));
      } else {
          echo json_encode(array('status'=> true, 'message'=> 'Success'));
      }

      die();

  }

  //////////////////////////////////////////////////////////////////////
  // Event Registration
  /////////////////////////////////////////////////////////////////////
  public function event_register($form_data = null, $user_id = null) {
    if (!isset($form_data) || !isset($user_id)) {
      echo json_encode( array('status'=> false, 'message'=> 'Error registering event. Please contact us for assistance.') );
      die();
    }

    $form_data['acf']['name'] = get_the_author_meta('first_name', $user_id) . ' ' . get_the_author_meta('last_name', $user_id);
    $form_data['acf']['first_name'] = get_the_author_meta('first_name', $user_id);
    $form_data['acf']['last_name'] = get_the_author_meta('last_name', $user_id);
    $form_data['acf']['affiliation'] = get_user_meta($user_id, 'rcp_member_affiliation', true );
    $form_data['acf']['class_year'] = get_user_meta($user_id, 'rcp_member_class_year', true );
    $form_data['acf']['reason_for_attending'] = get_user_meta($user_id, 'rcp_member_reason_attending', true );
    $form_data['acf']['visible'] = isset($form_data['member_attendee_visibility']) ? 1 : 0;
    $form_data['acf']['email'] = sanitize_email($form_data['user_email']);
    $form_data['acf']['user'] = $user_id;

    $post_arr = array(
      'post_type' => 'event_registrations',
      'post_status' => 'publish',
      'post_title' => get_the_title($form_data['acf']['event']) . ' | ' . $form_data['acf']['name']
    );

    $create_post = wp_insert_post( $post_arr, true );

    if (is_wp_error($create_post) ){
      echo json_encode( array('status'=> false, 'message'=> join( ',', $create_post->get_error_messages())) );
      die();
    }
    else {
      // Update ACF Fields
      foreach ($form_data['acf'] as $acf_field_name => $acf_field_value) {
        update_field( $acf_field_name, $acf_field_value, $create_post );
      }
    }

  }

  //////////////////////////////////////////////////////////////////////
  // Gravity Form Notification
  /////////////////////////////////////////////////////////////////////
  public function event_gravity_form_notification($form_data = null, $user_id = null) {
    if (!isset($form_data) || !isset($form_data['acf']['event']) || !isset($user_id)) {
      return "Missing data to send GF notification";
    }

    // Event Data
    $event = $form_data['acf']['event'];

    // Format Event Date/Time
    $date = get_field('date', $event);
    $date = DateTime::createFromFormat('Ymd', $date);
    $event_date = $date->format('F j, Y') .' | '. get_field('start_time', $event) .' - '. get_field('end_time', $event) .' '. get_field('time_zone', $event)['label'];

    // GF Form Input Values
    $input_values = array();
    $input_values['input_1_3'] = get_the_author_meta('first_name', $user_id);
    $input_values['input_1_6'] = get_the_author_meta('last_name', $user_id);
    $input_values['input_2'] = sanitize_email($form_data['user_email']);
    $input_values['input_3'] = get_the_title($event);
    $input_values['input_6'] = get_permalink($event);
    $input_values['input_7'] = $event_date;
    $input_values['input_5'] = get_field('overview', $event);

    // Submit GF Form
    $result = GFAPI::submit_form(1, $input_values);

    if (isset($result['is_valid']) && $result['is_valid']) {
      return "Success";
    }
    else {
      return "Error submitting GF Form";
    }

  }

  //////////////////////////////////////////////////////////////////////
  // Registration
  /////////////////////////////////////////////////////////////////////
  public function ajax_register(){

      // First check the nonce, if it fails the function will break
      // check_ajax_referer( 'ajax-register-nonce', 'register-security', false );

      // Nonce is checked, get the POST data and sign user on
      $user = array();
      $user['first_name'] = $_POST['first_name'];
      $user['last_name'] = $_POST['last_name'];
      $user['user_email'] = sanitize_email($_POST['user_email']);
      $user['user_login'] = sanitize_email($_POST['user_email']);
      $user['user_pass'] = $this->account_settings['account_password'];
      $user['role'] = $this->account_settings['user_role']; // if removed will default to new user default role set in Settings > General
      $user['remember'] = true;

      // Register Validation

      // Password Strength Critera
      $uppercase = preg_match('@[A-Z]@', $user['user_pass']);
      $number = preg_match('@[0-9]@', $user['user_pass']);

      // Validate First and Last Name
      if (empty($user['first_name']) || empty($user['last_name'])) {
        echo json_encode(array('registered'=>false, 'message'=> 'Please enter a first and last name.'));
      }
      // Validate Email
      elseif (!is_email($user['user_email'])) {
        echo json_encode(array('registered'=>false, 'message'=> 'Please enter a valid email address.'));
      }
      // Validate Email/Username Doesn't Exist
      elseif (username_exists( $user['user_email'] ) || email_exists( $user['user_email'])) {
        echo json_encode(array('registered'=>false, 'message'=>'An account with this email address already exists. Please use the link above to login.'));
      }
      // Validate Password Strength
      elseif (!$uppercase || !$number || strlen($user['user_pass']) < 8) {
        // Password is not strong enough
        echo json_encode( array('registered'=>false, 'message'=>  'Password should be at least 8 characters in length and should include at least one upper case letter and one number.') );
      }
      else {
        $user_id = wp_insert_user($user);
        if ($user_id) {
          // Log the user in
          $user_login_data = array(
            'user_login' => $user['user_email'],
            'user_password' => $user['user_pass'],
            'remember' => true,
          );
          $user_login = wp_signon($user_login_data, true);

          // If assigning user to additional roles
          #$the_user = new WP_User($user_id);
          #$the_user->add_role('user');

          // If RCP is enabled add user to membership(s)
          if ($this->rcp_module) {
            $this->rcp_module->add_membership($user_id);
            $this->rcp_module->update_custom_fields($user_id, $_POST);
          }

          // Register Event
          $this->event_register($_POST, $user_id);

          // Gravity Forms submission for better control of Admin notifications you can do so
          $gf_result = $this->event_gravity_form_notification($_POST, $user_id);

          // Send new regitration notification
          wp_new_user_notification($user_id, null, 'admin'); // 'admin', '' (empty string admin only), 'user', 'both'

          echo json_encode(array('status'=>true, 'message'=>'Register: Success, Form:' . $gf_result));
        }
        else {
          echo json_encode( array('registered'=>false, 'message'=>  'An error occurred. Please try again or contact us for assistance.') );
        }
      }
      die();
  }

  //////////////////////////////////////////////////////////////////////
  // Event Registration
  /////////////////////////////////////////////////////////////////////
  public function ajax_event_register(){

      // First check the nonce, if it fails the function will break
      // check_ajax_referer( 'ajax-register-nonce', 'register-security', false );

      // Nonce is checked, get the POST data and sign user on
      $current_user = wp_get_current_user();

      // Register Event
      $this->event_register($_POST, $current_user->ID);

      // Gravity Forms submission for better control of Admin notifications you can do so
      $gf_result = $this->event_gravity_form_notification($_POST, $current_user->ID);

      echo json_encode(array('status'=>true, 'message'=>'Register: Success, Form:' . $gf_result));

      die();
  }

  //////////////////////////////////////////////////////////////////////
  // Notifications - Update WP Notification Email Content Types
  /////////////////////////////////////////////////////////////////////
  public function set_email_content_type() {
    if(isset($GLOBALS["set_html_content_type"])) {
      return 'text/html';
    }
    else {
      return 'text/plain';
    }

  }

  //////////////////////////////////////////////////////////////////////
  // Notifications - Registration Email Override
  /////////////////////////////////////////////////////////////////////
  public function registration_email( $wp_new_user_notification_email, $user, $blogname ) {
    // Create new message
    if (in_array($this->account_settings['user_role'], $user->roles)) {
      $GLOBALS["set_html_content_type"] = true;
      $wp_new_user_notification_email['subject'] = sprintf( '[%s] Your credentials.', $blogname );
      $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');

      ob_start();
      $user_meta = get_user_meta($user->data->ID);
      $user_data = get_userdata($user->data->ID);
      $user_email = stripslashes( $user->user_email );
      $name = '';
      if (!empty($user_meta) && isset($user_meta['first_name'][0])) {
        $name = $user_meta['first_name'][0];
      }
      elseif (!empty($user_data)) {
        $name = $user_data->data->display_name;
      }
      include( locate_template( 'includes/account/notifications/register.php', false, false ) );
      $wp_new_user_notification_email['message'] = ob_get_clean();
    }

    return $wp_new_user_notification_email;
  }

  //////////////////////////////////////////////////////////////////////
  // Force Remove Admin Bar For Users
  /////////////////////////////////////////////////////////////////////
  public function remove_admin_bar() {
    if (current_user_can($this->account_settings['user_role'])) {
      show_admin_bar(false);
    }
  }

  //////////////////////////////////////////////////////////////////////
  // Redirect Members From Accessing WP Admin Dashboard or Profile Page
  /////////////////////////////////////////////////////////////////////
  public function admin_redirect() {
    $current_user = wp_get_current_user();
    $is_current_user_member = false;

    if (in_array($this->account_settings['user_role'], $current_user->roles) && !current_user_can('edit_pages')) {
      $is_current_user_member = true;
    }

    if (is_admin() && $is_current_user_member && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
      wp_safe_redirect(home_url());
      exit;
    }
  }

  //////////////////////////////////////////////////////////////////////
  // Add private/draft/future/pending pages to parent dropdown.
  /////////////////////////////////////////////////////////////////////
  public function private_draft_add_parents( $dropdown_args, $post = NULL ) {
      $dropdown_args['post_status'] = array( 'publish', 'draft', 'pending', 'future', 'private', );
      return $dropdown_args;
  }

  //////////////////////////////////////////////////////////////////////
  // Secure Redirects
  /////////////////////////////////////////////////////////////////////
  public function account_redirects() {

    // WP Private Post/Page Redirect to Custom Login instead of 404 Page Not Found (Role needs permission to "Read Private Posts/Pages")
    $queried_object = get_queried_object();
    if (isset($queried_object->post_status) && $queried_object->post_status == 'private' && !is_user_logged_in()) {
      wp_safe_redirect( add_query_arg( 'login', 'secure', get_permalink($this->account_settings['account_pages']['login']) ) );
      die;
    }

    // If user is logged in and goes to login page redirect to account area
    if (is_user_logged_in() && is_page($this->account_settings['account_pages']['login'])) {
      wp_safe_redirect(get_permalink($this->account_settings['account_pages']['dashboard']));
      die;
    }

  }

  //////////////////////////////////////////////////////////////////////
  // Account Shortcodes
  /////////////////////////////////////////////////////////////////////
  public function account_shortcode($atts) {
      ob_start();
      //set default attributes and values
      $values = shortcode_atts( array(
          'layout' => ''
      ), $atts );
      if ( $values['layout'] !== "" && locate_template( array( 'includes/account/layouts/'.$values['layout'].'.php' ) ) != ''  ) {
      	get_template_part( 'includes/account/layouts/'.$values['layout'] );
      }
      else {
      	return '<p>No Shortcode Found</p>';
      }
      return ob_get_clean();
  }


}

// Initiate Instance
new AD_Account();
