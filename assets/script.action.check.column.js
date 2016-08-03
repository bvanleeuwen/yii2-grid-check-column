/**
 * Created by bvanleeuwen on 03/08/16.
 */

$(document).ready(function() {
   $(document).on('click', 'input.checkActionColumn', function() {
      // Get the model ID
      var iModelId = $(this).data('id');
      // Get the URL
      var sUrl = $(this).data('saveurl');

      // Make the call
      $.ajax({
         url: sUrl,
         type: "POST",
         context: this,
         data: {
            id: iModelId,
            _csrf: $('meta[name=csrf-token]').prop('content')
         },
         success: function (data, textStatus, jqXHR) {
            if (data.status === true) {
               $(this).parent().html(data.data.content);
            } else {
               $(this).prop('checked', false);
               alert(data.message);
            }
         },
         error: function (jqXHR, textStatus, errorThrown) {
            //if fails
         }
      });
   });
});