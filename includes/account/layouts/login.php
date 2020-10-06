<section class="section section--bg section--bg-top section--bg-bottom section--bg-fullh pt10 pb10" style="background-image:url('/wp-content/uploads/colby-bg.jpg')">
  <div class="row row-site column">
    <div class="account-box">
      <div class="event-register">
        <div class="event-register__header">
          <h1 class="event-register__headline">Login</h1>
        </div>
        <form class="js-login" data-view="login" data-redirect="/my-schedule">
          <?php wp_nonce_field( 'ajax-login-nonce', 'login-security' ); ?>
          <div class="row column">
            <label for="LoginEmail">Email Address
            <input id="LoginEmail" type="email" name="username" placeholder="Enter Email" required />
            </label>
          </div>
          <div class="row column">
            <div class="alert"></div>
          </div>
          <div class="row column center">
            <button type="submit" class="btn-brush"><span>Login</span></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
