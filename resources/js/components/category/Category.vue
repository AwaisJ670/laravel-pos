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
                                            <th>Category</th>
                                            <th class="w-rem-5 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(category, index) in categories" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ category.name }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    data-toggle="dropdown"></button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#categoryFormModal" 
                                                        @click="openModal('edit', category)">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button class="dropdown-item text-danger" @click="deleteCategory(category)">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
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
        <CategoryFormModal :mode="modalMode" :category="selectedCategory" />
    </div>
</template>

<script>
import CategoryFormModal from './CategoryFormModal.vue';

export default {
    name: "Category",
    components: { CategoryFormModal },
    data() {
        return {
            search: '',
            categories: [
                { id: 1, name: "Category 1" },
                { id: 2, name: "Category 2" },
                { id: 3, name: "Category 3" }
            ],
            modalMode: 'add',
            selectedCategory: null
        };
    },
    methods: {
        openModal(mode, category = null) {
            this.modalMode = mode;
            this.selectedCategory = mode === 'edit' ? { ...category } : null;
        },
        deleteCategory(category) {
            this.categories = this.categories.filter(c => c.id !== category.id);
        }
    }
};
</script>
