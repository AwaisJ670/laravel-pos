<template>
    <div>
        <div class="modal fade" id="categoryFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form @submit.prevent="save">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="card-title text-bold text-capitalize form-title">{{ modal_type }} Category</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close-modal')">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-content pb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mb-0">
                                                <span v-if="!$v.form_data.name.required">*</span>
                                                Name</label>
                                            <input
                                                type="text"
                                                placeholder="Name"
                                                v-model="form_data.name"
                                                required
                                                class="form-control"
                                            >
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
export default {
    name: 'category-form-modal',
    props: [
        'modal_type', 'obj_id'
    ],
    data() {
        return {
            form_data: {
                name: '',
            },
            crud_loading: false,
            data_loading: false,
        }
    },
    validations: {
        form_data: {
            name: {required},
        }
    },
    methods: {
        save() {
            this.crud_loading = true;
            let url = this.modal_type === 'add' ? `/admin/categories` : `/admin/categories/${this.obj_id}`;
            let method = this.modal_type === 'add' ? 'POST' : 'PUT';

            axios({
                url: url,
                method: method,
                data: this.form_data
            })
            .then(response => {
                this.successToast(response.data.message);
                this.$emit('close-modal',response.data.category)
            })
            .catch(error => {
                this.crud_loading = false;
                this.errorToast(error.response.error)
            })
        },
        getDataForEdit() {
            axios({
                url: `/admin/categories/${this.obj_id}/edit`,
                method: 'GET',
            })
            .then(response => {
                this.form_data = response.data
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
    },
    mounted() {
        this.modal_type === 'edit' ? this.getDataForEdit() : null;
    }

}
</script>

<style scoped>

</style>
