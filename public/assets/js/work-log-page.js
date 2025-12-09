document.addEventListener('click', function (e) {
    const btn = e.target.closest('.variant-select-btn');
    if (!btn) return;

    const variantId = btn.dataset.variantId;
    const variantName = btn.dataset.variantName || btn.textContent.trim();

    // set hidden input used by the Start form
    const hiddenInput = document.getElementById('variant_id_hidden');
    if (hiddenInput) hiddenInput.value = variantId;

    // update any display element showing selected variant
    const disp = document.getElementById('variant_display');
    if (disp) {
        // if it's an input, set value, otherwise set textContent
        if (disp.tagName === 'INPUT' || disp.tagName === 'TEXTAREA') {
            disp.value = variantName;
        } else {
            disp.textContent = variantName;
        }
    }

    // optional: keep UX-safe backup
    try { sessionStorage.setItem('work_selected_variant', JSON.stringify({id: variantId, name: variantName})); } catch(e){}

    // close/hide the modal (client-side)
    const modal = document.getElementById('forgotPasswordModal');
    if (modal) modal.style.display = 'none'; // or modal.classList.add('hidden')

    // optional: inform server so show_variant_search becomes false on next server render
    // fetch('/work/variant/selected', { method: 'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({variant_id: variantId}) });
});
