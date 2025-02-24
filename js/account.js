// Example of how you might get customer data (from an API or session)
const customerData = {
    name: 'John Doe',
    email: 'johndoe@example.com',
    address: '1234 Elm Street, Springfield, IL',
    orderHistory: [
        { orderId: '12345', items: ['Product 1', 'Product 2'], total: '$50' },
        { orderId: '12346', items: ['Product 3'], total: '$20' },
    ]
};

// Display the customer data
function displayCustomerData() {
    document.getElementById('user-name').innerText = customerData.name;
    document.getElementById('user-email').innerText = customerData.email;
    document.getElementById('user-address').innerText = customerData.address;

    const orderList = document.getElementById('order-list');
    customerData.orderHistory.forEach(order => {
        const orderItem = document.createElement('li');
        orderItem.innerHTML = `Order #${order.orderId} - Items: ${order.items.join(', ')} - Total: ${order.total}`;
        orderList.appendChild(orderItem);
    });
}

// Update the customer info (you'd send a request to your server)
function updateInfo() {
    alert("Update feature not implemented.");
}

// Call display function when the page loads
window.onload = displayCustomerData;
