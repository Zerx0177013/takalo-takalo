document.addEventListener("DOMContentLoaded", function () {
  // Event listeners pour les boutons "Échanger"
  document.querySelectorAll(".btn-exchange").forEach(function (button) {
    button.addEventListener("click", function () {
      const itemId = this.getAttribute("data-item-id");
      window.location.href = "/propositions?itemId=" + itemId;
    });
  });

  // Event listeners pour les boutons "Détails"
  document.querySelectorAll(".btn-details").forEach(function (button) {
    button.addEventListener("click", function () {
      const itemId = this.getAttribute("data-item-id");
      window.location.href = "/items/" + itemId;
    });
  });

  // Event listeners pour les boutons de suppression
  document.querySelectorAll(".delete-btn").forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.stopPropagation();

      const itemId = this.getAttribute("data-item-id");

      if (
        confirm(
          "Êtes-vous sûr de vouloir supprimer cet objet ? Cette action est irréversible.",
        )
      ) {
        fetch("/items/" + itemId, {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Supprimer l'élément du DOM avec une animation
              const itemCard = document.getElementById("item-" + itemId);
              itemCard.style.transition =
                "opacity 0.3s ease, transform 0.3s ease";
              itemCard.style.opacity = "0";
              itemCard.style.transform = "scale(0.8)";

              setTimeout(() => {
                itemCard.remove();
                // Vérifier s'il reste des items
                const grid = document.querySelector(".items-grid");
                if (grid.children.length === 0) {
                  location.reload();
                }
              }, 300);
            } else {
              alert(
                "Erreur lors de la suppression: " +
                  (data.message || "Erreur inconnue"),
              );
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("Erreur lors de la suppression de l'objet");
          });
      }
    });
  });
});
