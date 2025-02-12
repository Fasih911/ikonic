jQuery(document).ready(function ($) {
  $("#load-projects").click(function () {
    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url, // ✅ Use the correct URL
      data: { action: "get_architecture_projects" },
      success: function (response) {
        console.log(response);
        $("#projects-container").html(JSON.stringify(response, null, 2));
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  });
});
