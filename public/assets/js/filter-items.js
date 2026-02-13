document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const categoryFilter = document.getElementById("categoryFilter");
  const itemCards = document.querySelectorAll(".item-card");

  function filterItems() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedCategory = categoryFilter.value;

    itemCards.forEach(function (card) {
      const itemName = card.getAttribute("data-name");
      const itemDescription = card.getAttribute("data-description");
      const itemCategory = card.getAttribute("data-category");

      const matchesSearch =
        itemName.includes(searchTerm) || itemDescription.includes(searchTerm);
      const matchesCategory =
        selectedCategory === "all" || itemCategory === selectedCategory;

      if (matchesSearch && matchesCategory) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  }

  searchInput.addEventListener("input", filterItems);
  categoryFilter.addEventListener("change", filterItems);
});
