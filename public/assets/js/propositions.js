
let selectedItemId = null;
let proposedItemId = null;
let selectedItemName = null;
let proposedItemName = null;

function confirmExchange(offeredItemId, requestedItemId, offeredItemName, requestedItemName) {
    selectedItemId = offeredItemId;
    proposedItemId = requestedItemId;
    selectedItemName = offeredItemName;
    proposedItemName = requestedItemName;

    document.getElementById('modalOfferedItem').textContent = offeredItemName;
    document.getElementById('modalRequestedItem').textContent = requestedItemName;

    document.getElementById('exchangeModal').classList.add('show');
}

function closeModal() {
    document.getElementById('exchangeModal').classList.remove('show');
}

function submitExchange() {
    // Send POST request to create exchange
    fetch('/exchange', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idObjetOffert: selectedItemId,
            idObjetDemande: proposedItemId
        })
    })
        .then(response => response.json())
        .then(data => {
            closeModal();
            if (data.success) {
                alert('✅ Demande d\'échange créée avec succès!');
                // Redirect to my-items or show success page
                setTimeout(() => {
                    window.location.href = '/my-items';
                }, 1500);
            } else {
                alert('❌ Erreur: ' + (data.message || 'Impossible de créer la demande'));
            }
        })
        .catch(error => {
            closeModal();
            console.error('Error:', error);
            alert('❌ Une erreur est survenue');
        });
}

// Close modal when clicking outside
document.getElementById('exchangeModal').addEventListener('click', function (event) {
    if (event.target === this) {
        closeModal();
    }
});