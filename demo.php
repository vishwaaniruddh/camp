<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMP Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f4f7fc;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background: #222;
            padding-top: 20px;
            color: #fff;
        }
        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: #ddd;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #444;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">CAMP Dashboard</h4>
        <a href="#">📦 Inventory</a>
        <a href="#">🚀 Dispatch</a>
        <a href="#">🛠 Service</a>
        <a href="#">📊 Reports</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <!-- Cards -->
                <div class="col-md-3">
                    <div class="card p-3">
                        <h5>Total Spares</h5>
                        <h2>1,240</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <h5>Dispatched Items</h5>
                        <h2>320</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <h5>Installed ATMs</h5>
                        <h2>85</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <h5>Pending Requests</h5>
                        <h2>27</h2>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <canvas id="stockChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="dispatchChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inventory Chart
        new Chart(document.getElementById("stockChart"), {
            type: "bar",
            data: {
                labels: ["Adapters", "Batteries", "Cameras", "AI"],
                datasets: [{
                    label: "Stock Available",
                    data: [120, 80, 50, 20],
                    backgroundColor: ["#3498db", "#e74c3c", "#f1c40f", "#2ecc71"]
                }]
            }
        });

        // Dispatch Chart
        new Chart(document.getElementById("dispatchChart"), {
            type: "doughnut",
            data: {
                labels: ["Dispatched", "Remaining"],
                datasets: [{
                    data: [320, 920],
                    backgroundColor: ["#1abc9c", "#95a5a6"]
                }]
            }
        });
    </script>

</body>
</html>
