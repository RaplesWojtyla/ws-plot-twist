'use strict';

/**
 * navbar variables
 */

const navOpenBtn = document.querySelector("[data-menu-open-btn]");
const navCloseBtn = document.querySelector("[data-menu-close-btn]");
const navbar = document.querySelector("[data-navbar]");
const overlay = document.querySelector("[data-overlay]");

const navElemArr = [navOpenBtn, navCloseBtn, overlay];

for (let i = 0; i < navElemArr.length; i++) {

  navElemArr[i].addEventListener("click", function () {

    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
    document.body.classList.toggle("active");

  });

}



/**
 * header sticky
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {

  window.scrollY >= 10 ? header.classList.add("active") : header.classList.remove("active");

});

/**
 * go top
 */

const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {

  window.scrollY >= 500 ? goTopBtn.classList.add("active") : goTopBtn.classList.remove("active");

});

/**
 * Pagination
 */

document.addEventListener("DOMContentLoaded", function () {
  const itemsPerPage = 20;
  const moviesList = document.querySelector(".movies-list");
  const movies = Array.from(moviesList.children);
  const paginationBtns = document.querySelectorAll(".pagination-btn");
  let currentPage = 1;
  const totalPages = Math.ceil(movies.length / itemsPerPage);

  function showPage(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    
    movies.forEach((movie, index) => {
      movie.style.display = index >= start && index < end ? "block" : "none";
    });
  }

  function updatePagination() {
    paginationBtns.forEach(btn => {
      if (btn.dataset.page === "prev") {
        btn.disabled = currentPage === 1;
      } else if (btn.dataset.page === "next") {
        btn.disabled = currentPage === totalPages;
      } else {
        btn.classList.toggle("active", parseInt(btn.dataset.page) === currentPage);
      }
    });
  }

  paginationBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      const page = btn.dataset.page;
      if (page === "prev" && currentPage > 1) currentPage--;
      else if (page === "next" && currentPage < totalPages) currentPage++;
      else if (!isNaN(page)) currentPage = parseInt(page);

      showPage(currentPage);
      updatePagination();
    });
  });

  showPage(currentPage);
  updatePagination();
});


