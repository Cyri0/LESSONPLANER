$(document).ready(function() {
  $("#basic_datas_form").submit(function(e) {
      e.preventDefault();
      $.ajax( {
          url: "dataHandle.php",
          type: 'POST',
          data: $("form").serialize(),
          dataType: "text",
          success: function(strMessage) {
              alert(strMessage);
          },
          error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
          }
      });
      return false;
  });
});