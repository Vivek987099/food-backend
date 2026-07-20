document.querySelectorAll(".status-select").forEach((select) => {
    select.addEventListener("change", async (e) => {
        const status = e.target.value;
        const url = e.target.dataset.url;
        const response = await fetch(url, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({
                status: status,
            }),
        });
        const result = await response.json();
        if (result.status) {
            alert(result.message);
        }
    });
});

document.getElementById("search-user").addEventListener("input", (e) => {
    alert(e.target.value);
});
