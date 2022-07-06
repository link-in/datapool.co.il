/**
 * tdl Framework
 *
 * WARNING: This file is part of the tdl Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @version: 1.0.0
 * @package  tdl/Admin Interface
 * @author   Themetdl
 * @link	 http://theme-tdl.com
 */

;(function ($) {
  'use strict'

  $(document).ready(function () {
    // show or hide megamenu fields on parent and child list items
    tdl_megamenu.menu_item_mouseup()
    tdl_megamenu.megamenu_status_update()
    tdl_megamenu.megamenu_fullwidth_update()
    tdl_megamenu.update_megamenu_fields()

    // setup automatic thumbnail handling
    $('.remove-tdl-megamenu-thumbnail').manage_thumbnail_display()
    $('.tdl-megamenu-thumbnail-image').css('display', 'block')
    $(".tdl-megamenu-thumbnail-image[src='']").css('display', 'none')

    // setup new media uploader frame
    tdl_media_frame_setup()
  })

  // "extending" wpNavMenu
  var tdl_megamenu = {
    menu_item_mouseup: function () {
      $(document).on('mouseup', '.menu-item-bar', function (event, ui) {
        if (!$(event.target).is('a')) {
          setTimeout(tdl_megamenu.update_megamenu_fields, 300)
        }
      })
    },

    megamenu_status_update: function () {
      $(document).on('click', '.edit-menu-item-megamenu-status', function () {
        var parent_li_item = $(this).parents('.menu-item:eq( 0 )')

        if ($(this).is(':checked')) {
          parent_li_item.addClass('tdl-megamenu')
        } else {
          parent_li_item.removeClass('tdl-megamenu')
        }

        tdl_megamenu.update_megamenu_fields()
      })
    },

    megamenu_fullwidth_update: function () {
      $(document).on('click', '.edit-menu-item-megamenu-width', function () {
        var parent_li_item = $(this).parents('.menu-item:eq( 0 )')

        if ($(this).is(':checked')) {
          parent_li_item.addClass('tdl-megamenu-fullwidth')
        } else {
          parent_li_item.removeClass('tdl-megamenu-fullwidth')
        }

        tdl_megamenu.update_megamenu_fields()
      })
    },

    update_megamenu_fields: function () {
      var menu_li_items = $('.menu-item')

      menu_li_items.each(function (i) {
        var megamenu_status = $('.edit-menu-item-megamenu-status', this)
        var megamenu_fullwidth = $('.edit-menu-item-megamenu-width', this)

        if (!$(this).is('.menu-item-depth-0')) {
          var check_against = menu_li_items.filter(':eq(' + (i - 1) + ')')

          if (check_against.is('.tdl-megamenu')) {
            megamenu_status.attr('checked', 'checked')
            $(this).addClass('tdl-megamenu')
          } else {
            megamenu_status.attr('checked', '')
            $(this).removeClass('tdl-megamenu')
          }

          if (check_against.is('.tdl-megamenu-fullwidth')) {
            megamenu_fullwidth.attr('checked', 'checked')
            $(this).addClass('tdl-megamenu-fullwidth')
          } else {
            megamenu_fullwidth.attr('checked', '')
            $(this).removeClass('tdl-megamenu-fullwidth')
          }
        } else {
          if (megamenu_status.attr('checked')) {
            $(this).addClass('tdl-megamenu')
          }

          if (megamenu_fullwidth.attr('checked')) {
            $(this).addClass('tdl-megamenu-fullwidth')
          }
        }
      })
    },
  }

  $.fn.manage_thumbnail_display = function (variables) {
    var button_id

    return this.on('click', function () {
      e.preventDefault()

      button_id = this.id.replace('tdl-media-remove-', '')
      $('#edit-menu-item-megamenu-thumbnail-' + button_id).val('')
      $('#tdl-media-img-' + button_id)
        .attr('src', '')
        .css('display', 'none')
    })
  }

  function tdl_media_frame_setup() {
    var tdl_media_frame
    var item_id

    $(document.body).on(
      'click.tdlOpenMediaManager',
      '.tdl-open-media',
      function (e) {
        e.preventDefault()

        item_id = this.id.replace('tdl-media-upload-', '')

        if (tdl_media_frame) {
          tdl_media_frame.open()
          return
        }

        tdl_media_frame = wp.media.frames.tdl_media_frame = wp.media({
          className: 'media-frame tdl-media-frame',
          frame: 'select',
          multiple: false,
          library: {
            type: 'image',
          },
        })

        tdl_media_frame.on('select', function () {
          var media_attachment = tdl_media_frame
            .state()
            .get('selection')
            .first()
            .toJSON()

          $('#edit-menu-item-megamenu-thumbnail-' + item_id).val(
            media_attachment.url
          )
          $('#tdl-media-img-' + item_id)
            .attr('src', media_attachment.url)
            .css('display', 'block')
        })

        tdl_media_frame.open()
      }
    )
  }
})(jQuery)
