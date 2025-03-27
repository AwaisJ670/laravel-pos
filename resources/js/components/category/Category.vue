<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h3 class="card-title text-bold text-capitalize">Categories</h3>
                                    <div class="ml-auto">
                                        <button class="btn btn-primary btn-sm rounded-lg" data-toggle="modal"
                                            data-target="#categoryFormModal" @click="openModal('add')">
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
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th class="w-rem-5 text-center" colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="category in filteredCategories" :key="category.id">
                                            <td>{{ category.id }}</td>
                                            <td>{{ category.name }}</td>
                                            <td class="align-middle text-right"> 
                                                <toggle-button :value="category.is_active" v-model="category.is_active"
                                                        :labels="{
                                                            checked: 'Active',
                                                            unchecked: 'In-Active',
                                                        }" :disabled="false" :width="65" :height="20" :sync="true" :fontSize="8" :color="{
                                                    checked: '#018a14',
                                                    unchecked: '#c70404',
                                                }" @change="toggleActive(category.id)">
                                            </toggle-button>
                                        </td>
                                            <td class="text-center pr-3">
                                                <button class="btn btn-xs dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown"></button>
                                                <div class="dropdown-menu">
                                                    <div class="mb-2">
                                                        <button type="button"
                                                            class="btn bg-transparent btn-block mb-2 pl-0 ml-0 btn-flat text-left"
                                                            data-toggle="modal" data-target="#categoryFormModal"
                                                            @click="openModal('edit', category.id)">
                                                            <i class="fas fa-edit px-3"></i>Edit
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
        </section>
        <category-form-modal v-if="is_category_form_modal" :modal_type="modal_type" :obj_id="obj_id" @close-modal="closeModal">
        </category-form-modal>
    </div>
</template>

<script>

export default {
    name: "categories",
    data() {
        return {
            search: '',
            modal_type: 'add',
            obj_id:'',
            selectedCategory: null,
            is_category_form_modal:false,
            categories:[]
        };
    },
    computed: {
        filteredCategories() {
            return this.categories.filter(category => 
                category.name.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    },
    methods: {
        openModal(modal_type, id) {
            this.modal_type = modal_type;
            this.obj_id = id;
            this.is_category_form_modal = true;
        },
        closeModal(category) {
            if (this.is_category_form_modal) {
                if (this.modal_type == "add" && category) {
                    this.categories.push(category);
                } else if (category) {
                    const index = this.categories.findIndex((item) => item.id === category.id);
                    if (index !== -1) {
                        Vue.set(this.categories, index, category);
                    }
                }
                this.is_category_form_modal = false;
            } 
            this.modal_type = null;
            this.obj_id = null;

            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
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
        toggleActive(id) {
            axios.post(`/admin/categories/is-active/${id}`).then((response) => {
                // Update the local state after successful toggle
                this.successToast(response.data.message);
            });
        },
    },
    mounted(){
        this.getCategories()
    }
};
</script>

