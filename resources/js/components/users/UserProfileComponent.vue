<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h3 class="card-title text-bold">User Profile</h3>
                                    </div>
                                </div>
                            </div>
                            <form @submit.prevent="updateUser">
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
                                                    <div class="form-heading">First Name:</div>
                                                    <input type="text" name="first_name"
                                                        v-model="$v.user_data.first_name.$model" class="form-control"
                                                        placeholder="First Name" tabindex="1">
                                                </div>
                                                <p class="isInvalid mb-0" v-if="$v.user_data.first_name.$error">First Name is
                                                    required.</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex">
                                                    <div class="form-heading">Last Name:</div>
                                                    <input type="text" name="last_name" v-model="user_data.last_name"
                                                        class="form-control" placeholder="Last Name" tabindex="2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex">
                                                    <div class="form-heading">Mobile:</div>
                                                    <input type="number" name="mobile" v-model="user_data.mobile"
                                                        class="form-control" placeholder="Mobile Phone" tabindex="6">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex">
                                                    <div class="form-heading">Email:</div>
                                                    <input type="email" name="email" v-model="user_data.email"
                                                        class="form-control" placeholder="Email" tabindex="4" disabled>
                                                </div>
                                             </div>
                                        </div>

                                    </section>
                                </div>
                                <div class="card-footer justify-content-between">
                                    <button type="submit" class="btn bg-gradient-success btn-sm" tabindex="7"
                                        style="width: 100px">
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
import { required } from 'vuelidate/lib/validators';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    name: "user-profile",
    props: [
        'user', 'user_profile'
    ],
    components: { DatePicker },
    data() {
        return {
            user_data: {
                first_name: '',
                last_name: '',
                mobile: '',
                email: '',
            },
            message: '',
            error: '',
            loading: false
        }
    },
    validations: {
        user_data: {
            first_name: { required },
        }
    },
    methods: {
        updateUser() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.loading = true
                axios({
                    url: '/admin/user-profile/update',
                    method: 'POST',
                    data: this.user_data,
                }).then((response) => {
                    if (response.status === 200) {
                        this.loading = false
                        this.message = response.data.message
                        window.location.replace('/admin/user-profile')
                    }
                }
                ).catch(error => {
                    this.error = error.response.statusText
                });
            }
        },
    },
    mounted() {
        this.user_data = this.user;
    }
}
</script>

<style scoped>
.form-heading {
    min-width: 7rem;
    align-self: center;
    font-weight: 700;
}
.isInvalid {
    position: absolute;
    font-size: 80%;
    width: 100%;
    color: #f94920;
    margin-bottom: 0px;
    padding-left: 115px;
}
</style>

