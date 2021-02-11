$(document).ready(function () {
  //editor
  ClassicEditor.create(document.querySelector("#body")).catch((error) => {
    console.error(error);
  });

  $("#selectAllBoxes").click(function (event) {
    if (this.checked) {
      $(".checkBoxes").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkBoxes").each(function () {
        this.checked = false;
      });
    }
  });

  const div_box = "<div id='load-screen'><div id='loading'></div></div>";

  $("body").prepend(div_box);

  $("#load-screen")
    .delay(500)
    .fadeOut(1000, () => $(this).remove());

  function loadOnlineUsers() {
    $.get("includes/functions.php?onlineusers=result", function (data) {
      $(".onlineusers").text(data);
    });
  }

  setInterval(function () {
    loadOnlineUsers();
  }),
    500;
});
