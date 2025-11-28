function updateDateTime() {
    const now = new Date();
    const formatted = now.toLocaleString();
    document.getElementById("datetime-display").textContent = formatted;
}

setInterval(updateDateTime, 1000);
updateDateTime();

 const modal = document.getElementById("forgotPasswordModal");
    const closeBtn = document.querySelector(".close-forgot");

    // document.querySelectorAll("a").forEach(link => {
    //     if (link.textContent.includes("Forgot Password")) {
    //         link.addEventListener("click", (e) => {
    //             e.preventDefault();
    //             modal.style.display = "block";
    //         });
    //     }
    // });

    closeBtn.onclick = () => modal.style.display = "none";

    window.onclick = (e) => {
        if (e.target === modal) modal.style.display = "none";
    };
    function openForgotPasswordModal() {
    document.getElementById("forgotPasswordModal").style.display = "flex";
}

function closeForgotPasswordModal() {
    document.getElementById("forgotPasswordModal").style.display = "none";
}

function openNewPasswordModal() {
    // hide first modal
    document.getElementById("forgotPasswordModal").style.display = "none";
    // show second modal
    document.getElementById("new-password-modal").style.display = "flex";
}

function closeNewPasswordModal() {
    document.getElementById("new-password-modal").style.display = "none";
}
//email
// FORGOT EMAIL MODAL LOGIC
const forgotEmailModal = document.getElementById("forgotEmailModal");
const forgotEmailCloseBtn = forgotEmailModal.querySelector(".close-forgot");

// Open modal when clicking "Forgot Email" links
document.querySelectorAll("a").forEach(link => {
    if (link.textContent.includes("Forgot Email")) {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            forgotEmailModal.style.display = "flex";
        });
    }
});

// Close modal when clicking the X button
forgotEmailCloseBtn.onclick = () => {
    forgotEmailModal.style.display = "none";
};

// Close modal when clicking outside the modal box
window.onclick = (e) => {
    if (e.target === forgotEmailModal) {
        forgotEmailModal.style.display = "none";
    }
};


function openForgotEmailModal() {
    forgotEmailModal.style.display = "flex";
}

function closeForgotEmailModal() {
    forgotEmailModal.style.display = "none";
}
function openNewEmailModal() {
    // hide first modal
    document.getElementById("forgotEmailModal").style.display = "none";
    // show second modal
    document.getElementById("new-email-modal").style.display = "flex";
}

function closeNewEmailModal() {
    document.getElementById("new-email-modal").style.display = "none";
}
function sendForgotEmail() {
    // Close the first modal
    closeForgotEmailModal();

    // Open the second modal
    openNewEmailModal();
}
