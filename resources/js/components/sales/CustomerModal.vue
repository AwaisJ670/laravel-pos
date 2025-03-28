<template>
    <div>
        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form @submit.prevent="save">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="card-title text-bold text-capitalize form-title">Customer Information</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-content pb-3">
                                <div class="mb-3">
                                    <label for="customerName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="customerName"
                                        placeholder="Name" v-model="sale.customer.name">
                                </div>
                                <div class="mb-3">
                                    <label for="customerEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="customerEmail"
                                        placeholder="Email" v-model="sale.customer.email">
                                </div>
                                <div class="mb-3">
                                    <label for="customerPhone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="customerPhone"
                                        placeholder="+1234567890" v-model="sale.customer.phone">
                                </div>
                                <div class="mb-3">
                                    <label for="paymentMethod" class="form-label">Payment Method</label>
                                    <select class="form-control" id="paymentMethod" v-model="sale.customer.payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="mb-3" v-if="sale.customer.payment_method == 'card'">
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
                                    <input type="text" class="form-control" :value="sale.amount" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top border-primary">
                            <button type="button" 
                                class="btn btn-secondary"
                                data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit"
                                class="btn btn-success"
                            >
                                Confirm Sale
                                <span v-if="crud_loading" class="spinner-border spinner-border-sm"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
export default {
    name: 'customer-modal',
    props: [
        'sale'
    ],
    data() {
        return {
            crud_loading:false
        }
    },
    methods: {
        save() {
            this.crud_loading = true;
            axios({
                url:`/admin/sales`,
                method: 'POST',
                data: this.sale
            })
            .then(response => {
                this.successToast('Sale recorded successfully');
                this.$emit('close-modal')
            })
            .catch(error => {
                this.errorToast(error.response.error)
                this.crud_loading = false;
            })
        },
    },

}
</script>

<style scoped>

</style>
