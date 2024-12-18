<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        // Function to interact with each system via API
        
        async function checkLowStock() {
    try {
        const response = await fetch('inventory/api/get_low_stock.php'); // Path ke file PHP
        if (!response.ok) {
            throw new Error("Gagal mengambil data stok rendah");
        }

        const result = await response.json();
        if (result.low_stock && result.low_stock.length > 0) {
            let lowStockItems = "Notifikasi Stok Rendah:\n";
            result.low_stock.forEach(item => {
                lowStockItems += `- ${item.name} (Stok: ${item.stock})\n`;
            });
            alert(lowStockItems); // Menampilkan alert notifikasi
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat memuat notifikasi stok rendah.");
    }
}

document.addEventListener("DOMContentLoaded", () => {
    checkLowStock();
});




        
async function addItem() {
    const name = prompt("Enter item name:");
    const price = prompt("Enter item price:");

    if (!name || !price || isNaN(price)) {
        alert("Item name and a valid price are required!");
        return;
    }

    try {
        // Kirim data ke API
        const response = await fetch('inventory/api/add_item.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: name.trim(), price: parseFloat(price) })
        });

        const result = await response.json();

        // Tampilkan notifikasi stok atau pesan respons
        if (result.status === 'low_stock') {
            alert(result.message); // Notifikasi stok rendah
        } else if (result.status === 'available') {
            alert(result.message); // Stok tersedia
        }

        // Refresh tampilan item
        getItems();

    } catch (error) {
        console.error("Error:", error);
        alert("Failed to add item. Please try again.");
    }
}





        async function getItems() {
            const response = await fetch('inventory/api/get_items.php');
            const items = await response.json();
            let itemList = "<div class='row justify-content-center'>";
            items.forEach((item, index) => {
                itemList += `
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${item.name}</h5>
                            <p class="card-text">Price: Rp${item.price}</p>
                            <button class="btn btn-primary" onclick="checkout(${index})">Checkout</button>
                        </div>
                    </div>
                </div>`;
            });
            itemList += "</div>";
            document.getElementById("items").innerHTML = itemList;
        }

        async function checkout(itemIndex) {
            const response = await fetch('sales/api/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    item_index: itemIndex
                })
            });
            const result = await response.json();
            if (result.status === 'success') {
                alert("Item checked out, Order ID: " + result.order_id);
            }
        }

        async function trackOrder() {
            const orderId = prompt("Enter Order ID to track:");
            const response = await fetch('tracking/api/track_order.php?order_id=' + orderId);
            const result = await response.json();
            alert(result.status === 'error' ? result.message : `Order ID: ${result.order_id} - Status: ${result.status}`);
        }

        async function sendMessage() {
            const message = prompt("Enter your message:");
            if (!message || message.trim() === "") {
                alert("Message cannot be empty!");
                return;
            }

            try {
                const response = await fetch('chat/api/send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: message.trim()
                    })
                });

                if (!response.ok) {
                    throw new Error("HTTP error! status: " + response.status);
                }

                const result = await response.json();
                if (result.status === "success") {
                    alert("Message sent successfully!");
                } else {
                    alert("Error: " + result.message);
                }
            } catch (error) {
                alert("Failed to send message. Please try again.");
                console.error("Error:", error);
            }
        }



        async function getMessages() {
            const response = await fetch('chat/api/get_messages.php');
            const messages = await response.json();
            let messageList = "<div class='card'><div class='card-body'><h5 class='card-title'>Messages</h5>";
            messageList += "<ul class='list-group list-group-flush'>";
            messages.forEach((msg) => {
                messageList += `<li class="list-group-item"><strong>${msg.user}:</strong> ${msg.message}</li>`;
            });
            messageList += "</ul></div></div>";
            document.getElementById("messages").innerHTML = messageList;
        }
    </script>
</head>

<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Computer Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-outline-light" onclick="addItem()">Add Item to Inventory</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light" onclick="getItems()">View Items for Sale</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light" onclick="trackOrder()">Track Order</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light" onclick="sendMessage()">Send Chat Message</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light" onclick="getMessages()">Get Chat Messages</button>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-outline-light">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content area -->
    <div class="container mt-4">
        <div id="items"></div>
        <div id="messages" class="mt-4"></div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>