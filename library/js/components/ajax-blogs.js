import axios from "axios";

export default function ajaxBlogs($) {
  const btn = $(".ajax-blogs__load-more");

  if (typeof btn !== "undefined" && btn !== null) {
    btn.on("click", function () {
      // Set the button to loading state
      $(this).addClass("loading");

      let container = $(".ajax-blogs__posts");
      let current_page = parseInt($(".ajax-blogs__posts").attr("data-page"));
      let posts_per_page = parseInt($(".ajax-blogs__posts").data("per"));

      let params = new URLSearchParams();
      params.append("action", "load_more_posts");
      params.append("current_page", current_page);
      params.append("posts_per_page", posts_per_page);

      axios
        .post("/wp-admin/admin-ajax.php", params)
        .then((res) => {
          // Set the button to normal state
          $(this).removeClass("loading");

          let posts = res.data.data;
          let current_page = parseInt($(".ajax-blogs__posts").attr("data-page"));
          let max_pages = parseInt($(".ajax-blogs__posts").attr("data-max"));

          // Add new posts to content
          container.append(posts);

          // Remove button if max page is reached
          if (current_page == max_pages) {
            btn.remove();
          }
          // Increment page counter
          container.attr("data-page", current_page + 1);
        })
        .catch((e) => console.error(e));
    });
  }
}
