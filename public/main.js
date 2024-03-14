function toClipboard(link) {
  let textarea = document.createElement("textarea");
  textarea.value = link;
  textarea.style.position = "fixed";
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand("copy");
  document.body.removeChild(textarea);
}

document.addEventListener("DOMContentLoaded", function () {
  const btn = document.querySelector(".copy-btn");
  const link = document.querySelector(".app__output-short a");
  const showtable = document.querySelector(".app__output-show-table") ?? null;
  const table = document.querySelectorAll(".app__output-links") ?? null;

  if (showtable && table) {
    showtable.addEventListener("click", () => {
      table.forEach((t) => t.classList.toggle("active"));
    });
  }

  btn.addEventListener("click", () => {
    toClipboard(link);
    btn.innerHTML = "Copied";
    setTimeout(() => {
      btn.innerHTML = "Copy";
    }, 10000);
  });
});
