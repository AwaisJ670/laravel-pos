<template>
    <div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false"
        data-backdrop="static">
        <div class="modal-dialog modal-dialog-lg">
            <form @submit.prevent="save">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h3 class="card-title text-bold text-capitalize form-title">
                            {{ modal_type }} User
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            @click="$emit('close-modal')">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="mb-0">First Name  <span v-if="!$v.form_data.first_name.required">*</span></label>
                                    <input type="text" name="firstName" v-model="form_data.first_name"
                                        :class="['form-control', { 'is-invalid-input-no-icon': (!$v.form_data.first_name.required) }]"
                                        placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="mb-0">Last Name <span v-if="!$v.form_data.last_name.required">*</span></label>
                                    <input type="text" name="lastName" v-model="form_data.last_name"
                                        :class="['form-control', { 'is-invalid-input-no-icon': (!$v.form_data.last_name.required) }]"
                                        placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="mb-0">Email</label>
                                    <input type="email" name="email" v-model="form_data.email" class="form-control"
                                        placeholder="Email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6" v-if="authRoleId == 1 || modal_type == 'add'">
                                <div class="form-group">
                                    <label class="mb-0">Password</label>
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        v-model="form_data.password" class="form-control" placeholder="Password">
                                    <div class="d-flex position-absolute" style=" top: 27px; right: 17px;">
                                        <a class="border-0 bg-transparent text-muted" href="javascript:void(0)"
                                            id="showPasswordCheckbox" @click="togglePasswordVisibility">
                                            <i :class="{ 'far fa-eye': !showPassword, 'fas fa-eye-slash': showPassword }"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="mb-0">Select Role  <span v-if="!$v.form_data.role_id.required">*</span></label>
                                    <select class="form-control" v-model="form_data.role_id">
                                        <option value="" selected disabled>--Select Role--</option>
                                        <option v-for="users in roles" :key="users.id" :value="users.id">
                                            {{ users.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="mb-0">Mobile</label>
                                    <input type="number" name="PhoneNumber" v-model="form_data.mobile"
                                        class="form-control" placeholder="Mobile">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-primary">
                        <button type="submit" class="btn btn-block btn-primary btn-flat btn-sm ml-auto"
                            :disabled="$v.$invalid || data_loading || crud_loading">
                            <span v-if="modal_type === 'add' && !crud_loading">Create</span>
                            <span v-if="modal_type === 'edit' && !crud_loading">Update</span>
                            <span v-if="crud_loading" class="spinner-border spinner-border-sm"></span>
                        </button>
                    </div>
                </div>
            </form>
            <div v-if="data_loading" class="overlay"><i class="spinner-border text-primary spinner-border-sm"></i></div>
        </div>
    </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";

export default {
    name: 'user-form-modal-component',
    props: ['modal_type', 'obj_id', 'authRoleId'],
    data() {
        return {
            form_data: {
                first_name: '',
                last_name: '',
                role_id: '',
                email: '',
                mobile: '',
                password: '',
            },
            roles: [],
            data_loading: false,
            showPassword: false,
            crud_loading: false,
        }
    },
    validations: {
        form_data: {
            role_id: { required },
            first_name: { required },
            last_name: { required },
        }
    },
    methods: {
        save() {
            if (!this.$v.$invalid) {
                this.crud_loading = true;
                let url = this.modal_type === 'add' ? `/admin/users` : `/admin/users/${this.obj_id}`;
                let method = this.modal_type === 'add' ? 'POST' : 'PUT';
                axios({
                    url: url,
                    method: method,
                    data: this.form_data
                })
                    .then(response => {
                        this.successToast(response.data.message);
                        this.$emit('close-modal', response.data.user)
                    })
                    .catch(error => {
                        this.errorToast(error.response.statusText)
                    })
            }
        },
        getDataForEdit() {
            this.data_loading = true
            axios({
                url: `/admin/users/${this.obj_id}/edit`,
                method: 'GET',
            })
                .then(response => {
                    this.data_loading = false
                    this.form_data = response.data.user
                    if (this.authRoleId == 1) {
                        this.form_data.password = response.data.password
                    }
                })
                .catch(error => {
                    this.errorToast(error.response.statusText)
                })
        },
        getRoles() {
            this.data_loading = true
            axios({
                url: `/admin/get/roles`,
                method: 'GET',
            })
                .then(response => {
                    this.data_loading = false
                    this.roles = response.data
                })
                .catch(error => {
                    this.errorToast(error.response.statusText)
                })
        },
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword; // Toggle the showPassword property
        },
    },
    mounted() {
        this.getRoles()
        if (this.modal_type === 'edit') {
            this.getDataForEdit();
        }
    }

}
</script>

<style scoped></style>
