<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h3 class="card-title text-bold text-capitalize">Sale Panel</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="productSearch" class="form-label">Search Product (by Name)</label>
                                        <input type="text" id="productSearch" class="form-control"
                                            placeholder="Enter product name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="productCodeSearch" class="form-label">Search Product (by
                                            Code)</label>
                                        <input type="text" id="productCodeSearch" class="form-control"
                                            placeholder="Enter product code">
                                    </div>
                                </div>

                                <div class="row g-3 align-items-end mt-1">
                                    <div class="col-md-3 col-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control" placeholder="Name" readonly>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <label for="unitPrice" class="form-label">Category</label>
                                        <input type="text" steps="any" id="category" class="form-control"
                                            placeholder="Price">
                                    </div>
                                    <div class="col-md-1 col-6">
                                        <label for="units" class="form-label">Stock</label>
                                        <input type="number" steps="any" id="units" class="form-control"
                                            placeholder="Units" readonly>
                                    </div>

                                    <div class="col-md-1 col-6">
                                        <label for="unitPrice" class="form-label">Price</label>
                                        <input type="number" steps="any" id="unitPrice" class="form-control"
                                            placeholder="Price">
                                    </div>

                                    <div class="col-md-2 col-6">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" id="quantity" class="form-control" placeholder="Qty"
                                            value="1" min="1">
                                    </div>

                                    <div class="col-md-2 col-12 text-end">
                                        <button class="btn btn-primary w-100" id="add_item">Add Item</button>
                                    </div>
                                </div>

                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="purchase" role="tabpanel">
                                        <table class="table table-bordered" id="items-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Qty</th>
                                                    <th>Product</th>
                                                    <th>U.Price</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products">
                                                <tr>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>Laptop</td>
                                                    <td>1200.00</td>
                                                    <td>2400.00</td>
                                                    <td><button class="btn btn-sm btn-danger">Remove</button></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>1</td>
                                                    <td>Mouse</td>
                                                    <td>25.00</td>
                                                    <td>25.00</td>
                                                    <td><button class="btn btn-sm btn-danger">Remove</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="border rounded p-3 bg-light">
                                            <p class="mb-2 totals_text">
                                                <strong>Grand Total: </strong>
                                                <span id="grand-amount"
                                                    class="text-dark font-weight-bold">2425.00</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#customerModal" @click="handleAddItemClick">Sell</button>
                                </div>

                                <div class="modal fade" id="customerModal" tabindex="-1"
                                    aria-labelledby="customerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5 class="modal-title " id="customerModalLabel">Customer Information
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="customerName" class="form-label">Customer Name</label>
                                                    <input type="text" class="form-control" id="customerName"
                                                        placeholder="Enter customer name" value="John Doe">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="customerPhone" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" id="customerPhone"
                                                        placeholder="Enter phone number" value="+1234567890">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="paymentMethod" class="form-label">Payment Method</label>
                                                    <select class="form-select" id="paymentMethod" ref="paymentMethod">
                                                        <option value="cash">Cash</option>
                                                        <option value="card">Card</option>
                                                        <option value="bank_transfer">Bank Transfer</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="cardDetails" ref="cardDetails">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="cardNumber" class="form-label">Card Number</label>
                                                            <input type="text" class="form-control" id="cardNumber"
                                                                placeholder="Enter card number" value="**** **** **** 4242">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="expiryDate" class="form-label">Expiry Date</label>
                                                            <input type="text" class="form-control" id="expiryDate"
                                                                placeholder="MM/YY">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="cvc" class="form-label">CVC</label>
                                                            <input type="text" class="form-control" id="cvc"
                                                                placeholder="CVC" maxlength="3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Amount to Pay</label>
                                                    <input type="text" class="form-control" value="2425.00" readonly>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success" id="confirmSale"
                                                    ref="confirmSale">Confirm Sale</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "SalePanel",
    data() {
        return {
            is_category_form_modal: false,
            modal_type: "",
            obj_id: null,
        };
    },
    methods: {
        handlePaymentMethodChange() {
            this.$refs.cardDetails.style.display = this.$refs.paymentMethod.value === 'card' ? 'block' : 'none';
        },
        confirmSale() {
            alert('Sale confirmed successfully!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('customerModal'));
            modal.hide();
        },
        handleAddItemClick() {
            const modal = new bootstrap.Modal(document.getElementById('customerModal'));
            modal.show();
        },
        closeModal() {
            this.is_category_form_modal = false;
        }
    },
    mounted() {
        this.$refs.paymentMethod.addEventListener('change', this.handlePaymentMethodChange);
        this.$refs.confirmSale.addEventListener('click', this.confirmSale);
        this.$refs.cardDetails.style.display = 'none';
    },
    beforeUnmount() {
        this.$refs.paymentMethod.removeEventListener('change', this.handlePaymentMethodChange);
        this.$refs.confirmSale.removeEventListener('click', this.confirmSale);
    }
};
</script>

<style scoped>
.modal-header {
    padding: 1rem 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.form-label {
    font-weight: 500;
}

.table th {
    font-weight: 600;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-success {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

#cardDetails {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 15px;
}

#cardDetails input {
    background: white;
}
</style>