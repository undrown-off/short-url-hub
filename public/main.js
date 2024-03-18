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
  const showtable = document.querySelector(".app__output-show-table");
  const tableContainer = document.querySelector(".app__output-links-container");

  if (showtable && tableContainer) {
    showtable.addEventListener("click", () => {
      tableContainer.classList.toggle("active");
      showtable.innerHTML = tableContainer.classList.contains("active")
        ? "Скрыть детали:"
        : "Показать детали:";
    });
  }

  if (btn) {
    btn.addEventListener("click", () => {
      toClipboard(link);
      btn.innerHTML = "Copied";
      setTimeout(() => {
        btn.innerHTML = "Copy";
      }, 10000);
    });
  }
});
