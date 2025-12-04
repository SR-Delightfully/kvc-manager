document.querySelectorAll(".variant-row").forEach(row => {
    row.addEventListener("click", function (e) {
        // Prevent double-trigger when radio itself is clicked
        if (e.target.tagName.toLowerCase() === "input") return;

        const radio = this.querySelector(".variant-radio");
        radio.checked = true;

        // Optional: Highlight selected row
        document.querySelectorAll(".variant-row").forEach(r => r.classList.remove("selected-row"));
        this.classList.add("selected-row");
    });
});

function submitBtn(formElement, buttonId, action, method) {
    const form = document.getElementById(formElement);
    const button = document.getElementById(buttonId);

    button.addEventListener('click', () => {
        const selected = document.querySelector('input[name="variant_id"]:checked');
        if (!selected) {
            alert('Select a variant in the table.');
            return;
        }

        const variantId = selected.value;

        form.action = action + variantId;
        form.method = method.toUpperCase();

        form.submit();
    });
}

submitBtn('variant-form', 'view-variant', 'admin/variant/', 'GET');
submitBtn('variant-form', 'edit-variant', 'admin/variant/edit/', 'GET');

function deleteShop(Id, thing) {
    console.log("deleting ShopId: " + Id);
    //NOTE: open the confrmation dialog

        Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete "+ thing +" with id: " + Id + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "includes/delete-shop.php?id=" +shopId;
                    }
                    window.location.href = "includes/delete-shop.php?id=" +shopId;
                });
            }
        });
}
