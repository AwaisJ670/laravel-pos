<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h3 class="card-title text-bold text-capitalize">Products</h3>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-primary btn-sm rounded-lg" data-toggle="modal"
                                            data-target="#productFormModal" @click="openModal('add', null)">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label class="mb-0">Search</label>
                                            <input type="text" class="form-control" placeholder="Search By Name" v-model="search" />
                                        </div>
                                    </div>
                                </div>
                                <table id="table" class="table table-sm table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th class="w-rem-5 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(obj, index) in filterData" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td class="align-middle">
                                                <img
                                                :src="
                                                    obj.image
                                                    ? `/storage/products_images/${obj.image}`
                                                    : '/images/dummy-product.png'
                                                "
                                                alt="Product Image"
                                                width="30px"
                                                height="30px"
                                                class="shadow-lg rounded-circle border"
                                                />
                                            </td>
                                            <td>{{ obj.name }}</td>
                                            <td>{{ obj.category ? obj.category.name : '' }}</td>
                                            <td>{{ obj.price }}</td>
                                            <td>{{ obj.stock }}</td>
                                            <td class="text-center table-action-buttons">
                                                <button type="button" class="btn btn-xs dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown" aria-expanded="false" aria-haspopup="false"
                                                    @click="obj_id = obj.id"></button>
                                                <div class="dropdown-menu">
                                                    <div class="mb-2">
                                                        <button type="button"
                                                            class="btn bg-transparent btn-block mb-2 pl-0 ml-0 btn-flat text-left"
                                                            data-toggle="modal" data-target="#productFormModal"
                                                            @click="openModal('edit', obj.id)">
                                                            <i class="fas fa-edit px-3"></i>Edit
                                                        </button>
                                                    </div>
                                                    <div class="mb-2">
                                                       <button type="button"
                                                            class="btn bg-transparent btn-block mb-2 pl-0 ml-0 btn-flat text-left text-danger"
                                                            @click="deleteProduct(obj.id,index)">
                                                            <i class="fas fa-trash px-3 text-danger"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <product-form-modal v-if="is_product_form_modal" :modal_type="modal_type" :obj_id="obj_id" @close-modal="closeModal">
        </product-form-modal>
    </div>
</template>

<script>
export default {
    name: "products",
    data() {
        return {
            products: [],
            obj_id: null,
            is_product_form_modal: false,
            modal_type: null,
            data_loading: false,
            search: "",
        };
    },
    methods: {
        openModal(modalType, id) {
            this.modal_type = modalType;
            this.obj_id = id;
            this.is_product_form_modal = true;
        },
        deleteProduct(productId,index) {
            this.deleteConfirmationAlert(`/admin/products/${productId}`,()=>{
                this.products.splice(index,1)
            })
        },
        closeModal(product) {
            if (this.is_product_form_modal) {
                if (this.modal_type == "add" && product) {
                    this.products.push(product);
                } else if (product) {
                    const index = this.products.findIndex((item) => item.id === product.id);
                    if (index !== -1) {
                        Vue.set(this.products, index, product);
                    }
                }
                this.is_product_form_modal = false;
            }
            this.modal_type = null;
            this.obj_id = null;

            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
        },
        getProducts() {
            this.data_loading = true;
            axios({
                url: `/admin/get/products`,
                method: "GET",
            })
                .then((response) => {
                    this.data_loading = false;
                    this.products = response.data;
                })
                .catch((error) => {
                    this.errorToast(error.response.error);
                });
        },
    },
    computed: {
        filterData() {
            let filterData = null;
            if (this.search !== "") {
                filterData = this.products.filter((obj) => {
                    return this.search
                        .toLowerCase()
                        .split(" ")
                        .every((v) => obj.name.toLowerCase().includes(v));
                });

                return filterData;
            } else {
                return this.products;
            }
        },
    },
    mounted() {
        this.getProducts();
    },
};
</script>
<style scoped></style>
