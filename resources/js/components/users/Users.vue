<template>
    <div>
        <section class="content" id="collection">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h3 class="card-title text-bold text-capitalize">Users</h3>
                                    </div>
                                    <div class="ml-auto">
                                        <button
                                            class="btn btn-block btn-primary btn-flat btn-sm"
                                            data-toggle="modal"
                                            data-target="#userFormModal"
                                            @click="openModal('add', null)"
                                        >
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- table content -->
                                <div class="mt-3">
                                    <table class="table table-bordered nowrap w-100 table-hover">
                                        <thead>
                                            <tr>
                                                <th class="w-rem-10">Name</th>
                                                <th class="w-rem-10">Email</th>
                                                <th class="w-rem-10">Role</th>
                                                <th class="w-rem-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(obj ,index) in users" :key="obj.id" :class="{'tbl-selected-row': (obj.id == obj_id)}">
                                                <td>{{ obj.first_name }} {{ obj.last_name }}</td>
                                                <td>{{ obj.email }}</td>
                                                <td>{{ obj.role ? obj.role.name:'' }}</td>
                                                <td class="text-center table-action-buttons">
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-xs dropdown-toggle dropdown-icon datatable-action-btn"
                                                        data-toggle="dropdown"
                                                        aria-expanded="false"
                                                        aria-haspopup="false"
                                                        @click="obj_id = obj.id"
                                                    >
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <div class="mb-2">
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-info btn-xs action-btn"
                                                                data-toggle="modal"
                                                                data-target="#userFormModal"
                                                                @click="openModal('edit', obj.id)">
                                                                Edit
                                                            </button>
                                                        </div>
                                                        <div class="mb-2">
                                                            <button type="button"
                                                                class="btn btn-block btn-outline-danger btn-xs action-btn"
                                                                @click="deleteUser(obj.id,index)">
                                                                Delete
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
        <user-form-modal-component
            v-if="is_form_modal"
            :modal_type="modal_type"
            :obj_id="obj_id"
            :authRoleId="authRoleId"
            @close-modal="closeModal"
        >
        </user-form-modal-component>
    </div>
</template>
<script>

export default {
    name: "users",
    props:['authRoleId'],
    data() {
        return {
            users: [],
            obj_id: null,
            is_form_modal: false,
            modal_type: null,
        }
    },

    methods: {
        getUsers() {
            axios({
                url: `/admin/users/get/data`,
                method: 'get',
            })
            .then((response) => {
                this.users=response.data
            })
            .catch(error => {
                this.errorToast(error.response.statusText)
            })
        },
        deleteUser(id, index){
            this.deleteConfirmationAlert(`/admin/users/${id}`, () => {
                // Remove the item from the categories array based on its index
                this.users.splice(index, 1);
            });
        },
        openModal(modalType, id){
            this.modal_type = modalType;
            this.obj_id = id;
            this.is_form_modal = true;
        },
        closeModal(user) {
            if (this.modal_type == 'add' && user) {
                this.users.push(user)
            }
            else if (user) {
                const index = this.users.findIndex(item => item.id === user.id);
                if (index !== -1) {
                    Vue.set(this.users, index, user);
                }
            }
            this.is_form_modal = false
            this.obj_id=null
            this.modal_type = null;
            $("#userFormModal").modal("hide");
        },
    },
    mounted() {
        this.getUsers()
    }
}
</script>
<style scoped>
</style>
