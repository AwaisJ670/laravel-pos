<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h3 class="card-title text-bold">Change Password</h3>
                                    </div>
                                </div>
                            </div>
                            <form @submit.prevent="updatePassword">
                                <div class="card-body" style=" height: 520px;">

                                    <div class="alert alert-success" v-if="message">
                                        <strong>Success!</strong> {{ message }}
                                    </div>

                                    <div class="alert alert-danger" v-if="error">
                                        <strong>Error!</strong> {{ error }}
                                    </div>

                                    <section class="pb-3 border-bottom border-success">
                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex">
                                                    <div class="form-heading">Old Password:</div>
                                                    <input type="password" name="old_password"
                                                        v-model="$v.old_password.$model"
                                                        :class="['form-control', { 'is-valid': (is_old_password_valid === true), 'is-invalid': (is_old_password_valid === false), '': (is_old_password_valid === '') }]"
                                                        placeholder="Old Password" tabindex="1" @change="checkPassword">
                                                </div>
                                                <p class="isInvalid mb-0" v-if="!$v.old_password.required">Old password
                                                    is required.</p>
                                                <p class="isInvalid mb-0" v-if="is_old_password_valid === false">Old
                                                    password is not valid.</p>
                                                <p class="isValid mb-0" v-if="is_old_password_valid === true">Old
                                                    password is valid.</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex">
                                                    <div class="form-heading">New Password:</div>
                                                    <input type="password" name="new_password"
                                                        v-model.trim="$v.password.$model" class="form-control"
                                                        placeholder="New Password" tabindex="2"
                                                        :disabled="!is_old_password_valid">
                                                </div>
                                                <p class="isInvalid mb-0" v-if="$v.password.$error">New password is
                                                    required.</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex">
                                                    <div class="form-heading">Repeat Password:</div>
                                                    <input type="password" name="repeat_password"
                                                        v-model="$v.repeat_password.$model" class="form-control"
                                                        placeholder="Repeat Password" tabindex="3"
                                                        :disabled="!is_old_password_valid">
                                                </div>
                                                <p class="isInvalid mb-0" v-if="!$v.repeat_password.sameAsPassword">
                                                    Password does not match.</p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="card-footer justify-content-between">
                                    <button type="submit" class="btn bg-gradient-success btn-sm" tabindex="4"
                                        style="width: 100px"
                                        :disabled="is_old_password_valid === false || is_old_password_valid === '' || password === '' || $v.repeat_password.$invalid">
                                        <span v-if="!loading">Update</span>
                                        <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { required, sameAs } from 'vuelidate/lib/validators';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    name: "user-change-password",
    props: [
        'user_data'
    ],
    components: { DatePicker },
    data() {
        return {
            old_password: '',
            password: '',
            repeat_password: '',
            is_old_password_valid: '',
            message: '',
            error: '',
            loading: false
        }
    },
    validations: {
        old_password: { required },
        password: { required },
        repeat_password: { sameAsPassword: sameAs('password') }
    },
    methods: {
        updatePassword() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.loading = true
                axios.post('/admin/update-password', {
                    password: this.password
                }).then((response) => {
                    this.loading = false
                    if (response.status === 200) {
                        this.message = response.data.message
                        window.location.reload()
                    }
                }).catch((error) => {
                    this.error = error.response.error
                })
            }
        },
        checkPassword() {
            axios.post('/admin/check-password', {
                old_password: this.old_password
            }).then((response) => {
                if (response.status === 200) {
                    if (response.data === true) {
                        this.is_old_password_valid = true
                    }
                    else {
                        this.is_old_password_valid = false
                    }
                }
            }).catch((error) => {
                this.error = error.response.error
            })
        },
    },
    watch: {
        old_password() {
            if (this.old_password === '') {
                this.is_old_password_valid = ''
            }
        }
    }
}
</script>

<style scoped>
.form-heading {
    min-width: 8rem;
    align-self: center;
    font-weight: 700;
}

.isInvalid {
    font-size: 80%;
    width: 100%;
    margin-top: .25rem;
    margin-left: 8rem;
    color: #f94920;
    margin-bottom: 0px;
}

.isValid {
    font-size: 80%;
    width: 100%;
    margin-top: .25rem;
    margin-left: 8rem;
    color: #28a745;
}
</style>
