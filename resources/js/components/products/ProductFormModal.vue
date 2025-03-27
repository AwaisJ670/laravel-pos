<template>
    <div>
        <div class="modal fade" id="productFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <form @submit.prevent="save">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="card-title text-bold text-capitalize form-title">{{ modal_type }} Product</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close-modal')">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-content pb-3">
                                <div class="form-row">
                                    <div class="col-3">
                                        <drag-drop-form-image-component
                                            :modal_type="modal_type"
                                            :image_path="modal_type === 'edit' && product.image ? `/storage/products_images/${product.image}` : null"
                                            @changed="onFileChange"
                                        ></drag-drop-form-image-component>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="categorySelect" class=" ">
                                                        Category
                                                        <span v-if="!$v.product.category_id.required">*</span>
                                                    </label>
                                                    <treeselect :options="categories"
                                                        :multiple="false" placeholder="Select Category"
                                                        :show-count="true" v-model="product.category_id"
                                                        :normalizer="normalizerProductCategories"
                                                        :default-expand-level="1"
                                                        >
                                                    </treeselect>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="code">
                                                        <span v-if="!$v.product.code.required">*</span>
                                                        Barcode
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="Barcode"
                                                        v-model="product.code"
                                                        required
                                                        class="form-control"
                                                        id="code"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">
                                                        <span v-if="!$v.product.name.required">*</span>
                                                        Name
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="name"
                                                        placeholder="Name"
                                                        v-model="product.name"
                                                        required
                                                        class="form-control"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="price">
                                                        <span v-if="!$v.product.price.required">*</span>
                                                        Price
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="price"
                                                        placeholder="Price"
                                                        v-model="product.price"
                                                        required
                                                        class="form-control"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="Description">
                                                        Description
                                                    </label>
                                                    <textarea
                                                        type="text"
                                                        id="Description"
                                                        placeholder="Description"
                                                        v-model="product.description"
                                                        class="form-control"
                                                        rows="2"
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="Stock">
                                                        Stock
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="Stock"
                                                        placeholder="Stock"
                                                        v-model="product.stock"
                                                        required
                                                        class="form-control"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top border-primary">
                            <button type="submit"
                                class="btn btn-primary"
                                :disabled="$v.$invalid || data_loading || crud_loading"
                            >
                               Save
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
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
export default {
    name: 'product-form-modal',
    props: ['modal_type', 'obj_id'],
    components: { Treeselect },
    data() {
        return {
            product: {
                name: '',
                category_id:null,
                stock:0,
                price:0,
                code:'',
                description:'',
                image:''
            },
            crud_loading: false,
            data_loading: false,
            categories: [],
            normalizerProductCategories(node){
                return {
                    id: node.id,
                    label: node.name,
                };
            }
        }
    },
    validations: {
        product: {
            name: {required},
            code: {required},
            category_id: {required},
            price: {required},

        }
    },
    methods: {
        save() {
            this.crud_loading = true;
            let url = this.modal_type === 'add' ? `/admin/products` : `/admin/products/${this.obj_id}`;
            let method = this.modal_type === 'add' ? 'POST' : 'PUT';

            axios({
                url: url,
                method: method,
                data: this.product
            })
            .then(response => {
                this.successToast(response.data.message);
                if(this.product.image instanceof File){
                    this.uploadImage(response.data.product.id)
                }else{
                    this.$emit('close-modal',response.data.product)
                }
            })
            .catch(error => {
                this.errorToast(error.response.error)
                this.crud_loading = false;
            })
        },
        getDataForEdit() {
            axios({
                url: `/admin/products/${this.obj_id}/edit`,
                method: 'GET',
            })
            .then(response => {
                this.product = response.data
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
        makeImageFormData() {
            let formData = new FormData();
            formData.append('image', this.product.image);

            return formData;
        },
        onFileChange(data) {
            this.product.image = data.file;
        },
        uploadImage(productId) {
            this.crud_loading = true;
            axios({
                url: `/admin/upload/product/image/${productId}`,
                method: 'POST',
                data: this.makeImageFormData()
            })
                .then(response => {
                    this.crud_loading = false;
                    if(response.status == 200){
                        this.successToast(response.data.message)
                        this.$emit('close-modal',response.data.product);
                    }
                })
                .catch(error => {
                    this.crud_loading = false;
                    this.error = error.data.message;
                });
        },
        getCategories(){
            axios({
                url: `/admin/get/categories`,
                method: "GET",
            })
            .then((response) => {
                this.data_loading = false;
                this.categories = response.data;
            })
            .catch((error) => {
                this.errorToast(error.response.error);
            });
        },
    },
    mounted() {
        this.modal_type === 'edit' ? this.getDataForEdit() : null;
        this.getCategories()
    }

}
</script>

<style scoped>

</style>
