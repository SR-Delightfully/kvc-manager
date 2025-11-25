function updateDateTime() {
    const now = new Date();
    const formatted = now.toLocaleString();
    document.getElementById("datetime-display").textContent = formatted;
}

setInterval(updateDateTime, 1000);
updateDateTime();
