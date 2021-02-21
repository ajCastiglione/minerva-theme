export default function Front($) {
  const h = $(".target-heading");
  h.on("click", function () {
    console.log(this);
  });
}
