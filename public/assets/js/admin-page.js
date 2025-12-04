function enableRowSelect(rowSelector, radioSelector) {
    document.querySelectorAll(rowSelector).forEach(row => {
        row.addEventListener("click", function (e) {
            // Prevent double-trigger when clicking the actual radio
            if (e.target.matches(radioSelector)) return;

            const radio = this.querySelector(radioSelector);
            if (radio) {
                radio.checked = true;
            }

            // Highlight selected row
            document.querySelectorAll(rowSelector).forEach(r => r.classList.remove("selected-row"));
            this.classList.add("selected-row");
        });
    });
}

enableRowSelect(".variant-row", '.variant-radio');
enableRowSelect('.user-row', '.user-radio');
enableRowSelect('.product-type-row', '.type-radio');

function submitBtn(formElement, buttonId, action, method, name, inputName) {
    const form = document.getElementById(formElement);
    const button = document.getElementById(buttonId);

    button.addEventListener('click', () => {
        const selected = document.querySelector('input[name='+ inputName +']:checked');
        if (!selected) {
            alert('Select a '+ name +' in the table.');
            return;
        }

        const variantId = selected.value;

        form.action = action + variantId;
        form.method = method.toUpperCase();

        form.submit();
    });
}

submitBtn('variant-form', 'view-variant', 'admin/variant/', 'GET', 'variant', 'variant_id');
submitBtn('variant-form', 'edit-variant', 'admin/variant/edit/', 'GET', 'variant', 'variant_id');
submitBtn('variant-form', 'delete-variant', 'admin/variant/delete/', 'GET', 'variant', 'variant_id');

submitBtn('user-form', 'view-user', 'admin/users/', 'GET', 'user', 'user_id');
submitBtn('user-form', 'delete-user', 'admin/users/delete/', 'GET', 'user', 'user_id');

submitBtn('product-type-form', 'edit-type', 'admin/type/edit/', 'GET', 'product type', 'product_type_id');
submitBtn('product-type-form', 'delete-type', 'admin/type/delete/', 'GET', 'product type', 'product_type_id');
