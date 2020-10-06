<?php

class AD_Account_RCP {

  private $account_settings = array();

  private $rcp_account_settings = array(
    'account_pages' => array(
      'access_denied' => 427,
    )
  );

  public function __construct($account_settings) {
    // Define global account settings
    $this->account_settings = $account_settings;
    // Adds Custom Fields to RCP Member Edit Admin Panel
    add_action('rcp_edit_member_after', array($this,'admin_custom_fields'));
    // Stores the information submitted during profile update
    add_action('rcp_edit_member', array($this,'update_custom_fields'), 10);
    // Secure Redirects
    add_action('template_redirect', array($this,'account_redirects'));
    // Always keep default roles
    add_action('remove_user_role', array($this,'always_keep_default_role'), 10, 2);
    // Add Custom Field Columns Headers to Export
    add_filter( 'rcp_export_csv_cols_members', array($this, 'members_export_headers'));
    // Add Custom Field Row Values to Export
    add_filter( 'rcp_export_memberships_get_data_row', array($this, 'members_export_row_values'), 10, 2 );
  }

  //////////////////////////////////////////////////////////////////////
  // Add new export columns
  //
  //  @param array $columns Default column headers.
  //  @return array
  /////////////////////////////////////////////////////////////////////
  public function members_export_headers( $columns ) {
    $columns['member_affiliation'] = __( 'Affiliation' );
    $columns['class_year'] = __( 'Class Year' );
    $columns['reason_attending'] = __( 'Reason for Attending' );

    return $columns;
  }

  //////////////////////////////////////////////////////////////////////
  //  Add custom field row values in export
  //
  //  @param array          $row        Array of data to be exported for the current membership.
  //  @param RCP_Membership $membership Membership object.
  //  @return array
  /////////////////////////////////////////////////////////////////////
  public function members_export_row_values( $row, $membership ) {
    $row['member_affiliation'] = get_user_meta( $membership->get_customer()->get_user_id(), 'rcp_member_affiliation', true );
    $row['class_year'] = get_user_meta( $membership->get_customer()->get_user_id(), 'rcp_member_class_year', true );
    $row['reason_attending'] = get_user_meta( $membership->get_customer()->get_user_id(), 'rcp_member_reason_attending', true );

    return $row;
  }


  //////////////////////////////////////////////////////////////////////
  // Register User to RCP Membership
  /////////////////////////////////////////////////////////////////////
  public function add_membership($user_id = '') {
    if (!empty($user_id)) {
      $customer_id = rcp_add_customer( array(
        'user_id' => $user_id
      ));
      $membership_id = rcp_add_membership( array(
        'customer_id' => 	$customer_id,
        'object_id' => 1, // Replace with secure zone ID to register user to
        'status' => 'active'
      ));
    }
  }


  //////////////////////////////////////////////////////////////////////
  // Adds Custom Fields to RCP Member Edit Admin Panel
  // Documentation: https://docs.restrictcontentpro.com/article/1720-creating-custom-registration-fields
  /////////////////////////////////////////////////////////////////////
  public function admin_custom_fields( $user_id = 0 ) {

    // Custom Field - Affiliation
    $rcp_member_affiliation_value = get_user_meta($user_id, 'rcp_member_affiliation', true );
    $rcp_member_affiliation_options = array('Alumni', 'Parent', 'Friends', 'Student', 'Faculty/Staff', 'Other');
    ?>
    <tr valign="top">
        <th scope="row" valign="top">
          <label for="rcp_member_affiliation">Affiliation</label>
        </th>
        <td>
          <select id="rcp_member_affiliation" name="rcp_member_affiliation">
            <option value="">-- Please Select --</option>
            <?php foreach ($rcp_member_affiliation_options as $value) : ?>
              <option value="<?php echo $value; ?>" <?php selected($rcp_member_affiliation_value, $value); ?>><?php echo $value; ?></option>
            <?php endforeach ;?>
          </select>
        </td>
    </tr>
    <?php

    // Custom Field - Class Year
    $member_class_year_value = get_user_meta( $user_id, 'rcp_member_class_year', true );
    ?>
  	<tr valign="top">
  		<th scope="row" valign="top">
  			<label for="rcp_member_class_year">Class Year</label>
  		</th>
  		<td>
  			<input name="rcp_member_class_year" id="rcp_member_class_year" type="text" value="<?php echo esc_attr( $member_class_year_value ); ?>"/>
  		</td>
  	</tr>
  	<?php

    // Custom Field - Reason for Attending
    $member_reason_attending_value = get_user_meta( $user_id, 'rcp_member_reason_attending', true );
    ?>
  	<tr valign="top">
  		<th scope="row" valign="top">
  			<label for="rcp_member_reason_attending">Other Reason For Attending</label>
  		</th>
  		<td>
  			<input name="rcp_member_reason_attending" id="rcp_member_reason_attending" type="text" value="<?php echo esc_attr( $member_reason_attending_value ); ?>"/>
  		</td>
  	</tr>
  	<?php

  }


  //////////////////////////////////////////////////////////////////////
  // Stores the information submitted during profile update
  // Documentation: https://docs.restrictcontentpro.com/article/1720-creating-custom-registration-fields
  /////////////////////////////////////////////////////////////////////
  public function update_custom_fields($user_id, $post = null) {

    // Save Custom Field - Affiliation
    if (isset($_POST['rcp_member_affiliation'])) {
        update_user_meta( $user_id, 'rcp_member_affiliation', sanitize_text_field( $_POST['rcp_member_affiliation'] ) );
    }

    // Save Custom Field - Class Year
    if(isset($_POST['rcp_member_class_year'])) {
  		update_user_meta($user_id, 'rcp_member_class_year', sanitize_text_field($_POST['rcp_member_class_year']));
  	}

    // Save Custom Field - Reason for Attending
    if(isset($_POST['rcp_member_reason_attending'])) {
  		update_user_meta($user_id, 'rcp_member_reason_attending', sanitize_text_field($_POST['rcp_member_reason_attending']));
  	}

  }

  //////////////////////////////////////////////////////////////////////
  // Secure Redirects
  /////////////////////////////////////////////////////////////////////
  public function account_redirects() {

    // If user is logged in and goes to event registration form that they're already registered for redirect them to event page
    $register_view = (get_query_var('register') === 'true') ? true : false;

    if ($register_view) {
      if (ad_registered_event(get_the_id())) {
        wp_safe_redirect(get_permalink(get_the_id()));
        die;
      }
    }

    // If user is logged in or not and navigates to live event page but is NOT registered redirect them to register form
    if (is_singular('events') && !$register_view) {
      $event_status = ad_event_status(get_field('show_event_start_date_time'), get_field('show_event_end_date_time'));
      if ($event_status === "Live" && !ad_registered_event(get_the_id())) {
        wp_safe_redirect( get_permalink(get_the_id()) . '?register=true' );
        die;
      }
    }

    // If user is not logged in and goes to access denied page redirect to login
    if (!is_user_logged_in() && is_page($this->rcp_account_settings['account_pages']['access_denied'])) {
      wp_safe_redirect(get_permalink($this->account_settings['account_pages']['login']));
      die;
    }

    // If user is not logged in and goes to secure page redirect to login page
    if (!is_user_logged_in() && !rcp_user_can_access(get_current_user_id(), get_the_ID())) {
      wp_safe_redirect(get_permalink($this->account_settings['account_pages']['login']));
      die;
    }

    // If user is logged in but doesn't have access to page redirect them to secure zone access denied
    if (is_user_logged_in() && !rcp_user_can_access(get_current_user_id(), get_the_ID())) {
      wp_safe_redirect(get_permalink($this->rcp_account_settings['account_pages']['access_denied']));
      die;
    }

  }

  //////////////////////////////////////////////////////////////////////
  // Whenever a role is removed from a user, check to make sure they still have the "default role". If not, re-add it.
  /**
   * @param int    $user_id      ID of the user the role was removed from.
   * @param string $removed_role The removed role.
   * @return void
   */
  /////////////////////////////////////////////////////////////////////
  public function always_keep_default_role($user_id, $removed_role) {

  	$default_role = get_option('default_role', $this->account_settings['user_role']);
  	$user = get_userdata( $user_id );

  	if (empty($user->roles) && !in_array($default_role, $user->roles)) {
  		$user->add_role($default_role);
  	}

  }



}
