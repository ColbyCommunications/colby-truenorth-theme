$(function () {

	// Body Selector
	var $body = $("body");
	// Append Stlye Guide Nav
	$body.append('<div class="sg-fixed-nav"> <a class="text-button sg-snippets-toggle" href="#">Code Snippets</a><ol class="sg-toc"></ol></div><button class="sg-toggle button"></button>');
	// Add Stlye Guide Body Class
	$body.addClass("sg-body");
	// Style Guide Nav Selector
	var $sg_nav = $(".sg-fixed-nav");
	// Style Guide Nav Toggle
	$(".sg-toggle").click(function () {
		$body.toggleClass("sg-body--push");
	});
	// Style Guide Table of Contents
	$(".sg-section").each(function () {
		var $this = $(this),
			sg_section = $this.find(".sg-section__heading").attr("data-anchor");
		if (sg_section) {
			$sg_nav.find(".sg-toc").append('<li><a data-anchor="' + sg_section + '" href="#">' + sg_section + '</a></li>');
			if ($this.find(".sg-section__subheading").length) {
				$sg_nav.find('.sg-toc a[data-anchor="' + sg_section + '"]').parent().append('<ol></ol>');
				$this.find(".sg-section__subheading").each(function () {
					var $this = $(this),
						sg_sub_section = $this.attr("data-anchor");
					if (sg_sub_section) {
						$sg_nav.find('.sg-toc a[data-anchor="' + sg_section + '"]').parent().find("ol").append('<li><a data-anchor="' + sg_sub_section + '" href="#">' + sg_sub_section + '</a></li>');
					}
				});
			}
		}
	});
	// Style Guide Anchor
	var anchor_offset = 100; // Set this for the offset from the anchored section to give a little space and account for fixed header (if any)
	$(".sg-toc a").click(function (e) {
		e.preventDefault();
		var $this = $(this),
			anchor = $this.attr("data-anchor");
		$('html, body').animate({
			scrollTop: $('.sg-section [data-anchor="' + anchor + '"]').offset().top - anchor_offset
		}, 'slow');
	});
	// Style Guide Snippets Toggle
	var $sg_snippets_toggle = $sg_nav.find(".sg-snippets-toggle");
	// Set Style Guide Snippets Saved State on Load	
	if (localStorage.style_guide_snippets === "true") {
		$sg_snippets_toggle.addClass("active");
		$("code").toggleClass("active");
	}
	// Toggle Style Guide Snippets
	$sg_snippets_toggle.click(function (e) {
		e.preventDefault();
		var $this = $(this);
		// Toggle Stlye Guide Snippets Toggle
		$this.toggleClass("active");
		// Toggle Stlye Guide Snippets Visibility
		$("code").toggleClass("active");
		// Store in Local Storage
		if ($this.hasClass("active")) {
			localStorage.setItem("style_guide_snippets", "true");
		} else {
			localStorage.setItem("style_guide_snippets", "false");
		}
	});

});
