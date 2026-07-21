const loadMonthlyOrders = async () => {
    const response = await fetch("http://localhost:8000/monthly-orders", {
        method: "GET",
    });
    const data = await response.json();
    if (data.status) {
        const month = data.monthly_orders.map((item) => item.month);
        const total = data.monthly_orders.map((item) => item.total);
        new Chart(document.querySelector("#monthly-orders"), {
            type: "line",
            data: {
                labels: month,
                datasets: [
                    {
                        label: "Monthly Orders",
                        data: total,
                        borderWidth: 1,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }
    console.log(data);
};
loadMonthlyOrders();
