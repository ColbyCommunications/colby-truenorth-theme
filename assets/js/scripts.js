var Module = (function() {

  // Menu Selected States
  var _navSelectedState = function() {
    $(".menu a").each(function() {
      var $this = $(this);
      if ($this.attr('href') === window.location.pathname + window.location.search || $this.attr('href') === window.location.href) {
        $this.addClass('selected').parents('li').addClass('selected');
      }
    });
  };

  // Desktop Menu
  var _navFramework = function() {
    // Initialize Menu Plugin
    var menu = $(".menu").dropdown_menu({
      site_class: 'root',
      drawer_toggle_class: 'drawer-toggle',
      drawer_overlay_class: 'content-overlay',
      sub_indicator_class: 'menu-arrow',
      hover_class: 'drop-open',
      sub_indicators: true,
      touch_double_click: true,
      mobile_main_link_clickable: true,
      open_delay: 150,
      close_delay: 100
    });

    // Set global menu variable for accessibility function
    window.cd_menu = menu;

  }; // end nav framework

  var _techDetect = function() {
    var isMacLike = /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform);
    var isIOS = /(iPhone|iPod|iPad)/i.test(navigator.platform);

    if (isMacLike) {
      $("body").addClass("detect-mac");
    }
    else if (isIOS) {
      $("body").addClass("detect-ios");
    }

  };

  var _carousels = function() {

    // Hero Carousel
    $('.hero').slick({
      dots: false,
      autoplay: true,
      autoplaySpeed: 5000,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: 'linear',
      prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><span class="icon-angle-left"></span></button>',
      nextArrow: '<button type="button" class="slick-next" aria-label="Next"><span class="icon-angle-right"></span></button>'
    });

    // Gallery Carousel
    $('.js-gallery-carousel').slick({
      dots: false,
      infinite: false,
      arrows: true,
      speed: 300,
      autoplay: true,
      autoplaySpeed: 4000,
      slidesToShow: 1,
      pauseOnFocus: true,
      pauseOnHover: true,
      prevArrow: '<button type="button" aria-label="Previous" class="slick-prev"><span class="icon-angle-left"></span></button>',
      nextArrow: '<button type="button" aria-label="Next" class="slick-next"><span class="icon-angle-right"></span></button>'
    });

    // Card Carousel
    $('.js-card-carousel').each(function() {
      var $this = $(this);
      $this.slick({
        slidesToShow: 3,
        infinite: true,
        prevArrow: $this.closest(".card-carousel__slider").find('.card-carousel__arows .slick-prev'),
        nextArrow: $this.closest(".card-carousel__slider").find('.card-carousel__arows .slick-next'),
        dots: true,
        responsive: [{
            breakpoint: 960,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              infinite: true,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });
    });

  }; // end carousels

  var _selectDropdown = function() {
    $(".js-custom-select").select2({
      width: '100%',
      minimumResultsForSearch: Infinity
    });
  }; // end select dropdown

  var _postFilter = function() {

    var $filter_list = $(".js-ajax-load"),
      $filter_form = $(".js-post-filter"),
      $filter_clear = $filter_form.find(".js-filter-clear"),
      $filter_pagination = $(".js-pagination");

    if ($filter_list.length === 0) {
      return;
    }

    var filter_settings = {
      tax: ($filter_list.attr("data-tax")) ? $filter_list.attr("data-tax") : '', // On Filter Category Page
      query_template: ($filter_list.attr("data-filter-query")) ? $filter_list.attr("data-filter-query") : '', // Filter Query Template
      query_args: ($filter_list.attr("data-filter-args")) ? JSON.parse($filter_list.attr("data-filter-args")) : '', // Filter Args
      list_template: ($filter_list.attr("data-filter-list")) ? $filter_list.attr("data-filter-list") : '', // Filter List Template
      current_url: window.location.href, // Smart Pagination - Current URL
    };

    var ajaxFilter = function(filter_data) {
      // Add Loading Animation
      $("body").append('<div class="spinner"></div>');
      // Scroll Top
      var scroll = new SmoothScroll();
      var anchor = document.querySelector('#scroll-anchor');
      var options = {
        header: '.header',
        speed: 800,
        updateURL: false,
        offset: 100
      };
      scroll.animateScroll(anchor, null, options);

      // Ajax Filter
      $.ajax({
        type: 'GET',
        url: ajax_obj.ajaxurl,
        data: {
          action: 'ad_post_filter',
          query: filter_data,
          settings: filter_settings
        }
      }).done(function(response) {
        var $response = $(response);
        if ($response.find(".ajax-item").length) {
          $(".js-ajax-load").fadeOut(250, function() {
            $(this).html($response.filter(".ajax-load").html()).fadeIn(250);
          });
        } else {
          $(".js-ajax-load").fadeOut(250, function() {
            $(".js-ajax-load").html('<div class="alert-container"><div class="alert alert-info"><p>No results found. Please try your search again.</div></div>').fadeIn(250);
          });
        }

        // Load Updated Pagination
        if ($response.find(".pagination").length) {
          $(".js-pagination").html($response.filter(".ajax-load-pagination").html());
        } else {
          $(".js-pagination").html("");
        }

        // Remove Loading Animation
        $(".spinner").remove();

      });

    }; // end ajaxFilter

    var filterSubmit = function(form, context) {
      if (typeof context === 'undefined') {
        context = '';
      }

      var form_data = form.serializeArray();
      var filter_data = "";

      $.each(form_data, function(key, value) {
        if (value.value !== "") {
          var filter_sep = "&";
          if (filter_data === "") {
            filter_sep = "";
          }
          filter_data = filter_data + filter_sep + value.name + "=" + encodeURIComponent(value.value);
        }
      });

      var pagination_param = "pag";

      var $active_page = $filter_pagination.find(".pagination").attr("data-page-active");
      if ($active_page !== "" && context === "pagination") {
        if (filter_data === "") {
          filter_data = pagination_param + "=" + $active_page;
        } else {
          filter_data = filter_data + "&" + pagination_param + "=" + $active_page;
        }
      }

      var filter_data_url_params = filter_data;

      if (filter_data_url_params !== "") {
        filter_data_url_params = '?' + filter_data_url_params;
      }

      history.pushState(null, null, window.location.pathname + filter_data_url_params);

      // Smart Pagination Update Current URL
      filter_settings.current_url = "https://" + window.location.hostname + window.location.pathname + filter_data_url_params;

      if (filter_data !== "") {
        $filter_clear.addClass("post-grid__filter-clear--active");
      } else {
        $filter_clear.removeClass("post-grid__filter-clear--active");
      }

      ajaxFilter(filter_data);

    };

    var filterClear = function() {
      history.pushState(null, null, window.location.pathname);
      $filter_clear.removeClass("post-grid__filter-clear--active");
      $filter_form.find('input[type="checkbox"]').prop("checked", false);
      $filter_form.find('input[type="text"], select').each(function() {
        $(this).val("");
        $(this).trigger("change");
      });
    };

    // Update Form Filters on Forward/Back in Browser
    var updateFilters = function(filter_data) {

      function serializeStringToArray(data) {
        var filter_fields;
        var filter_json = [];
        if (data !== "" && data !== "undefined") {
          var filter_data_array = data.slice(data.indexOf('?') + 1).split('&');
          $.each(filter_data_array, function(i) {
            filter_fields = filter_data_array[i].split('=');
            if (filter_json[filter_fields[0]]) {
              if (!filter_json[filter_fields[0]].push) {
                filter_json[filter_fields[0]] = [filter_json[filter_fields[0]]];
              }
              filter_json[filter_fields[0]].push(decodeURIComponent(filter_fields[1]) || '');
            } else {
              filter_json[filter_fields[0]] = decodeURIComponent(filter_fields[1]) || '';
            }
          });
        }
        return filter_json;
      }

      var filter_json = serializeStringToArray(filter_data);

      // Update Form Filters
      $filter_form.find("input, select").each(function() {
        var $this = $(this);
        var filter_name = $this.attr("name");
        var filter_type = $this.attr("type");

        if (filter_json[filter_name]) {
          if (Array.isArray(filter_json[filter_name])) {
            $.each(filter_json[filter_name], function(i) {
              if ($this.val() === this) {
                $this.prop("checked", true);
              }
            });
          } else {
            if (filter_type === "checkbox" || filter_type === "radio") {
              if ($this.val() === filter_json[filter_name]) {
                $this.prop("checked", true);
              }
            } else {
              $this.val(filter_json[filter_name]);
            }
          }
        } else {
          if (filter_type === "checkbox" || filter_type === "radio") {
            $this.prop("checked", false);
          } else {
            $this.val("");
          }
        }
      });
    };

    // On Forward/Back in the Browser
    window.onpopstate = function(event) {
      // Get Current Filter Parameters
      var current_history = window.location.search;
      current_history = current_history.substring(1);
      var filter_data = current_history;
      // Update Form Filters
      updateFilters(filter_data);
      // Perform Ajax Fitler
      ajaxFilter(filter_data);
    };

    // On Form Submit
    $filter_form.submit(function(event) {
      event.preventDefault();
      filterSubmit($(this));
    });

    // Filter Select Submit
    $(".js-filter-select").change(function() {
      $filter_form.submit();
    });

    // Pagination Update
    $filter_pagination.on("click", "a", function(e) {
      e.preventDefault();
      $filter_pagination.find(".pagination").attr("data-page-active", $(this).attr("data-page"));
      filterSubmit($filter_form, "pagination");
    });

    // Clear Filter
    if (window.location.search !== "") {
      $filter_clear.addClass("post-grid__filter-clear--active");
    }

    $filter_clear.click(function() {
      filterClear();
    });

  }; // end post filter

  var _pagination = function() {

    $(document).on("click", ".pag-jump-label", function(e) {
      e.preventDefault();
      $(this).closest(".pag-jump").toggleClass("drop-active");
      $(this).closest(".pag-jump").find("ul").toggleClass("dropdown-active");
    });

    $(document).click(function(e) {
      if (!e) e = window.event;
      var target = e.target || e.srcElement;
      if ($(".pag-jump ul").is(':visible') && !$(target).closest($(".pag-jump")).length) {
        $(target).closest($(".pag-jump")).removeClass("drop-active");
        $(target).closest($(".pag-jump")).find("ul").removeClass("dropdown-active");
      }
    });

  }; // end pagination

  var _countdowns = function() {

    $('[data-countdown]').each(function() {
      var $this = $(this),
        finalDate = $(this).data('countdown');
      $this.countdown(finalDate, function(event) {
        $this.html(event.strftime('<span class="countdown__days">%-D day%!D</span> : <span class="countdown__hours">%-H Hour%!H</span> : <span class="countdown__minutes">%-M Minute%!M</span>'));
      });
    });

  }; // end countdowns

  var _account = function() {

    // Register Form
    $(".js-register").submit(function(e) {
      e.preventDefault();
      var $form = $(this),
        $form_alert = $form.find(".alert");

      // Disable Button
      $form.find('button[type="submit"]').attr("disabled", "disabled");

      // Append Loading Animation
      $("body").append('<div class="spinner"></div');

      // Set Loading Animation Variable
      var $spinner = $(".spinner");

      // Remove Previous Error Message
      $form_alert.removeClass("alert-danger animate-flicker").html("");

      // Form Object
      var form_data = new FormData(this);

      // Add in any File Uploads
      $form.find("[type=file]").each(function() {
        form_data.append($(this).attr("name"), this.files[0]);
      });

      $.ajax({
        type: 'POST',
        url: ajax_obj.ajaxurl,
        data: form_data,
        contentType: false,
        processData: false
      }).done(function(data) {
        var response = $.parseJSON(data);
        console.log(response);
        if (response.status) {
          if ($form.attr("data-redirect") && $form.attr("data-redirect") !== "") {
            // Redirect to URL
            window.location = $form.attr("data-redirect");
          } else {
            // Domain
            var domain = window.location.hostname;
            // Main Account Page
            var account_url = "/";
            // Current Page User is On
            var currentPath = window.location.pathname;
            // Standard redirect URL to current page
            var redirectUrl = window.location.href;
            // Array of URLs to Override login to current page and redirect to my account
            var redirectOverride = [];
            // If current page is in string array of overrides redirect to account area
            if ($.inArray(currentPath, redirectOverride) !== -1) {
              redirectUrl = "https://" + domain + account_url; // Replace with url to account landing page
            }
            // Redirect after login
            window.location = redirectUrl;
          }
        } else {
          $form.find('button[type="submit"]').removeAttr("disabled"); // Remove Disabled Attribute
          $form.find('input[name="password"]').val(""); // Clear Password Value
          $form_alert.addClass("alert-danger animate-flicker").html('<p>' + response.message + '</p>'); // Alert
          $spinner.remove(); // Remove Loading Indicator
        }
      }).fail(function() {
        $form.find('button[type="submit"]').removeAttr("disabled");
        $spinner.remove();
        $form_alert.addClass("alert-danger animate-flicker").html('<p>An error occured. Please try again or contact us for assistance'); // Alert
      });
    });

    // Login Form
    $(".js-login").submit(function(e) {
      e.preventDefault();
      var $form = $(this),
        $form_alert = $form.find(".alert");

      // Disable Button
      $form.find('button[type="submit"]').attr("disabled", "disabled");

      // Append Loading Animation
      $("body").append('<div class="spinner"></div');

      // Set Loading Animation Variable
      var $spinner = $(".spinner");

      // Remove Previous Error Message
      $form_alert.removeClass("alert-danger animate-flicker").html("");

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_obj.ajaxurl,
        data: {
          'action': 'ajax_login',
          'username': $form.find('input[name="username"]').val(),
          'login-security': $form.find('input[name="login-security"]').val(),
          'view': $form.attr("data-view")
        }
      }).done(function(response) {
        if (response.status) {
          if ($form.attr("data-redirect") && $form.attr("data-redirect") !== "") {
            // Redirect to URL
            window.location = $form.attr("data-redirect");
          } else {
            // Domain
            var domain = window.location.hostname;
            // Main Account Page
            var account_url = "/";
            // Current Page User is On
            var currentPath = window.location.pathname;
            // Standard redirect URL to current page
            var redirectUrl = window.location.href;
            // Array of URLs to Override login to current page and redirect to my account
            var redirectOverride = [];
            // If current page is in string array of overrides redirect to account area
            if ($.inArray(currentPath, redirectOverride) !== -1) {
              redirectUrl = "https://" + domain + account_url; // Replace with url to account landing page
            }
            // Redirect after login
            window.location = redirectUrl;
          }
        } else {
          $form.find('button[type="submit"]').removeAttr("disabled"); // Remove Disabled Attribute
          $form.find('input[name="password"]').val(""); // Clear Password Value
          $form_alert.addClass("alert-danger animate-flicker").html('<p>' + response.message + '</p>'); // Alert
          $spinner.remove(); // Remove Loading Indicator
        }
      }).fail(function() {
        $form.find('button[type="submit"]').removeAttr("disabled");
        $spinner.remove();
        $form_alert.addClass("alert-danger animate-flicker").html('<p>An error occured. Please try again or contact us for assistance'); // Alert
      });
    });

    // Logout Form
    $(".js-logout").click(function(e) {
      e.preventDefault();
      var $this = $(this);
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_obj.ajaxurl,
        data: {
          'action': 'ajax_logout',
          'logout-security': $this.attr("data-security")
        }
      }).done(function(response) {
        if (response.status) {
          if ($this.attr("data-redirect") && $this.attr("data-redirect") !== "") {
            // Redirect to URL
            window.location = $this.attr("data-redirect");
          } else {
            if (window.location.hash !== "") {
              window.location = window.location.pathname;
            } else {
              window.location = window.location.href;
            }

          }
        } else {
          //console.log(response.message);
        }
      });
    });

  }; // end account

  var _addToCal = function() {

    $(".addtocal").each(function() {
      var $this = $(this);
      var add_to_cal = createCalendar({
        data: {
          // Event title
          title: $this.find(".addtocal__data-title").text(),
          // Event start date
          start: new Date($this.find(".addtocal__data-start").text()),
          // Event duration (IN MINUTES)
          //duration: 120,
          // You can also choose to set an end time
          // If an end time is set, this will take precedence over duration
          end: new Date($this.find(".addtocal__data-end").text()),
          // Event Address
          address: $this.find(".addtocal__data-address").text(),
          // Event Description
          description: $this.find(".addtocal__data-description").html()
        }
      });

      $.each(add_to_cal, function(key, value) {
        $this.find(".addtocal__list").append('<li>' + value + '</li>');
      });

    });

  }; // end addToCal

  var _lightboxes = function() {

    // Videos
    $('.popup-video').magnificPopup({
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 500,
      preloader: false,
      fixedContentPos: false
    });

    $('.popup-video-embed').magnificPopup({
      type: 'inline',
      mainClass: 'mfp-fade popup-embed-container',
      removalDelay: 500,
      callbacks: {
        open: function() {
          var vidID = this.currItem.src;
          var vid = document.querySelector(vidID + " video");
          vid.play();
        },
        close: function() {
          var vidID = this.currItem.src;
          var vid = document.querySelector(vidID + " video");
          vid.pause();
        }
      }
    });

    $('.popup-image').magnificPopup({
      type: 'image',
      closeOnContentClick: true,
      mainClass: 'mfp-img-mobile mfp-fade',
      image: {
        verticalFit: true
      }
    });

    // Ajax Popup
    $('.ajax-popup, a[href^="#form-"]').click(function(event) {
      event.preventDefault();
      // Get Ajax Path
      var $popup = $(this),
        popup_path = $popup.attr("href");

      if (popup_path.match("^#form-")) {
        popup_path = popup_path.replace("#form-", "");
      } else {
        popup_path = popup_path.replace("#", "");
      }

      $.magnificPopup.open({
        type: 'ajax',
        items: {
          src: ajax_obj.ajaxurl
        },
        ajax: {
          settings: {
            type: 'POST',
            data: {
              action: 'ad_ajax_request',
              ajax_path: popup_path
            }
          }
        },
        callbacks: {
          ajaxContentAdded: function() {
            // Re-initialize form in popup
            if ($(this.content).find(".js-form-submit").length) {
              _formValidation();
            }
          }
        }
      });
    });

    // Inline Popup
    $('.popup-inline').magnificPopup({
      type: 'inline',
      midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
      callbacks: {
        open: function() {
          var target = $(this.st.el).attr("href");
          if (target.indexOf('team-') == 1) {
            window.location.hash = target;
          }
        }
      }
    });

    // Custom Close Button
    $(document).on("click", ".js-exit-popup", function() {
      $.magnificPopup.close();
    });

  }; // end lightboxes

  // Slide Toggle
  var _slideToggle = function() {
    var $slideContainer = $(".slide-toggle-container"),
      $slideToggle = $slideContainer.find(".slide-toggle");

    $slideToggle.click(function(e) {
      e.preventDefault();
      var $this = $(this);
      $this.toggleClass("active");
      $this.parents(".slide-toggle-container").find(".slide-content").slideToggle();
    });

    // Accessibility - Works on Enter
    $slideToggle.keypress(function(e) {
      var key = e.which;
      if (key === 32) {
        $(this).click();
        return false;
      }
    });

  }; // end slide toggle

  // Mail Spam
  var _mails = function() {
    // re configures mail links
    $('a[href^="mailto:"]').each(function() {
      var mail = $(this).attr('href').replace('mailto:', ''),
        replaced = mail.replace('/at/', '@');
      $(this).attr('href', 'mailto:' + replaced);
      if ($(this).text() === mail) {
        $(this).text(replaced);
      }
    });
  }; // end mail tweak

  // Initalize Private Methods
  var init = function() {
    _navSelectedState();
    _navFramework();
    _techDetect();
    _carousels();
    _selectDropdown();
    _postFilter();
    _pagination();
    _countdowns();
    _account();
    _addToCal();
    _lightboxes();
    _slideToggle();
    _mails();
  };

  // Self Invoke Init Function Any Other Public Methods
  return {
    init: init
  };

})();

// Run Init Public Method When Dom is Ready
$(function() {
  Module.init();
});
