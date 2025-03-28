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
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label for="productSearch" class="form-label">Search Product (by Name and Code)</label>
                                        <search-bar
                                            ref="searchBar"
                                            :is_barcode_mode="is_barcode_mode"
                                            :searchedData="products"
                                            :searchBy="['name', 'code']"
                                            :label="label"
                                            @selectedObj="getSelectedProduct"
                                        />
                                    </div>
                                    <!-- <div class="col-md-1 col-6">
                                        <label for="units" class="form-label">Stock</label>
                                        <input type="number" steps="any" id="units" class="form-control"
                                            placeholder="Units"  :value="selectedProduct.stock" readonly>
                                    </div> -->
                                    <div class="col-md-1 col-6">
                                        <label for="unitPrice" class="form-label">Price</label>
                                        <input type="number" steps="any" id="unitPrice" class="form-control"
                                            placeholder="Price" v-model="selectedProduct.price">
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" id="quantity" @input="validateQuantity(selectedProduct)" 
                                            class="form-control" placeholder="Qty"
                                            value="1" min="1" v-model="selectedProduct.quantity">
                                    </div>

                                    <div class="col-md-2 col-12 text-end mt-4">
                                        <button class="btn btn-primary w-100" id="add_item" @click="addItem"> Add Item</button>
                                    </div>    
                                </div>

                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="purchase" role="tabpanel">
                                            <product-table :tableObj="sale"></product-table>    
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="border rounded p-3 bg-light">
                                            <p class="mb-2 totals_text">
                                                <strong>Grand Total: </strong>
                                                <span id="grand-amount"
                                                    class="text-dark font-weight-bold">{{ totalAmount }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-primary" data-toggle="modal"
                                        data-target="#customerModal" @click="openCustomerModal">Sell</button>
                                </div>

                               <customer-modal v-if="is_customer_modal" :sale="sale" @close-modal="closeModal"></customer-modal>
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
            is_barcode_mode:false,
            is_customer_modal:false,
            products:[],
            label:'',
            selectedProduct:this.setDefault(),
            sale:this.setDefaultSale()
        };
    },
    methods: {
        validateQuantity(item) {
            if (item.quantity > item.stock) {
                item.quantity = item.stock; 
            }
        },
        openCustomerModal(){
            this.is_customer_modal=true;
        },
        getSelectedProduct(product){
            this.label = product.name
            this.selectedProduct = {...product}
        },
        addItem(){
            if(this.selectedProduct && this.selectedProduct.quantity > 0){
                 const existingProduct = this.sale.items.find(
                    item => item.id === this.selectedProduct.id 
                );
                if(existingProduct){
                   if (existingProduct.quantity + this.selectedProduct.quantity <= this.selectedProduct.stock) {
                        existingProduct.quantity += this.selectedProduct.quantity;
                        existingProduct.price += this.selectedProduct.price; 
                        existingProduct.amount += this.selectedProduct.quantity * this.selectedProduct.price;
                    } else {
                        this.errorToast("Not enough stock available!");
                    }
                }
                else{
                    const updateProduct = {
                           id: this.selectedProduct.id,
                           name: this.selectedProduct.name,
                           quantity:this.selectedProduct.quantity,
                           stock:this.selectedProduct.stock,
                           price: this.selectedProduct.price,
                           amount:this.selectedProduct.quantity * this.selectedProduct.price,
                           isEditingQuantity: false,
                           isEditingPrice: false,
                       };
                   this.sale.items.push(updateProduct);
                }
               this.selectedProduct = this.setDefault()
               this.label = ''
            }
            else{
                this.infoToast('Select the Product')
            }
        },
        setDefault(){
            return {
                id: '',
                name: '',
                price: '',
                quantity: '',
                code:'',
                stock:''
            }
        },
        setDefaultSale(){
            return {
                id: '',
                amount: '',
                items:[],
                customer:{
                    name:'',
                    phone:'',
                    email:'',
                    payment_method:'cash'
                }
            }
        },
        closeModal() {
            this.is_customer_modal = false;
            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
            this.sale = this.setDefaultSale();
            this.getProducts();
        },
        getProducts() {
            this.data_loading = true;
            axios({
                url: `/admin/get/optimized/products`,
                method: "GET",
            })
                .then((response) => {
                    this.data_loading = false;
                    this.products = response.data.map((product) => ({
                        ...product,
                        isVisible: ["code", "name"],
                    }));
                })
                .catch((error) => {
                    this.errorToast(error.response.error);
                });
        },
    },
    mounted() {
        this.getProducts()
    },
    computed: {
        totalAmount() {
            return this.sale?.items
                ? this.sale.items
                    .filter((obj) => obj.amount)
                    .reduce(
                    (acc, item) =>
                        acc + item.amount,
                    0
                    )
                    .toFixed(2)
                : "0.00";
            },
    },
    watch:{
        totalAmount(val){
            this.sale.amount=parseFloat(val);
        }
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