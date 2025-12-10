function updateDateTime() {
    const now = new Date();
    const formatted = now.toLocaleString();
    document.getElementById("datetime-display").textContent = formatted;
}

setInterval(updateDateTime, 1000);
updateDateTime();

const modal = document.getElementById("forgotPasswordModal");
const closeBtn = document.querySelector(".close-forgot");

document.querySelectorAll("a").forEach((link) => {
    if (link.textContent.includes("Forgot Password")) {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            modal.style.display = "block";
        });
    }
});

closeBtn.onclick = () => (modal.style.display = "none");

window.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
});
function openForgotPasswordModal() {
    document.getElementById("forgotPasswordModal").style.display = "flex";
}

function closeForgotPasswordModal() {
    document.getElementById("forgotPasswordModal").style.display = "none";
}

function openNewPasswordModal() {

    document.getElementById("forgotPasswordModal").style.display = "none";

    document.getElementById("new-password-modal").style.display = "flex";
}

function closeNewPasswordModal() {
    document.getElementById("new-password-modal").style.display = "none";
}
//email
// FORGOT EMAIL MODAL LOGIC
const forgotEmailModal = document.getElementById("forgotEmailModal");
const forgotEmailCloseBtn = forgotEmailModal.querySelector(".close-forgot");


document.querySelectorAll("a").forEach((link) => {
    if (link.textContent.includes("Forgot Email")) {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            forgotEmailModal.style.display = "flex";
        });
    }
});


forgotEmailCloseBtn.onclick = () => {
    forgotEmailModal.style.display = "none";
};


window.addEventListener("click", (e) => {
    if (e.target === forgotEmailModal) {
        forgotEmailModal.style.display = "none";
    }
});

function openForgotEmailModal() {
    forgotEmailModal.style.display = "flex";
}

function closeForgotEmailModal() {
    forgotEmailModal.style.display = "none";
}
function openNewEmailModal() {

    document.getElementById("forgotEmailModal").style.display = "none";

    document.getElementById("new-email-modal").style.display = "flex";
}

function closeNewEmailModal() {
    document.getElementById("new-email-modal").style.display = "none";
}
function sendForgotEmail() {

    closeForgotEmailModal();


    openNewEmailModal();
}
function openMessageModal() {
    document.getElementById("new-email-modal").style.display = "flex";
}

function closeMessageModal() {
    document.getElementById("new-email-modal").style.display = "none";
}

function sendMessage() {
    closeMessageModal();
    document.getElementById("message-sent-modal").style.display = "flex";
}

function closeSuccessModal() {
    document.getElementById("message-sent-modal").style.display = "none";
}
//team members dropdown
function toggleTeam(header) {
    const wrapper = header.nextElementSibling;
    const arrow = header.querySelector(".team-arrow");

    if (wrapper.style.display === "block") {
        wrapper.style.display = "none";
        arrow.textContent = "▼";
    } else {
        wrapper.style.display = "block";
        arrow.textContent = "▲";
    }
}
// all time report page
function rpt_toggleDateDropdown() {
    const dd = document.getElementById("rpt-dateDropdown");
    dd.style.display = dd.style.display === "flex" ? "none" : "flex";
}

function rpt_setDateFilter(value) {
    document.getElementById("rpt-dateButton").innerText = "Choose Date: " + value;
    document.getElementById("rpt-dateDropdown").style.display = "none";
}

function rpt_toggleStation(header) {
    const details = header.nextElementSibling;
    const arrow = header.querySelector(".rpt-arrow");

    if (details.style.display === "block") {
        details.style.display = "none";
        arrow.textContent = "∨";
    } else {
        details.style.display = "block";
        arrow.textContent = "∧";
    }
}
