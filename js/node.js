const express = require('express');
const mongoose = require('mongoose');
const app = express();

// MongoDB Schema for Customer Data
const customerSchema = new mongoose.Schema({
    name: String,
    email: String,
    address: String,
    orderHistory: [
        {
            orderId: String,
            items: [String],
            total: String
        }
    ]
});

const Customer = mongoose.model('Customer', customerSchema);

// Endpoint to get customer data
app.get('/api/account/:userId', async (req, res) => {
    const customer = await Customer.findById(req.params.userId);
    if (customer) {
        res.json(customer);
    } else {
        res.status(404).send('Customer not found');
    }
});

// Start server
app.listen(3000, () => {
    console.log('Server running on port 3000');
});
