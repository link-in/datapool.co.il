/**
 *-----------------------------------------------------------------------------------------------
 * Main JS functionality. v1.2
 *-----------------------------------------------------------------------------------------------
 */
/*global jQuery,google */

var TDL = TDL || {}

;(function () {
  /////////////////////////////////////////////
  // HEADER
  /////////////////////////////////////////////

  TDL.header = {
    init: function () {
      'use strict'

      //add to cart button
      jQuery(
        '.product_after_shop_loop .product_type_simple.add_to_cart_button, .category-price-grid-list .product_type_simple.add_to_cart_button, .single_add_to_cart_button'
      ).prepend("<span class='button-loader'></span>")
      jQuery('.add_to_cart_button').one('click', function () {
        var add_to_cart_classes,
          add_to_cart_styles,
          that = jQuery(this)

        add_to_cart_classes = that.attr('class')
        add_to_cart_classes = add_to_cart_classes.replace(
          'add_to_cart_button',
          ''
        )

        add_to_cart_styles = that.attr('style')

        that.parent().on('DOMNodeInserted', function (e) {
          e.stopPropagation()

          if (jQuery(e.target).is('.added_to_cart')) {
            jQuery(e.target)
              .addClass(add_to_cart_classes)
              .removeClass('added_to_cart')
              .addClass('added_to_cart_button')
            jQuery(e.target).attr('style', add_to_cart_styles)
          }
        })
      })

      /*===================================================================================*/
      /*  Ajax add to cart
    /*===================================================================================*/

      jQuery(function ($) {
        'use strict'

        if (woodstock_scripts_vars.product_add_to_cart_ajax == '0') {
          return
        }

        $(document.body).on('submit', 'form.cart', function () {
          var $form = $(this),
            $button = $form.find('.single_add_to_cart_button'),
            url = $form.attr('action')
              ? $form.attr('action')
              : window.location.href,
            data = $form.serialize()

          if ($form.closest('div.product').hasClass('product-type-external')) {
            return
          }

          $button
            .removeClass('added')
            .addClass('loading disabled')
            .prop('disabled', true)

          if ($button.attr('name')) {
            data +=
              '&' +
              encodeURI($button.attr('name')) +
              '=' +
              encodeURI($button.attr('value'))
          }

          $.ajax({
            url: url,
            data:
              data +
              '&woodstock_add_to_cart_nonce=' +
              woodstock_scripts_vars.add_to_cart_nonce,
            method: $form.attr('method')
              ? $form.attr('method').toUpperCase()
              : 'POST',

            success: function (response) {
              $button
                .removeClass('loading disabled')
                .addClass('added')
                .prop('disabled', false)

              var $message = $(response).find(
                  '.woocommerce-error, .woocommerce-info, .woocommerce-message'
                ),
                $alert = $('.woodstock-woocommerce-alert')

              if ($message.hasClass('woocommerce-error')) {
                if ($message.length) {
                  if (!$alert.length) {
                    $alert = $(
                      '<div class="woodstock-woocommerce-alert"></div>'
                    )
                    $(document.body).append($alert)
                  }

                  $alert.html($message)
                  setTimeout(function () {
                    $alert.addClass('active')
                  }, 500)

                  setTimeout(function () {
                    $alert.removeClass('active')
                  }, 7000)

                  return
                }
              }

              if ($(response).find('.woocommerce-message').length) {
                $(document.body).trigger('added_to_cart')
              }

              if (!response) {
                window.location = currentURL
              }

              if (
                typeof wc_add_to_cart_params !== 'undefined' ||
                typeof wc_add_to_cart_params === null
              ) {
                if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                  window.location = wc_add_to_cart_params.cart_url
                  return
                }
              }

              $(document.body).trigger('updated_wc_div')
              $(document.body).on('wc_fragments_refreshed', function () {
                $button.removeClass('loading')

                $('.offcanvas_minicart').show()

                setTimeout(function () {
                  $('.offcanvas-right-content').hide()
                  $('#minicart-offcanvas').show()

                  offcanvas_right()
                }, 100)
              })
            },
          })

          return false
        })
      })

      /*===================================================================================*/
      /*  Page Loader
    /*===================================================================================*/
      jQuery(window).on('load', function () {
        // Animate loader off screen
        setTimeout(function () {
          jQuery('body').addClass('loaded')
        }, 2000)
      })

      // jQuery('.units-info').contents().unwrap();

      jQuery('.product_list_widget .product-name a').prependTo('.units-info')

      /*===================================================================================*/
      /*  Responsive Videos
    /*===================================================================================*/

      //responsive videos
      jQuery('.blog-content-area, .content-area').fitVids()

      /*===================================================================================*/
      /*  Product Quantity
    /*===================================================================================*/

      // Increase
      jQuery(document).on('click', '.qty-plus', function (e) {
        e.preventDefault()
        var quantityInput = jQuery(this).parents('.quantity').find('input.qty'),
          step = parseInt(quantityInput.attr('step'), 10),
          newValue = parseInt(quantityInput.val(), 10) + step,
          maxValue = parseInt(quantityInput.attr('max'), 10)

        if (!maxValue) {
          maxValue = 9999999999
        }

        if (newValue <= maxValue) {
          quantityInput.val(newValue)
          quantityInput.change()
        }
      })

      // Decrease
      jQuery(document).on('click', '.qty-minus', function (e) {
        e.preventDefault()
        var quantityInput = jQuery(this).parents('.quantity').find('input.qty'),
          step = parseInt(quantityInput.attr('step'), 10),
          newValue = parseInt(quantityInput.val(), 10) - step,
          minValue = parseInt(quantityInput.attr('min'), 10)

        if (!minValue) {
          minValue = 0
        }

        if (newValue >= minValue) {
          quantityInput.val(newValue)
          quantityInput.change()
        }
      })

      /*===================================================================================*/
      /*  Product Master Slider
    /*===================================================================================*/

      if (
        jQuery('.single-product-images .images').hasClass('ms-product-slider')
      ) {
        jQuery(
          '.single-product-images .single-images, .product_summary_thumbnails_wrapper'
        ).hide()
      }

      if (
        jQuery('.post_format-post-format-gallery .master-slider-gallery')
          .length > 0
      ) {
        jQuery('.gallery-slider-wrapper').hide()
      }

      /*===================================================================================*/
      /*  Gallery Caption
    /*===================================================================================*/

      jQuery('.gallery-item').each(function () {
        var that = jQuery(this)

        if (that.find('.gallery-caption').length > 0) {
          that.append('<span class="gallery-caption-trigger">i</span>')
        }
      })

      jQuery('.gallery-caption-trigger').on('mouseenter', function () {
        $(this).siblings('.gallery-caption').addClass('show')
      })

      jQuery('.gallery-caption-trigger').on('mouseleave', function () {
        jQuery(this).siblings('.gallery-caption').removeClass('show')
      })

      /*===================================================================================*/
      /*  Tooltip
    /*===================================================================================*/

      jQuery('.tooltip').tooltipster({
        delay: 50,
        contentAsHTML: true,
        touchDevices: false,
      })
      jQuery('.tip-bottom').tooltipster({
        position: 'bottom',
        delay: 50,
        contentAsHTML: true,
        touchDevices: false,
      })

      /*===================================================================================*/
      /*  YITH Wishlist
    /*===================================================================================*/
      if (
        typeof jQuery.blockUI !== 'undefined' ||
        typeof jQuery.blockUI === null
      ) {
        jQuery.blockUI.defaults.message = null
      }

      jQuery(document).ready(function () {
        jQuery('.add_to_wishlist').on('click', function () {
          jQuery(this).closest('.product-inner').block()
        })

        jQuery('.yith-wcwl-wishlistaddedbrowse > .feedback').on(
          'click',
          function () {
            var browseWishlistURL = jQuery(this).next().attr('href')
            window.location.href = browseWishlistURL
          }
        )
      })

      jQuery(document).on('added_to_wishlist', function () {
        jQuery('.product-inner').unblock()
      })

      /*===================================================================================*/
      /*  PRODUCT CATEGORIES TOGGLE
    /*===================================================================================*/

      jQuery(function () {
        jQuery('.wc-block-product-categories-list-item > a').each(function () {
          var $childIndicator = jQuery('<span class="child-indicator"></span>')

          if (jQuery(this).parent().children('ul').length) {
            jQuery(this).parent().addClass('cat-parent')
            jQuery(this).parent().children('ul').addClass('children')

            if (jQuery(this).siblings('.children').is(':visible')) {
              $childIndicator.addClass('open')
            }

            $childIndicator.on('click', function () {
              jQuery(this)
                .parent()
                .siblings('.children')
                .toggle('fast', function () {
                  if (jQuery(this).is(':visible')) {
                    $childIndicator.addClass('open')
                  } else {
                    $childIndicator.removeClass('open')
                  }
                })
              return false
            })

            jQuery(this).append($childIndicator)
          }
        })
      })

      jQuery(function () {
        jQuery('.product-categories-with-icon .cat-item > a').each(function () {
          var $childIndicator = jQuery('<span class="child-indicator"></span>')

          if (jQuery(this).parent().children('ul').length) {
            if (jQuery(this).siblings('.children').is(':visible')) {
              $childIndicator.addClass('open')
            }

            $childIndicator.on('click', function () {
              jQuery(this)
                .parent()
                .siblings('.children')
                .toggle('fast', function () {
                  if (jQuery(this).is(':visible')) {
                    $childIndicator.addClass('open')
                  } else {
                    $childIndicator.removeClass('open')
                  }
                })
              return false
            })

            jQuery(this).append($childIndicator)
          }
        })
      })

      jQuery(function ($) {
        'use strict'
        /*===================================================================================*/
        /*  Category Parallax
	    /*===================================================================================*/

        //category parallax
        function parallax_engine(cat_parallax_pos) {
          if (jQuery(window).innerWidth() > 1200) {
            jQuery('.site_header').css(
              'background-position',
              'center ' + parseInt(-150 + cat_parallax_pos / 1.8) + 'px'
            ) // this 200 value can be found in styles.css also
          } else {
            jQuery('.site_header').css('background-position', 'center center')
          }

          if (jQuery('.site_header').hasClass('without_parallax')) {
            jQuery('.site_header').css('background-position', 'center center')
          }
        }

        parallax_engine(jQuery(this).scrollTop())

        // function refreshBackgrounds(selector) {

        // 	jQuery.browser.chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase());
        // 	if (jQuery.browser.chrome) {
        // 		if (jQuery(selector).css("background-image") != "none") {
        // 			var oldBackgroundImage = $(selector).css("background-image");
        // 			jQuery(selector).css("background-image", oldBackgroundImage);
        // 		}
        // 	}
        // }

        // refreshBackgrounds(".off-content");

        jQuery(window).on('resize', function () {
          parallax_engine(jQuery(this).scrollTop())
          // refreshBackgrounds(".off-content");
        })

        jQuery(window).on('scroll', function () {
          parallax_engine(jQuery(this).scrollTop())
          // refreshBackgrounds(".off-content");
        })
      })

      // Attribute Swatches

      jQuery(function ($) {
        'use strict'

        $('body').on('tawcvs_initialized', function () {
          $('.variations_form').unbind('tawcvs_no_matching_variations')
          $('.variations_form').on(
            'tawcvs_no_matching_variations',
            function (event, $el) {
              event.preventDefault()
              $el.addClass('selected')

              $('.variations_form')
                .find('.woocommerce-variation.single_variation')
                .show()
              if (
                typeof wc_add_to_cart_variation_params !== 'undefined' ||
                typeof wc_add_to_cart_variation_params === null
              ) {
                $('.variations_form')
                  .find('.single_variation')
                  .slideDown(200)
                  .html(
                    '<p>' +
                      wc_add_to_cart_variation_params.i18n_no_matching_variations_text +
                      '</p>'
                  )
              }
            }
          )
        })

        $('body').on('click', '.ev-swatch-variation-image', function (e) {
          e.preventDefault()
          $(this).siblings('.ev-swatch-variation-image').removeClass('selected')
          $(this).addClass('selected')
          var imgSrc = $(this).data('src'),
            imgSrcSet = $(this).data('src-set'),
            $mainImages = $(this)
              .parents('li.product-item')
              .find('.product_thumbnail'),
            $image = $mainImages.find('img').first(),
            imgWidth = $image.first().width(),
            imgHeight = $image.first().height()

          $mainImages.addClass('image-loading')
          $mainImages.css({
            width: imgWidth,
            height: imgHeight,
            display: 'block',
          })

          $image.attr('src', imgSrc)

          if (imgSrcSet) {
            $image.attr('srcset', imgSrcSet)
          }

          $image.load(function () {
            $mainImages.removeClass('image-loading')
            $mainImages.removeAttr('style')
          })
        })
      })

      /*===================================================================================*/
      /*  WooCompare
	/*===================================================================================*/

      jQuery(document).on('click', '.compare', function (e) {
        jQuery.blockUI.defaults.message = null
        e.preventDefault()

        var button = jQuery(this),
          data = {
            _yitnonce_ajax: yith_woocompare.nonceadd,
            action: yith_woocompare.actionadd,
            id: button.data('product_id'),
            context: 'frontend',
          },
          widget_list = jQuery('.yith-woocompare-widget ul.products-list')

        // add ajax loader
        if (
          typeof woocommerce_params != 'undefined' ||
          typeof woocommerce_params === null
        ) {
          button.closest('.product-inner').block()
          widget_list.block()
        }

        jQuery.ajax({
          type: 'post',
          url: yith_woocompare.ajaxurl,
          data: data,
          dataType: 'json',
          success: function (response) {
            if (
              typeof woocommerce_params != 'undefined' ||
              typeof woocommerce_params === null
            ) {
              jQuery('.product-inner').unblock()
              widget_list.unblock()
            }

            button
              .addClass('added')
              .attr('href', woodstock_options.compare_page_url)
              .text(yith_woocompare.added_label)

            // add the product in the widget
            widget_list.html(response.widget_table)
          },
        })
      })

      /////////////////////////////////////////////
      // REMOVE BUTTON CLASS ON COMPARE BUTTON
      /////////////////////////////////////////////

      jQuery('.products-grid .product-item .compare-button a').removeClass(
        'button'
      )

      /////////////////////////////////////////////
      // OFF CANVAS
      /////////////////////////////////////////////

      var isCart = function () {
        return jQuery('body').hasClass('woocommerce-cart')
      }

      var isCheckout = function () {
        return jQuery('body').hasClass('woocommerce-checkout')
      }

      var offcanvas_open = false
      var offcanvas_from_left = false
      var offcanvas_from_right = false
      var window_width = jQuery(window).innerWidth()

      function offcanvas_left() {
        jQuery('.off-container').removeClass('slide-from-right')
        jQuery('.off-container').addClass('slide-from-left')
        jQuery('.off-container').addClass('off-menu-open')

        offcanvas_open = true
        offcanvas_from_left = true

        jQuery('.off-menu').addClass('open')
        jQuery('body').addClass('offcanvas_open offcanvas_from_left')

        jQuery('.nano').nanoScroller({ iOSNativeScrolling: true })
        jQuery('.product_navigation').addClass('hidden')
      }

      function offcanvas_right() {
        if (isCart() || isCheckout()) return false

        jQuery('.off-container').removeClass('slide-from-left')
        jQuery('.off-container').addClass('slide-from-right')
        jQuery('.off-container').addClass('off-menu-open')

        offcanvas_open = true
        offcanvas_from_right = true

        jQuery('.off-menu').addClass('open')
        jQuery('body').addClass('offcanvas_open offcanvas_from_right')

        jQuery('.nano').nanoScroller({ iOSNativeScrolling: true })
        jQuery('.product_navigation').addClass('hidden')
      }

      function offcanvas_close() {
        if (offcanvas_open === true) {
          jQuery('.off-container').removeClass('slide-from-left')
          jQuery('.off-container').removeClass('slide-from-right')
          jQuery('.off-container').removeClass('off-menu-open')

          offcanvas_open = false
          offcanvas_from_left = false
          offcanvas_from_right = false

          jQuery('#off-container').css('max-height', 'inherit')
          jQuery('.off-menu').removeClass('open')
          jQuery('body').removeClass(
            'offcanvas_open offcanvas_from_left offcanvas_from_right'
          )

          setTimeout(function () {
            jQuery('.slide-from-left').removeClass('filters')
            jQuery('.site-header-sticky').removeClass('offcanvas-active')
          }, 500)

          setTimeout(function () {
            jQuery('.product_navigation').removeClass('hidden')
          }, 1000)
        }
      }

      jQuery('.shop-bag').on('click', function (e) {
        if (woodstock_scripts_vars.minicart == '0') {
          return
        }

        if (!isCart() && !isCheckout()) e.preventDefault()

        jQuery('.offcanvas-right-content').hide()
        jQuery('#minicart-offcanvas').show()

        offcanvas_right()
      })

      jQuery('#button_offcanvas_sidebar_left').on('click', function () {
        jQuery('.offcanvas-left-content').hide()
        jQuery('.slide-from-left').addClass('filters')
        jQuery('#filters-offcanvas').show()

        offcanvas_left()
      })

      jQuery('.mobile-menu-button').on('click', function () {
        jQuery('.offcanvas-left-content').hide()
        jQuery('#mobiles-menu-offcanvas').show()

        offcanvas_left()
      })

      jQuery('.mobile-search-button').on('click', function () {
        jQuery('.offcanvas-left-content').hide()
        jQuery('#mobiles-menu-offcanvas').show()

        offcanvas_left()
        jQuery(
          '#mobiles-menu-offcanvas .l-search .woodstock-search-form form input[type=text]'
        ).focus()
      })

      jQuery('#off-container').on('click', '.off-drop-after', function (e) {
        e.preventDefault()
        offcanvas_close()
      })

      jQuery('#off-container').on(
        'click',
        '#minicart-offcanvas .close-icon, #mobiles-menu-offcanvas .close-icon, #filters-offcanvas .close-icon',
        function (e) {
          e.preventDefault()
          offcanvas_close()
        }
      )

      jQuery('.off-drop-after').swipe({
        swipeLeft: function (
          event,
          direction,
          distance,
          duration,
          fingerCount
        ) {
          offcanvas_close()
        },
        swipeRight: function (
          event,
          direction,
          distance,
          duration,
          fingerCount
        ) {
          offcanvas_close()
        },
        tap: function (event, direction, distance, duration, fingerCount) {
          offcanvas_close()
        },

        threshold: 0,
      })

      jQuery(window).on('scroll', function () {
        //mark this selector as visible
        jQuery(
          '.single_product_related.on_screen, #site-footer.on_screen'
        ).each(function (i, el) {
          if (jQuery(el).visible(true)) {
            jQuery(el).addClass('on_screen')
            handleNavigation()
          } else {
            jQuery(el).removeClass('on_screen')
            handleNavigation()
          }
        })
      })

      jQuery.fn.visible = function (partial) {
        var $t = jQuery(this),
          $w = jQuery(window),
          viewTop = $w.scrollTop(),
          viewBottom = viewTop + $w.height(),
          _top = $t.offset().top,
          _bottom = _top + $t.height(),
          compareTop = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom

        return compareBottom <= viewBottom && compareTop >= viewTop
      }

      //if is visible on screen add a class
      jQuery('.single_product_related').each(function (i, el) {
        if (jQuery(el).visible(true)) {
          jQuery(el).addClass('on_screen')
        }
      })

      function handleNavigation() {
        setTimeout(function () {
          if (jQuery(window).innerWidth() > 1000) {
            if (
              jQuery(
                '.single_product_related.on_screen, #site-footer.on_screen'
              )[0]
            ) {
              jQuery('#nav-thumbflip').hide()
            } else {
              jQuery('#nav-thumbflip').fadeIn(300)
            }
          } else {
            jQuery('#nav-thumbflip').hide()
          }
        }, 100)
      }
      handleNavigation()

      /////////////////////////////////////////////
      // SELECT CHANGE
      /////////////////////////////////////////////

      function handleSelect() {
        // var catalog_order_select = jQuery(".catalog-ordering .orderby, .widget select").select2({
        // 	minimumResultsForSearch: Infinity,
        // 	dropdownAutoWidth : true,
        // });

        // catalog_order_select.data('select2').$dropdown.addClass("orderby-drop");

        jQuery('.topbar-right .topbar-language-switcher').select2({
          allowClear: true,
          minimumResultsForSearch: -1,
          dropdownCssClass: 'topbar',
        })

        jQuery('.mob-language-and-currency .topbar-language-switcher').select2({
          allowClear: true,
          minimumResultsForSearch: -1,
          dropdownCssClass: 'sidebar',
        })

        jQuery('.catalog-ordering .orderby, .widget select').select2({
          allowClear: true,
          minimumResultsForSearch: -1,
          dropdownCssClass: 'orderby-drop',
        })

        jQuery('.catalog-ordering .count').select2({
          allowClear: true,
          minimumResultsForSearch: -1,
          dropdownCssClass: 'count-drop',
        })
      }

      handleSelect()

      jQuery('.single-product-infos .variations .value select').wrap(
        '<label class="variation-select"></label>'
      )

      //Language Switcher
      jQuery('.topbar-language-switcher').on('change', function () {
        window.location = jQuery(this).val()
      })

      /////////////////////////////////////////////
      // OWL SLIDER
      /////////////////////////////////////////////

      var owl = jQuery('.owl-carousel')
      owl.owlCarousel({
        rtl: woodstock_scripts_vars.rtl === 'true',
        nav: true, // Show next and prev buttons
        items: 1,
        dots: false,
        lazyLoad: true,
        navText: ['', ''],
      })

      owl.on('resize.owl.carousel', function (event) {
        jQuery.fn.matchHeight._update()
      })

      function owlres() {
        var $carousel = jQuery('.owl-carousel')
        $carousel.owlCarousel('invalidate', 'all').owlCarousel('refresh')
        jQuery.fn.matchHeight._update()
      }

      jQuery(window).on('load', function () {
        owlres()
      })

      /////////////////////////////////////////////
      // PREVIEW SLIDER
      /////////////////////////////////////////////

      var galleryItems = jQuery('.cd-gallery').children('li')

      galleryItems.each(function () {
        var container = jQuery(this),
          // create slider dots
          sliderDots = createSliderDots(container)
        //check if item is on sale

        // update slider when user clicks one of the dots
        sliderDots.on('click', function () {
          var selectedDot = jQuery(this)
          if (!selectedDot.hasClass('selected')) {
            var selectedPosition = selectedDot.index(),
              activePosition = container
                .find('.cd-item-wrapper .selected')
                .index()
            if (activePosition < selectedPosition) {
              nextSlide(container, sliderDots, selectedPosition)
            } else {
              prevSlide(container, sliderDots, selectedPosition)
            }
          }
        })

        // update slider on swipeleft
        container.find('.cd-item-wrapper').on('swipeleft', function () {
          var wrapper = jQuery(this)
          if (!wrapper.find('.selected').is(':last-child')) {
            var selectedPosition =
              container.find('.cd-item-wrapper .selected').index() + 1
            nextSlide(container, sliderDots)
          }
        })

        // update slider on swiperight
        container.find('.cd-item-wrapper').on('swiperight', function () {
          var wrapper = jQuery(this)
          if (!wrapper.find('.selected').is(':first-child')) {
            var selectedPosition =
              container.find('.cd-item-wrapper .selected').index() - 1
            prevSlide(container, sliderDots)
          }
        })

        // preview image hover effect - desktop only
        container.on('mouseover', '.move-right, .move-left', function (event) {
          hoverItem(jQuery(this), true)
        })
        container.on('mouseleave', '.move-right, .move-left', function (event) {
          hoverItem(jQuery(this), false)
        })

        // update slider when user clicks on the preview images
        container.on('click', '.move-right, .move-left', function (event) {
          event.preventDefault()
          if (jQuery(this).hasClass('move-right')) {
            var selectedPosition =
              container.find('.cd-item-wrapper .selected').index() + 1
            nextSlide(container, sliderDots)
          } else {
            var selectedPosition =
              container.find('.cd-item-wrapper .selected').index() - 1
            prevSlide(container, sliderDots)
          }
        })
      })

      function createSliderDots(container) {
        var dotsWrapper = jQuery('<ol class="cd-dots"></ol>').insertAfter(
          container.children('a')
        )
        container.find('.cd-item-wrapper li').each(function (index) {
          var dotWrapper =
              index == 0
                ? jQuery('<li class="selected"></li>')
                : jQuery('<li></li>'),
            dot = jQuery('<a href="#0"></a>').appendTo(dotWrapper)
          dotWrapper.appendTo(dotsWrapper)
          dot.text(index + 1)
        })
        return dotsWrapper.children('li')
      }

      function hoverItem(item, bool) {
        item.hasClass('move-right')
          ? item
              .toggleClass('hover', bool)
              .siblings('.selected, .move-left')
              .toggleClass('focus-on-right', bool)
          : item
              .toggleClass('hover', bool)
              .siblings('.selected, .move-right')
              .toggleClass('focus-on-left', bool)
      }

      function nextSlide(container, dots, n) {
        var visibleSlide = container.find('.cd-item-wrapper .selected'),
          navigationDot = container.find('.cd-dots .selected')
        if (typeof n === 'undefined') n = visibleSlide.index() + 1
        visibleSlide.removeClass('selected')
        container
          .find('.cd-item-wrapper li')
          .eq(n)
          .addClass('selected')
          .removeClass('move-right hover')
          .prevAll()
          .removeClass('move-right move-left focus-on-right')
          .addClass('hide-left')
          .end()
          .prev()
          .removeClass('hide-left')
          .addClass('move-left')
          .end()
          .next()
          .addClass('move-right')
        navigationDot.removeClass('selected')
        dots.eq(n).addClass('selected')
      }

      function prevSlide(container, dots, n) {
        var visibleSlide = container.find('.cd-item-wrapper .selected'),
          navigationDot = container.find('.cd-dots .selected')
        if (typeof n === 'undefined') n = visibleSlide.index() - 1
        visibleSlide.removeClass('selected focus-on-left')
        container
          .find('.cd-item-wrapper li')
          .eq(n)
          .addClass('selected')
          .removeClass('move-left hide-left hover')
          .nextAll()
          .removeClass('hide-left move-right move-left focus-on-left')
          .end()
          .next()
          .addClass('move-right')
          .end()
          .prev()
          .removeClass('hide-left')
          .addClass('move-left')
        navigationDot.removeClass('selected')
        dots.eq(n).addClass('selected')
      }

      /////////////////////////////////////////////
      // SHOP LAYOUT
      /////////////////////////////////////////////

      function shopLayoutSwitch() {
        var isSwitchingLayout = false

        jQuery(document).on('click', 'a.layout-opt', function (e) {
          e.preventDefault()

          var products = jQuery('#products'),
            laySwitch = jQuery('.shop-layout-opts'),
            selectedLayout = jQuery(this).data('layout'),
            defaultWidth = products.find('.product').first().data('width'),
            gridWidth = jQuery('.inner-page-wrap').hasClass('has-no-sidebar')
              ? 'col-sm-sf-5'
              : 'col-sm-3'

          if (
            jQuery(this).parent().data('display-type') == 'gallery' ||
            jQuery(this).parent().data('display-type') == 'gallery-bordered'
          ) {
            gridWidth = 'col-sm-2'
          }

          if (isSwitchingLayout) {
            return
          }

          isSwitchingLayout = true

          if (selectedLayout === 'grid') {
            laySwitch.find('.grid-icon').addClass('active')
            laySwitch.find('.list-icon').removeClass('active')
          } else if (selectedLayout === 'list') {
            laySwitch.find('.list-icon').addClass('active')
            laySwitch.find('.grid-icon').removeClass('active')
          }

          products.animate(
            {
              opacity: 0,
            },
            150
          )

          setTimeout(function () {
            if (selectedLayout === 'grid') {
              products.addClass('product-layout-grid')
              products.removeClass('product-layout-list')
              owlres()
            } else if (selectedLayout === 'list') {
              products.addClass('product-layout-list')
              products.removeClass('product-layout-grid')
              owlres()
            }

            products
              .find('.product')
              .removeClass(
                'product-layout-standard product-layout-list product-layout-grid product-layout-solo'
              )
            products
              .find('.product')
              .addClass('product-layout-' + selectedLayout)

            products.animate(
              {
                opacity: 1,
              },
              150
            )

            isSwitchingLayout = false
          }, 200)

          e.preventDefault()
        })
      }

      shopLayoutSwitch()

      /////////////////////////////////////////////
      // STYCKY HEADER
      /////////////////////////////////////////////

      jQuery('#header-st').headroom({
        offset: 0,
        tolerance: 10,
        classes: {
          initial: 'sticky-header',
          top: 'sticky-header-top',
          notTop: 'sticky-header-not-top',
          pinned: 'slideDown',
          unpinned: 'slideUp',
        },
      })

      jQuery(window).on('scroll', function () {
        if (jQuery(window).scrollTop() <= 250) {
          jQuery('#header-st').css({ top: '-100px' })
        } else {
          jQuery('#header-st').css({ top: '0px' })
          jQuery('body.admin-bar #header-st').css({ top: '32px' })
        }
      })

      if (jQuery('#wpadminbar').length > 0) {
        jQuery('#header-st').addClass('wpadminbar_onscreen')
      }

      // Second product image
      setTimeout(function () {
        jQuery('.product_thumbnail.with_second_image').css(
          'background-size',
          'cover'
        )
        jQuery('.product_thumbnail.with_second_image').addClass(
          'second_image_loaded'
        )
      }, 300)

      // Double Tap on Touch-screen devices
      // jQuery( '.product-inner' ).doubleTapToGo();

      jQuery('#nav > ul > li').on({
        mouseenter: function () {
          jQuery(this).children('a').addClass('hovered')
        },
        mouseleave: function () {
          jQuery(this).children('a').removeClass('hovered')
        },
      })

      // Calculate main menu dropdown submenu position
      if (jQuery.fn.tdl_position_menu_dropdown) {
        jQuery(
          '.tdl-navbar-nav .tdl-dropdown-menu, .tdl-navbar-nav .tdl-dropdown-menu li'
        ).on({
          mouseenter: function () {
            jQuery(this).tdl_position_menu_dropdown()
          },
        })

        jQuery('.tdl-navbar-nav .tdl-dropdown-menu > ul > li').each(
          function () {
            jQuery(this).walk_through_menu_items()
          }
        )

        jQuery(window).on('resize', function () {
          jQuery('.tdl-navbar-nav .tdl-dropdown-menu > ul > li').each(
            function () {
              jQuery(this).walk_through_menu_items()
            }
          )
        })
      }

      // Set overflow state of main nav items; done to get rid of menu overflow
      jQuery('.tdl-navbar-nav .tdl-dropdown-menu').on({
        mouseenter: function () {
          jQuery(this).css('overflow', 'visible')
        },
        mouseleave: function () {
          jQuery(this).css('overflow', '')
        },
      })

      // Activates the mega menu
      if (jQuery.fn.tdl_position_megamenu) {
        jQuery('.tdl-navbar-nav').tdl_position_megamenu()

        jQuery(window).resize(function () {
          jQuery('.tdl-navbar-nav').tdl_position_megamenu()
        })
      }

      //mobile menu
      jQuery('.mobile-navigation .menu-item-has-children').append(
        '<div class="more"><i class="fa fa-plus "></i></div>'
      )

      jQuery('.mobile-navigation').on('click', '.more', function (e) {
        e.stopPropagation()
        jQuery(this).parent().children('.sub-menu').toggleClass('open')
        jQuery(this).html(
          jQuery(this).html() == '<i class="fa fa-plus "></i>'
            ? '<i class="fa fa-minus "></i>'
            : '<i class="fa fa-plus "></i>'
        )
        jQuery('.nano').nanoScroller({ iOSNativeScrolling: true })
      })

      jQuery('.mobile-navigation').on('click', 'a', function (e) {
        // e.preventDefault();
        jQuery('.mobile-navigation').find('.sub-menu').removeClass('open')
        offcanvas_close()
      })

      // CART REMOVE PRODUCT

      jQuery(document).on('click', '#minicart-offcanvas .remove', function (e) {
        e.preventDefault()
        e.stopPropagation()

        var prod_id = jQuery(this).attr('data-product-id'),
          variation_id = jQuery(this).attr('data-variation-id'),
          prod_quantity = jQuery(this).attr('data-product-qty'),
          empty_bag_txt = jQuery('#minicart-offcanvas').attr(
            'data-empty-bag-txt'
          ),
          singular_item_txt = jQuery('#minicart-offcanvas').attr(
            'data-singular-item-txt'
          ),
          multiple_item_txt = jQuery('#minicart-offcanvas').attr(
            'data-multiple-item-txt'
          ),
          data = {
            action: 'tdl_cart_product_remove',
            product_id: prod_id,
            variation_id: variation_id,
          },
          ajaxURL = jQuery(this).attr('data-ajaxurl')

        jQuery('#minicart-offcanvas .loading-overlay').fadeIn(200)
        jQuery('.widget_shopping_cart_content')
          .removeClass('blurcontent-off')
          .addClass('blurcontent')

        jQuery.post(ajaxURL, data, function (response) {
          var cartTotal = response
          var cartcounter = 0

          jQuery('#minicart-offcanvas .loading-overlay').fadeOut(100)
          jQuery('#minicart-offcanvas .widget_shopping_cart_content')
            .removeClass('blurcontent')
            .addClass('blurcontent-off')
          jQuery(
            '#minicart-offcanvas .widget_shopping_cart_content'
          ).removeClass('blurcontent-off')

          cartcounter =
            parseInt(
              jQuery('.shopbag_items_number, .bag-items-number').first().text()
            ) - prod_quantity
          jQuery('.shop-bag .amount').replaceWith(cartTotal)
          jQuery('.total .amount').replaceWith(cartTotal)
          jQuery('.shopbag_items_number').text(cartcounter)
          jQuery('.bag-items-number').first().text(cartcounter)

          jQuery('.shopbag_items_number').each(function (index) {
            jQuery(this).text(cartcounter)
          })

          if (variation_id > 0) {
            jQuery('.product-var-id-' + variation_id).remove()
          } else {
            jQuery('.product-id-' + prod_id).remove()
          }

          if (cartcounter <= 0) {
            jQuery('#minicart-offcanvas .widget_shopping_cart_content').append(
              '<div class="cart-empty-offcanvas-banner offcanvas-empty-banner"><span id="empty-cart-offcanvas-box"></span></div><p class="cart-empty-text offcanvas-empty-text">' +
                empty_bag_txt +
                '</p>'
            )
            jQuery('#minicart-offcanvas .product_list_widget').remove()
            jQuery(
              '#minicart-offcanvas .widget_shopping_cart_content .total'
            ).remove()
            jQuery(
              '#minicart-offcanvas .widget_shopping_cart_content .buttons'
            ).remove()
            jQuery('.bag-items-number').text(
              cartcounter + ' ' + multiple_item_txt
            )
          } else {
            if (cartcounter == 1) {
              jQuery('.bag-items-number').text('1 ' + singular_item_txt)
            } else {
              jQuery('.bag-items-number').text(
                cartcounter + ' ' + multiple_item_txt
              )
            }
          }
        })

        return false
      })

      // AJAX SEARCH

      TDL.header.ajaxSearch()
    },

    ajaxSearch: function () {
      var escapeRegExChars = function (value) {
        return value.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&')
      }

      jQuery('form.woodstock-ajax-search').each(function () {
        var $this = jQuery(this),
          number = parseInt($this.data('count')),
          thumbnail = parseInt($this.data('thumbnail')),
          productCat = $this.find('[name="product_cat"]'),
          $results = $this.parent().find('.woodstock-search-results'),
          postType = $this.data('post_type'),
          url =
            woodstock_scripts_vars.ajaxurl + '?action=woodstock_ajax_search',
          price = parseInt($this.data('price'))

        if (number > 0) url += '&number=' + number
        url += '&post_type=' + postType

        $results.on('click', '.view-all-results', function () {
          $this.submit()
        })

        if (productCat.length && productCat.val() !== '') {
          url += '&product_cat=' + productCat.val()
        }

        $this.find('[type="text"]').devbridgeAutocomplete({
          serviceUrl: url,
          appendTo: $results,

          onSelect: function (suggestion) {
            if (suggestion.permalink.length > 0)
              window.location.href = suggestion.permalink
          },
          onSearchStart: function (query) {
            $this.addClass('search-loading')
          },
          beforeRender: function (container) {
            if (container[0].childElementCount > 2)
              jQuery(container).append(
                '<div class="view-all-results"><span>' +
                  woodstock_scripts_vars.all_results +
                  '</span></div>'
              )
          },
          onSearchComplete: function (query, suggestions) {
            $this.removeClass('search-loading')

            if (jQuery(window).width() >= 1024) {
              jQuery('.woodstock-scroll').nanoScroller({
                // paneClass: 'woodstock-scroll-pane',
                // sliderClass: 'woodstock-scroll-slider',
                // contentClass: 'woodstock-scroll-content',
                preventPageScrolling: false,
              })
            }

            jQuery(document).trigger('wood-images-loaded')
          },
          formatResult: function (suggestion, currentValue) {
            if (currentValue == '&') currentValue = '&#038;'
            var pattern = '(' + escapeRegExChars(currentValue) + ')',
              returnValue = ''

            if (thumbnail && suggestion.thumbnail) {
              returnValue +=
                ' <div class="suggestion-thumb">' +
                suggestion.thumbnail +
                '</div>'
            }

            returnValue +=
              '<h4 class="suggestion-title result-title">' +
              suggestion.value
                .replace(new RegExp(pattern, 'gi'), '<strong>$1</strong>')
                // .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/&lt;(\/?strong)&gt;/g, '<$1>') +
              '</h4>'

            if (suggestion.no_found)
              returnValue =
                '<div class="suggestion-title no-found-msg">' +
                suggestion.value +
                '</div>'

            if (price && suggestion.price) {
              returnValue +=
                ' <div class="suggestion-price price">' +
                suggestion.price +
                '</div>'
            }

            return returnValue
          },
        })

        if (productCat.length) {
          var searchForm = $this.find('[type="text"]').devbridgeAutocomplete(),
            serviceUrl =
              woodstock_scripts_vars.ajaxurl + '?action=woodstock_ajax_search'

          if (number > 0) serviceUrl += '&number=' + number
          serviceUrl += '&post_type=' + postType

          productCat.on('cat_selected', function () {
            if (productCat.val() != '') {
              searchForm.setOptions({
                serviceUrl: serviceUrl + '&product_cat=' + productCat.val(),
              })
            } else {
              searchForm.setOptions({
                serviceUrl: serviceUrl,
              })
            }

            searchForm.hide()
            searchForm.onValueChange()
          })
        }

        jQuery('body').on('click', function () {
          $this.find('[type="text"]').devbridgeAutocomplete('hide')
        })

        jQuery('.woodstock-search-results').on('click', function (e) {
          e.stopPropagation()
        })
      })
    },
  }

  /////////////////////////////////////////////
  // Product Image
  /////////////////////////////////////////////

  jQuery('body').hide().show() //fix invisible fonts on refresh.

  //Product Gallery zoom
  if (jQuery('.easyzoom').length) {
    if (jQuery(window).width() > 1024) {
      var $easyzoom = jQuery('.easyzoom').easyZoom({
        loadingNotice: '',
        errorNotice: '',
        preventClicks: false,
      })

      var easyzoom_api = $easyzoom.data('easyZoom')

      jQuery('.variations').on('change', 'select', function () {
        owl.trigger('to.owl.carousel', [0, 300])
        easyzoom_api.teardown()
        easyzoom_api._init()
      })
    }
  }

  //product thumbnails swiper
  var product_thumbnails_swiper_mode = 'vertical',
    slides_per_view = 'auto'

  if (jQuery('.single-product').hasClass('with-sidebar')) {
    product_thumbnails_swiper_mode = 'horizontal'
    slides_per_view = 5
  }

  var product_thumbnails_swiper = jQuery(
    '.product_thumbnails .swiper-container'
  ).swiper({
    slidesPerView: slides_per_view,
    watchActiveIndex: true,
    mousewheelControl: false,
    mode: product_thumbnails_swiper_mode,
    onSlideClick: function (swiper) {
      owl.trigger('to.owl.carousel', [
        product_thumbnails_swiper.clickedSlideIndex,
        300,
      ])
      for (var i = 0; i < product_thumbnails_swiper.slides.length; i++) {
        product_thumbnails_swiper.slides[i].style.opacity = 0.3
      }
      product_thumbnails_swiper.slides[
        product_thumbnails_swiper.clickedSlideIndex
      ].style.opacity = 1
      product_thumbnails_swiper.swipeTo(
        product_thumbnails_swiper.clickedSlideIndex - 1,
        300,
        ''
      )
    },
  })

  jQuery('.featured_img_temp').hide()

  //get carousel instance data and store it in variable owl
  var owl = jQuery('#product-images-carousel')

  owl.owlCarousel({
    rtl: woodstock_scripts_vars.rtl === 'true',
    nav: true, // Show next and prev buttons
    items: 1,
    dots: false,
    lazyLoad: true,
    navText: ['', ''],
    responsive: {
      0: {
        nav: false,
        dots: true,
      },
      600: {
        nav: false,
        dots: true,
      },
      1200: {
        nav: true,
      },
    },
  })

  owl.on('changed.owl.carousel', function (event) {
    /*jshint validthis: true */
    if (jQuery('.product_thumbnails').length) {
      var currentItem = event.item.index

      for (var i = 0; i < product_thumbnails_swiper.slides.length; i++) {
        product_thumbnails_swiper.slides[i].style.opacity = 0.3
        product_thumbnails_swiper.slides[i].css = 'active'
      }
      product_thumbnails_swiper.slides[currentItem].style.opacity = 1
      product_thumbnails_swiper.swipeTo(currentItem - 1, 300, '')
    }
  })

  jQuery('.variations').on('change', 'select', function () {
    owl.trigger('to.owl.carousel', [0, 300])
  })

  setTimeout(function () {
    jQuery(
      '.product_thumbnail.with_second_image .product_thumbnail_background'
    ).css('background-size', 'cover')
    jQuery('.product_thumbnail.with_second_image').addClass(
      'second_image_loaded'
    )
  }, 300)

  // visible products on vc tabs

  jQuery('.wpb_tour_tabs_wrapper').find('.products li').addClass('animate')

  jQuery('.ui-tabs-anchor').on('click', function () {
    jQuery(this)
      .parents('.wpb_tour_tabs_wrapper')
      .find('.products li')
      .addClass('animate')
  })

  // visible products on vc tour
  jQuery('.wpb_prev_slide a, .wpb_next_slide a, .wpb_tabs_nav a').on(
    'click',
    function () {
      jQuery(this)
        .parents('.wpb_tour_tabs_wrapper')
        .find('.products li')
        .addClass('animate')
    }
  )

  //if not IE add parallax
  //if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {}
  //else {
  // if (jQuery(window).outerWidth() > 1024) {
  //   jQuery(window).stellar({
  //     horizontalScrolling: false,
  //   })
  // }
  //}

  /////////////////////////////////////////////
  // Login/register
  /////////////////////////////////////////////

  var login_container = jQuery('.login-register-container')

  login_container.on('click', '.account-tab-link', function () {
    var that = jQuery(this),
      target = that.attr('href')

    that.parent().siblings().find('.account-tab-link').removeClass('current')
    that.addClass('current')

    jQuery(target)
      .siblings()
      .stop()
      .fadeOut(function () {
        jQuery(target).fadeIn()
      })

    return false
  })

  /////////////////////////////////////////////
  // FRESCO GALLERY
  /////////////////////////////////////////////

  jQuery('.gallery').each(function () {
    jQuery(this)
      .find('.fresco')
      .attr('data-fresco-group', jQuery(this).attr('id'))
  })

  /////////////////////////////////////////////
  // PRODUCT ITEM MATCH HEIGHT
  /////////////////////////////////////////////

  if (jQuery('ul.products-grid li.product-item').length == 1) {
    var setHeight = jQuery('.product-item').height()
    jQuery('.products-grid:not(.owl-carousel) .product-item').css(
      'height',
      setHeight
    )

    jQuery(document).ajaxComplete(function () {
      var setHeight = jQuery('.product-item').height()
      jQuery('.products-grid:not(.owl-carousel) .product-item').css(
        'height',
        setHeight
      )
    })
  }

  jQuery('.product-item').matchHeight()

  jQuery(document).ajaxComplete(function () {
    /* Add by supsystic */ if (
      jQuery('ul.products-grid li.product-item').length == 1
    ) {
      var setHeight = jQuery('.product-item').height()
      jQuery('.products-grid:not(.owl-carousel) .product-item').css(
        'height',
        setHeight
      )

      jQuery(document).ajaxComplete(function () {
        var setHeight = jQuery('.product-item').height()
        jQuery('.products-grid:not(.owl-carousel) .product-item').css(
          'height',
          setHeight
        )
      })
    }

    jQuery('.product-item').matchHeight()
  })

  jQuery(window).on('load', function () {
    /////////////////////////////////////////////
    // SUBMENU ADJUSTMENTS
    /////////////////////////////////////////////

    jQuery('#my-account li').on('mouseenter mouseleave', function (e) {
      var left
      var elm = jQuery('ul:first', this)
      var off = elm.offset()
      var l = off.left
      var w = elm.width()
      var docH = jQuery('#header-top-bar').height()
      var docW = jQuery('#header-top-bar').width()

      var isEntirelyVisible = l + w <= docW

      if (!isEntirelyVisible) {
        jQuery(this).addClass('edge')
      } else {
        jQuery(this).removeClass('edge')
      }
    })

    /////////////////////////////////////////////
    // PRODUCT ITEM HOVER
    /////////////////////////////////////////////

    jQuery('.product-item.product_hover_enable .product-inner').on({
      mouseenter: function () {
        jQuery(this).addClass('hover')
      },
      mouseleave: function () {
        jQuery(this).removeClass('hover')
      },
    })

    /////////////////////////////////////////////
    // PARALLAX HEADER
    /////////////////////////////////////////////

    // if (jQuery(window).outerWidth() > 1200) {
    //   jQuery.stellar({
    //     horizontalScrolling: false,
    //     verticalOffset: -50,
    //   })
    // }

    jQuery('.parallax, .single-post-header-bkg').addClass('loaded')
  })

  jQuery('.site_header.with_featured_img')
    .delay(700)
    .animate({ opacity: 1 }, 500)
  jQuery('.site_header.with_featured_img .site_header_overlay')
    .delay(1000)
    .animate({ opacity: 1 }, 700)

  /////////////////////////////////////////////
  // WOOCOMMERCE SHOW PRODUCTS
  /////////////////////////////////////////////

  jQuery('.woocommerce-viewing')
    .off('change')
    .on('change', 'select.count', function () {
      jQuery(this).closest('form').submit()
    })

  /////////////////////////////////////////////
  // NAVIGATION
  /////////////////////////////////////////////

  jQuery(window).on('resize', function () {
    'use strict'

    // position dropdown menu correctly
    jQuery.fn.tdl_position_menu_dropdown = function (variables) {
      if (!jQuery('body.rtl').length) {
        return jQuery(this)
          .children('.sub-menu')
          .each(function () {
            // reset attributes
            jQuery(this).removeAttr('style')
            jQuery(this).show()
            jQuery(this).removeData('shifted')

            var submenu = jQuery(this)

            if (submenu.length) {
              var submenu_position = submenu.offset(),
                submenu_left = submenu_position.left,
                submenu_top = submenu_position.top,
                submenu_height = submenu.height(),
                submenu_width = submenu.outerWidth(),
                submenu_bottom_edge = submenu_top + submenu_height,
                submenu_right_edge = submenu_left + submenu_width,
                browser_bottom_edge = jQuery(window).height(),
                browser_right_edge = jQuery(window).width()

              if (jQuery('#wpadminbar').length) {
                var admin_bar_height = jQuery('#wpadminbar').height()
              } else {
                var admin_bar_height = 0
              }

              // current submenu goes beyond browser's right edge
              if (submenu_right_edge > browser_right_edge) {
                //if there are 2 or more submenu parents position this submenu below last one
                if (
                  submenu
                    .parent()
                    .parent('.sub-menu')
                    .parent()
                    .parent('.sub-menu').length
                ) {
                  submenu.css({
                    left: '0',
                    top: submenu.parent().parent('.sub-menu').height(),
                  })

                  // first or second level submenu
                } else {
                  // first level submenu
                  if (!submenu.parent().parent('.sub-menu').length) {
                    submenu.css(
                      'left',
                      -1 * submenu_width + submenu.parent().width()
                    )

                    // second level submenu
                  } else {
                    submenu.css({
                      left: -1 * submenu_width,
                    })
                  }
                }

                submenu.data('shifted', 1)
                // parent submenu had to be shifted
              } else if (submenu.parent().parent('.sub-menu').length) {
                if (submenu.parent().parent('.sub-menu').data('shifted')) {
                  submenu.css('left', -1 * submenu_width)
                  submenu.data('shifted', 1)
                }
              }
            }
          })
      } else {
        return jQuery(this)
          .children('.sub-menu')
          .each(function () {
            // reset attributes
            jQuery(this).removeAttr('style')
            jQuery(this).removeData('shifted')

            var submenu = jQuery(this)

            if (submenu.length) {
              var submenu_position = submenu.offset(),
                submenu_left_edge = submenu_position.left,
                submenu_top = submenu_position.top,
                submenu_height = submenu.height(),
                submenu_width = submenu.outerWidth(),
                submenu_bottom_edge = submenu_top + submenu_height,
                browser_bottom_edge = jQuery(window).height()

              if (jQuery('#wpadminbar').length) {
                var admin_bar_height = jQuery('#wpadminbar').height()
              } else {
                var admin_bar_height = 0
              }

              if (jQuery('#side-header').length) {
                var side_header_top =
                  jQuery('#side-header').offset().top - admin_bar_height
              }

              // current submenu goes beyond browser's left edge
              if (submenu_left_edge < 0) {
                //if there are 2 or more submenu parents position this submenu below last one
                if (
                  submenu
                    .parent()
                    .parent('.sub-menu')
                    .parent()
                    .parent('.sub-menu').length
                ) {
                  if (js_local_vars.header_position == 'Right') {
                    submenu.css({
                      left: '0',
                      top: submenu.parent().parent('.sub-menu').height(),
                    })
                  } else {
                    submenu.css({
                      right: '0',
                      top: submenu.parent().parent('.sub-menu').height(),
                    })
                  }
                  // first or second level submenu
                } else {
                  // first level submenu
                  if (!submenu.parent().parent('.sub-menu').length) {
                    submenu.css(
                      'right',
                      -1 * submenu_width + submenu.parent().width()
                    )

                    // second level submenu
                  } else {
                    submenu.css({
                      right: -1 * submenu_width,
                    })
                  }
                }

                submenu.data('shifted', 1)
                // parent submenu had to be shifted
              } else if (submenu.parent().parent('.sub-menu').length) {
                if (submenu.parent().parent('.sub-menu').data('shifted')) {
                  submenu.css('right', -1 * submenu_width)
                }
              }
            }
          })
      }
    }

    // Recursive function for positioning menu items correctly on load
    jQuery.fn.walk_through_menu_items = function () {
      jQuery(this).tdl_position_menu_dropdown()

      if (jQuery(this).find('.sub-menu').length) {
        jQuery(this).find('.sub-menu li').walk_through_menu_items()
      } else {
        return
      }
    }

    // position mega menu correctly
    jQuery.fn.tdl_position_megamenu = function (variables) {
      var reference_elem = ''
      if (jQuery('.nav-container').length) {
        reference_elem = jQuery(this).parent('nav').parent()
      } else {
        reference_elem = jQuery(this).parent('nav')
      }

      if (jQuery(this).parent('nav').length) {
        var main_nav_container = reference_elem,
          main_nav_container_position = main_nav_container.offset(),
          main_nav_container_width = main_nav_container.width(),
          main_nav_container_left_edge = main_nav_container_position.left,
          main_nav_container_right_edge =
            main_nav_container_left_edge + main_nav_container_width

        return this.each(function () {
          jQuery(this)
            .children('li')
            .each(function () {
              var li_item = jQuery(this),
                li_item_position = li_item.offset(),
                megamenu_wrapper = li_item.find('.tdl-megamenu-wrapper'),
                megamenu_wrapper_width = megamenu_wrapper.outerWidth(),
                megamenu_wrapper_position = 5

              //check if there is a megamenu
              if (megamenu_wrapper.length) {
                megamenu_wrapper.removeAttr('style')

                if (
                  li_item_position.left + megamenu_wrapper_width >
                  main_nav_container_right_edge
                ) {
                  megamenu_wrapper_position =
                    -1 *
                    (li_item_position.left -
                      (main_nav_container_right_edge - megamenu_wrapper_width))
                  megamenu_wrapper.css('left', megamenu_wrapper_position)

                  if (jQuery('body.rtl').length) {
                    megamenu_wrapper.css('right', megamenu_wrapper_position)
                  }
                }
              }
            })
        })
      }
    }

    jQuery('#site-navigation > ul > .menu-item > .sub-menu').css(
      'left',
      '-15px'
    )
    var new_width = jQuery('#page-wrap.tdl-boxed .boxed-layout').width()
    jQuery('#header-st').width(new_width)
  })
  // .resize()

  /////////////////////////////////////////////
  // RELOAD FUNCTIONS
  /////////////////////////////////////////////

  TDL.reloadFunctions = {
    init: function () {
      // Remove title attributes from images to avoid showing on hover
      jQuery('img[title]').each(function () {
        jQuery(this).removeAttr('title')
      })

      // if (!isAppleDevice) {
      // 	jQuery('embed').show();
      // }

      // Animate Top Links
      jQuery('.animate-top').on('click', function (e) {
        e.preventDefault()
        jQuery('body,html').animate({ scrollTop: 0 }, 800, 'easeOutCubic')
      })
    },
    load: function () {},
  }

  /////////////////////////////////////////////
  // GLOBAL VARIABLES
  /////////////////////////////////////////////

  /////////////////////////////////////////////
  // LOAD + READY FUNCTION
  /////////////////////////////////////////////

  TDL.onReady = {
    init: function () {
      TDL.header.init()
      TDL.reloadFunctions.init()
    },
  }

  TDL.onLoad = {
    init: function () {
      TDL.reloadFunctions.load()
    },
  }

  jQuery(document).ready(TDL.onReady.init)
  jQuery(window).on('load', function () {
    TDL.onLoad.init
  })
})(jQuery)

window.onpageshow = function (event) {
  if (event.persisted) {
    window.location.reload()
  }
}
