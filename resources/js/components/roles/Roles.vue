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
                                        <h3 class="card-title text-bold text-capitalize">Roles</h3>
                                    </div>
                                    <div class="ml-auto">
                                        <button
                                            class="btn btn-block btn-primary btn-flat btn-sm"
                                            data-toggle="modal" data-target="#roleFormModal"
                                            @click="openModal('add', null)"
                                        >
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="mb-0">Search</label>
                                                <input type="text" class="form-control" v-model="search">
                                            </div>
                                        </div>
                                    </div>
                                    <table id="table" class="table table-sm table-bordered w-100 table-hover">
                                    <thead>
                                        <tr>
                                        <th class="w-rem-2">#</th>
                                        <th>Role</th>
                                        <th class="w-rem-5 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(obj, index) in filterData" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ obj.name }}</td>
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
                                                            data-target="#roleFormModal"
                                                            @click="openModal('edit', obj.id)">
                                                            Edit
                                                        </button>
                                                    </div>
                                                    <div class="mb-2">
                                                        <button type="button"
                                                            class="btn btn-block btn-outline-info btn-xs action-btn"
                                                            data-toggle="modal"
                                                            data-target="#permissionFormModal"
                                                            @click="openPermissionModal('edit', obj.id)">
                                                            Permissions
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <div class="d-flex justify-content-center">
                                            {{ ResultNotFound }}
                                        </div> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <role-form-modal
            v-if="is_role_form_modal"
            :modal_type="modal_type"
            :obj_id="obj_id"
            @close-modal="closeModal">
        </role-form-modal>
        <permission-form-modal
            v-if="is_permission_form_modal"
            :modal_type="modal_type"
            :all_modules="all_modules"
            :obj_id="obj_id"
            @close-modal="closeModal">
        </permission-form-modal>
    </div>
</template>

<script>
export default {
    name: "roles",
    props: ['all_modules'],
    data() {
        return {
            roles: [],
            obj_id: null,
            is_role_form_modal: false,
            is_permission_form_modal: false,
            modal_type: null,
            data_loading: false,
            search: '',
        }
    },
    methods: {
        openModal(modalType, id) {
            this.modal_type = modalType;
            this.obj_id = id;
            this.is_role_form_modal = true;

        },
        closeModal(role) {
            if(this.is_role_form_modal){
                if (this.modal_type == 'add' && role) {
                    this.roles.push(role)
                }
                else if (role) {
                    const index = this.roles.findIndex(item => item.id === role.id);
                    if (index !== -1) {
                        Vue.set(this.roles, index, role);
                    }
                }
                this.is_role_form_modal = false;
            }
            else if(this.is_permission_form_modal){
                this.is_permission_form_modal=false
            }
            this.modal_type = null;
            this.obj_id = null;

            $(".modal-backdrop").remove();
            $("body").removeClass('modal-open');
        },
        openPermissionModal(modalType, id){
            this.modal_type = modalType;
            this.obj_id = id;
            this.is_permission_form_modal = true;
        },
        getData() {
            this.data_loading = true
            axios({
                url: `/admin/roles/get/server/data`,
                method: 'GET',
            })
            .then(response => {
                this.data_loading = false
                this.roles = response.data
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
    },
    computed: {
       filterData() {
            let filterData = null;
            if (this.search !== '') {
                filterData = this.roles.filter((obj) => {
                    return this.search.toLowerCase().split(' ').every(v =>
                        obj.name.toLowerCase().includes(v)
                    );
                });

                return filterData;
            }
            else {
                return this.roles;
            }
        },
    },
    mounted() {
        this.getData();
    }
}
</script>
<style scoped>
 .module-create-button{
    width: 9rem;
 }
</style>

