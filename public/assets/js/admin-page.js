function submitBtn(formElement, buttonId, action, method='GET', name='item', inputName='id') {
    const form = document.getElementById(formElement);
    const button = document.getElementById(buttonId);
    if (!button) return;

    button.addEventListener('click', (e) => {
        e.preventDefault();

        const selected = document.querySelector(`input[name="${inputName}"]:checked`);
        if (!selected) {
            alert('Select a ' + name + ' in the table.');
            return;
        }

        const id = selected.value;
        // build absolute URL
        const cleanedAction = String(action).replace(/^\/+/, '');
        const url = `${window.APP_BASE_URL}/${cleanedAction}${encodeURIComponent(id)}`;

        if ((method || 'GET').toUpperCase() === 'GET') {
            // navigate with GET
            window.location.href = url;
            return;
        }

        // for POST or other methods, use the provided form if available
        if (form) {
            form.action = url;
            form.method = method.toUpperCase();
            form.submit();
            return;
        }

        // fallback: send a fetch POST (optional)
        fetch(url, { method: method.toUpperCase(), credentials: 'same-origin' })
            .then(r => {
                if (r.redirected) window.location.href = r.url;
                else return r.text();
            })
            .catch(err => console.error('Action failed', err));
    });
}

//submitBtn('variant-form', 'view-variant', 'admin/variant/', 'GET', 'variant', 'variant_id');


//submitBtn('user-form', 'view-user', 'admin/users/', 'GET', 'user', 'user_id');


//submitBtn('product-type-form', 'edit-type', 'admin/type/edit/', 'GET', 'product type', 'product_type_id');
//submitBtn('product-type-form', 'delete-type', 'admin/type/delete/', 'GET', 'product type', 'product_type_id');

//submitBtn('product-form', 'view-product', 'admin/product/', 'GET', 'product', 'product_id');
//submitBtn('product-form', 'edit-product', 'admin/product/edit/', 'GET', 'product', 'product_id');
//submitBtn('product-form', 'delete-product', 'admin/product/delete/', 'GET', 'product', 'product_id');

//submitBtn('colour-form', 'view-colour', 'admin/colour/', 'GET', 'colour', 'colour_id');
//submitBtn('colour-form', 'edit-colour', 'admin/colour/edit/', 'GET', 'colour', 'colour_id');
//submitBtn('colour-form', 'delete-colour', 'admin/colour/delete/', 'GET', 'colour', 'colour_id');


function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

async function fetchVariants(searchTerm) {
    try {
        const params = new URLSearchParams();
        if (searchTerm) params.append('q', searchTerm);

        const response = await fetch(`${window.APP_BASE_URL}/api/variants/search?${params.toString()}`);

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const data = await response.json();
        return data.products || [];

    } catch (error) {
        console.error('Fetch error:', error);
        showError('Failed to load products. Please try again.');
        return [];
    }
}

function showError(message) {
    document.getElementById('variantResults').innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle"></i> ${message}
            </div>
        </div>
    `;
}


function renderVariants(products) {
    const tbody = document.getElementById('variantBody');

    //clear table
    tbody.innerHTML = '';

    if (products.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5">
                    <div class="alert alert-info m-0">
                        <i class="bi bi-info-circle"></i> No variants found.
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    products.forEach(product => {
        tbody.appendChild(createVariantRow(product));
    });
}

function createVariantRow(product) {
    const tr = document.createElement('tr');
    tr.className = "variant-row";

    tr.innerHTML = `
        <td>
            <input type="radio" name="variant_id"
                   value="${product.variant_id}"
                   class="variant-radio">
        </td>
        <td>${product.product_id}</td>
        <td>${product.colour_id}</td>
        <td>${product.unit_size}</td>
        <td>${escapeHtml(product.variant_description)}</td>
    `;

    return tr;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

//for users
async function fetchUsers(searchTerm, role = "") {
    const params = new URLSearchParams();
    if (searchTerm) params.append('q', searchTerm);
    if (role) params.append('user_status', role);

    try {
        const response = await fetch(`${window.APP_BASE_URL}/api/users/search?${params.toString()}`);

        if (!response.ok) throw new Error("Network error");

        const data = await response.json();
        return data.users || [];

    } catch (err) {
        console.error(err);
        return [];
    }
}

function createUserRow(user) {
    const tr = document.createElement('tr');
    tr.className = "user-row";

    let statusDot = "";
    if (user.user_status === "active") statusDot = '<span class="dot green"></span>';
    if (user.user_status === "leave") statusDot = '<span class="dot yellow"></span>';
    if (user.user_status === "terminated") statusDot = '<span class="dot red"></span>';

    tr.innerHTML = `
        <td><input type="radio" name="user_id" value="${user.user_id}" class="user-radio"></td>
        <td>${statusDot}</td>
        <td>${user.user_role}</td>
        <td>${user.first_name}</td>
        <td>${user.last_name}</td>
        <td>${user.phone}</td>
        <td>${user.email}</td>
        <td>${user.user_dc}</td>
    `;

    return tr;
}


document.addEventListener('DOMContentLoaded', function () {
    console.log("Binding edit-variant");
    submitBtn('variant-form', 'edit-variant', 'admin/variant/edit/', 'GET', 'variant', 'variant_id');
    submitBtn('variant-form', 'delete-variant', 'admin/variant/delete/', 'GET', 'variant', 'variant_id');
    // other tables (example)
    submitBtn('user-form', 'delete-user', 'admin/users/delete/', 'GET', 'user', 'user_id');

    // VARIANTS TABLE (guard nodes)
    const tbody = document.getElementById('variantBody');
    const template = document.getElementById('defaultVariantsTemplate');
    if (tbody && template && template.content) {
        tbody.appendChild(template.content.cloneNode(true));

        const searchInput = document.getElementById('searchInput');

        async function performSearch() {
            const searchTerm = searchInput.value.trim();
            if (searchTerm === '') {
                tbody.innerHTML = '';
                tbody.appendChild(template.content.cloneNode(true));
                return;
            }
            const products = await fetchVariants(searchTerm);
            renderVariants(products);
        }

        if (searchInput) {
            const debouncedSearch = debounce(performSearch, 300);
            searchInput.addEventListener('input', debouncedSearch);
            searchInput.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    performSearch();
                }
            });
        }
    }

    // USERS TABLE (guard nodes)
    const userSearchInput = document.querySelector('.employees-bottom .search');
    const userTbody = document.getElementById('employeeBody');
    const userTemplate = document.getElementById('defaultUsersTemplate');

    if (userTbody && userTemplate && userTemplate.content) {
        userTbody.appendChild(userTemplate.content.cloneNode(true));
    }

    const userStatusSelect = document.getElementById('userStatusFilter');

    async function performUserSearch() {
        const term = (userSearchInput ? userSearchInput.value.trim() : '');
        const role = (userStatusSelect && userStatusSelect.value && userStatusSelect.value !== 'Employee Status')
            ? userStatusSelect.value
            : '';

        if (!userTbody || !userTemplate) return;

        if (term === '' && role === '') {
            userTbody.innerHTML = '';
            userTbody.appendChild(userTemplate.content.cloneNode(true));
            return;
        }

        const users = await fetchUsers(term, role);
        userTbody.innerHTML = '';

        if (!users || users.length === 0) {
            userTbody.innerHTML = `<tr><td colspan="8">No users found.</td></tr>`;
            return;
        }

        users.forEach(u => userTbody.appendChild(createUserRow(u)));
    }

    if (userSearchInput) {
        const debouncedUserSearch = debounce(performUserSearch, 300);
        userSearchInput.addEventListener('input', debouncedUserSearch);
        userSearchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                userSearchInput.value = '';
                performUserSearch();
            }
        });
    }

    if (userStatusSelect) {
        userStatusSelect.addEventListener('change', () => {
            performUserSearch();
        });
    }
});



function enableRowSelectDelegated(containerOrSelector, rowSelector, radioSelector) {
    const container = (typeof containerOrSelector === 'string')
        ? document.querySelector(containerOrSelector)
        : (containerOrSelector instanceof Element || containerOrSelector instanceof Document)
            ? containerOrSelector
            : document;

    if (!container) return;

    container.addEventListener('click', function (e) {
        const row = e.target.closest(rowSelector);
        if (!row) return;

        const radio = row.querySelector(radioSelector);
        if (!radio) return;

        if (!e.target.matches(radioSelector)) {
            radio.checked = true;
        }

        container.querySelectorAll(rowSelector).forEach(r => r.classList.remove("selected-row"));
        row.classList.add("selected-row");
    });
}


enableRowSelectDelegated(document, ".variant-row", '.variant-radio');
enableRowSelectDelegated(document, '.user-row', '.user-radio');
//enableRowSelectDelegated(document, '.product-type-row', '.type-radio');
//enableRowSelectDelegated(document, '.product-row', '.product-radio');
//enableRowSelectDelegated(document, '.colour-row', '.colour-radio');

