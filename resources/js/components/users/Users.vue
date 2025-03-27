<template>
    <div>
        <section class="content" id="collection">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card shadow-sm m-3 rounded-lg border-0">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h3 class="card-title text-bold text-capitalize">
                                            User's Listing
                                        </h3>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-block btn-primary btn-sm rounded-lg" data-toggle="modal"
                                            data-target="#userFormModal" @click="openModal('add', null)">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <!-- table content -->
                                <div class="">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="pl-3">Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th class="text-center pr-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(obj, index) in users" :key="obj.id"
                                                :class="{ 'tbl-selected-row': obj.id == obj_id }">
                                                <td class="pl-3">
                                                    {{ obj.first_name }} {{ obj.last_name }}
                                                </td>
                                                <td>{{ obj.email }}</td>
                                                <td>{{ obj.role ? obj.role.name : "" }}</td>
                                                <!-- <td class="align-middle text-right">
                                                    <toggle-button :value="obj.is_active" v-model="obj.is_active"
                                                        :labels="{
                                                            checked: 'Active',
                                                            unchecked: 'In-Active',
                                                        }" :disabled="false" :width="65" :height="20" :sync="true" :fontSize="8" :color="{
                                checked: '#018a14',
                                unchecked: '#c70404',
                            }" @change="toggleActive(obj.id)"></toggle-button>
                                                </td> -->
                                                <td class="text-center pr-3">
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-xs dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown" aria-expanded="false"
                                                            aria-haspopup="false" @click="obj_id = obj.id"></button>
                                                        <div class="dropdown-menu">
                                                            <button type="button"
                                                                class="btn bg-transparent btn-block mb-2 pl-0 ml-0 btn-flat"
                                                                data-toggle="modal" data-target="#userFormModal"
                                                                @click="openModal('edit', obj.id)">
                                                                <i class="fas fa-edit pr-3"></i>Edit
                                                            </button>
                                                            <button type="button"
                                                                class="btn bg-transparent btn-block btn-flat"
                                                                @click="deleteUser(obj.id, index)">
                                                                <i class="far fa-trash-alt pr-3"></i> Delete
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
            </div>
        </section>
        <user-form-modal-component v-if="is_form_modal" :modal_type="modal_type" :obj_id="obj_id"
            :authRoleId="authRoleId" @close-modal="closeModal">
        </user-form-modal-component>
    </div>
</template>
<script>
export default {
    name: "users",
    props: ["authRoleId"],
    data() {
        return {
            users: [],
            obj_id: null,
            is_form_modal: false,
            modal_type: null,
            is_active: 1,
        };
    },

    methods: {
        getUsers() {
            axios({
                url: `/admin/users/get/data`,
                method: "get",
            })
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    this.errorToast(error.response.statusText);
                });
        },
        deleteUser(id, index) {
            this.deleteConfirmationAlert(`/admin/users/${id}`, () => {
                // Remove the item from the categories array based on its index
                this.users.splice(index, 1);
            });
        },
        openModal(modalType, id) {
            this.modal_type = modalType;
            this.obj_id = id;
            this.is_form_modal = true;
        },
        closeModal(user) {
            if (this.modal_type == "add" && user) {
                this.users.push(user);
            } else if (user) {
                const index = this.users.findIndex((item) => item.id === user.id);
                if (index !== -1) {
                    Vue.set(this.users, index, user);
                }
            }
            this.is_form_modal = false;
            this.obj_id = null;
            this.modal_type = null;
            $("#userFormModal").modal("hide");
        },
        toggleActive(id) {
            axios.post(`/admin/user/is-active/${id}`).then((response) => {
                // Update the local state after successful toggle
                this.successToast(response.data.message);
            });
        },
    },
    mounted() {
        this.getUsers();
    },
};
</script>
<style scoped></style>
