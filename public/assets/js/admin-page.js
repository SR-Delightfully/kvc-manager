function submitBtn(formElement, buttonId, action, method, name, inputName) {
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

        const url = `${window.APP_BASE_URL}/${action}${id}`;

        if (method.toUpperCase() === 'GET') {
            window.location.href = url;
            return;
        }

        if (form) {
            form.action = url;
            form.method = method.toUpperCase();
            form.submit();
        }
    });
}

//submitBtn('variant-form', 'view-variant', 'admin/variant/', 'GET', 'variant', 'variant_id');
submitBtn('variant-form', 'edit-variant', 'admin/variant/edit/', 'GET', 'variant', 'variant_id');
submitBtn('variant-form', 'delete-variant', 'admin/variant/delete/', 'GET', 'variant', 'variant_id');

//submitBtn('user-form', 'view-user', 'admin/users/', 'GET', 'user', 'user_id');
submitBtn('user-form', 'delete-user', 'admin/users/delete/', 'GET', 'user', 'user_id');


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
    // VARIANTS TABLE
    const tbody = document.getElementById('variantBody');
    const template = document.getElementById('defaultVariantsTemplate');

    if (tbody && template) {
        tbody.innerHTML = '';
        tbody.appendChild(template.content.cloneNode(true));
    }

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

    const debouncedSearch = debounce(performSearch, 300);
    searchInput.addEventListener('input', debouncedSearch);
    searchInput.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            searchInput.value = '';
            performSearch();
        }
    });

    const userSearchInput = document.getElementById('userSearchInput');
    const userTbody = document.getElementById('employeeBody');
    const userTemplate = document.getElementById('defaultUsersTemplate');

    if (userTbody && userTemplate) {
        userTbody.innerHTML = '';
        userTbody.appendChild(userTemplate.content.cloneNode(true));
    }

    userTbody.appendChild(userTemplate.content.cloneNode(true));

    const userStatusSelect = document.getElementById('userStatusFilter');

    async function performUserSearch() {
        const term = (userSearchInput ? userSearchInput.value.trim() : '');
        const role = (userStatusSelect && userStatusSelect.value && userStatusSelect.value !== 'Employee Status')
            ? userStatusSelect.value
            : '';

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
