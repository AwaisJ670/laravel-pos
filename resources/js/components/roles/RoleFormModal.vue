<template>
    <div>
        <div class="modal fade" id="roleFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form @submit.prevent="save">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="card-title text-bold text-capitalize form-title">{{ modal_type }} Role</h3>
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
                                                Role</label>
                                            <input
                                                type="text"
                                                name="Role"
                                                placeholder="Role"
                                                v-model="form_data.name"
                                                required
                                                :class="['form-control', {'is-invalid no-icon': (!$v.form_data.name.required)}]"
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
                                <span v-if="modal_type === 'add' && !crud_loading">Create</span>
                                <span v-if="modal_type === 'edit' && !crud_loading">Update</span>
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
    name: 'role-form-modal',
    props: [
        'modal_type', 'obj_id'
    ],
    components: { Treeselect },
    data() {
        return {
            form_data: {
                name: '',
                modules: [],
            },
            crud_loading: false,
            data_loading: false,
            is_all_select: false,
            formData: [],
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
            let url = this.modal_type === 'add' ? `/admin/roles` : `/admin/roles/${this.obj_id}`;
            let method = this.modal_type === 'add' ? 'POST' : 'PUT';

            axios({
                url: url,
                method: method,
                data: this.form_data
            })
            .then(response => {
                this.successToast(response.data.message);
                this.$emit('close-modal',response.data.role)
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
        getDataForEdit() {
            axios({
                url: `/admin/roles/${this.obj_id}/edit`,
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
