document.addEventListener("DOMContentLoaded", function () {
  const filterButtons = document.querySelectorAll(".filter-btn");
  const demandeCards = document.querySelectorAll(".demande-card");

  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      const filter = this.getAttribute("data-filter");

      demandeCards.forEach((card) => {
        const cardStatus = card.getAttribute("data-status");

        if (filter === "all") {
          card.style.display = "block";
        } else if (filter === cardStatus) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  });
});
