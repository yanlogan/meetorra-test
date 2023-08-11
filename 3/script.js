$(document).ready(() => {
  $("#getData").click(() => {
    $.ajax({
      url: "data.php",
      success: (data) => {
        $("#content").html(data);
      },
    });
  });
});
