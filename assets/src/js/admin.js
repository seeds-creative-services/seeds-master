(function(Seeds, $, undefined) {


  'use strict';


  /**
   * @namespace Seeds
   * @method Seeds.Admin
   * @uses https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js
   * @uses https://kit.fontawesome.com/29f0ff1eb5.js
   * @description Google Analytics Events Handler
   * 
   */


  Seeds.Admin = {


    /**
     * @function Seeds.Admin.GutenbergAvailable
     * @description Sends an event to the Google Analytics API.
     */

    GutenbergAvailable: () => {

      return typeof wp !== 'undefined' && typeof wp.blocks !== 'undefined';

    },


    /**
     * @function Seeds.Admin.Initialize
     * @description Sends an event to the Google Analytics API.
     * @param optionalIcons [object]
     */

    Initialize: (optionalIcons = undefined) => {

      // Disallow plugin disabling.
      Seeds.Admin.DisableSeedsPlugins();

    },


    /**
     * @function Seeds.Admin.DisableSeedsPlugins
     * @description Disallow the removable and deactivation of Seeds plugins.
     * @param null
     */

    DisableSeedsPlugins: () => {

      if($('body').hasClass('plugins-php')) {

        $('table.plugins').find('tr[data-plugin]').each(i => {

          let $plugin = $('table.plugins tr[data-plugin]').eq(i);
          let author = $plugin.find('.plugin-version-author-uri').text();

          if(author.indexOf('Seeds Creative Services') >= 0) {

            $plugin.find('.row-actions span').each(a => {

              let $action = $plugin.find('.row-actions span').eq(a);
              let $checkbox = $plugin.find('input[type="checkbox"]');

              if($checkbox.length) {

                $checkbox.addClass('disabled');
                $checkbox.attr('disabled', 'disabled');

              }

              if($action.hasClass('delete')) {

                $action.hide();
                $plugin.find('.row-actions').append(`<span style='color:#bbb'>This plugin can not be deleted.</span>`);

              }

              if($action.hasClass('deactivate')) {

                $action.hide();
                $plugin.find('.row-actions').append(`<span style='color:#bbb'>This plugin can not be deactivated.</span>`);

              }

            });

          }

        });

      }

    }


  };


  $(window).on('load', () => {

    Seeds.Admin.Initialize();

  });


}(window.Seeds = window.Seeds || {}, jQuery));