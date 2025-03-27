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
                                            <input type="text" class="form-control" v-model="search" />
                                        </div>
                                    </div>
                                </div>
                                <table id="table" class="table table-sm table-sm table-hover">
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
                                                    <!-- <div class="mb-2">
                                                        <button type="button"
                                                            class="btn bg-transparent btn-block mb-2 pl-0 ml-0 btn-flat text-left"
                                                            data-toggle="modal" data-target="#permissionFormModal"
                                                            @click="openPermissionModal('edit', obj.id)">
                                                            <i class="fas fa-clipboard-list px-3"></i>Delete
                                                        </button>
                                                    </div> -->
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
            roles: [],
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
        closeModal(role) {
            if (this.is_product_form_modal) {
                if (this.modal_type == "add" && role) {
                    this.roles.push(role);
                } else if (role) {
                    const index = this.roles.findIndex((item) => item.id === role.id);
                    if (index !== -1) {
                        Vue.set(this.roles, index, role);
                    }
                }
                this.is_product_form_modal = false;
            }
            this.modal_type = null;
            this.obj_id = null;

            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
        },
        getData() {
            this.data_loading = true;
            axios({
                url: `/admin/roles/get/server/data`,
                method: "GET",
            })
                .then((response) => {
                    this.data_loading = false;
                    this.roles = response.data;
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
                filterData = this.roles.filter((obj) => {
                    return this.search
                        .toLowerCase()
                        .split(" ")
                        .every((v) => obj.name.toLowerCase().includes(v));
                });

                return filterData;
            } else {
                return this.roles;
            }
        },
    },
    mounted() {
        this.getData();
    },
};
</script>
<style scoped></style>
