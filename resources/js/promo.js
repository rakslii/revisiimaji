document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('promoModal');
    if (!modal) return;

    const promoSeen = localStorage.getItem('promoSeen');

    // JANGAN munculin kalau sudah pernah close
    if (promoSeen === 'true') return;

    setTimeout(() => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }, 2000);
});

window.closePromo = function () {
    const modal = document.getElementById('promoModal');
    if (!modal) return;

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    // FLAG PERMANEN
    localStorage.setItem('promoSeen', 'true');
};
