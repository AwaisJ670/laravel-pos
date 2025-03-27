<template>
    <div>
        <div class="modal fade" id="categoryFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form @submit.prevent="saveCategory">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="card-title text-bold text-capitalize">{{ mode === 'edit' ? 'Edit' : 'Create' }} Category</h3>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-content pb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mb-0">Category Name:</label>
                                            <input type="text" class="form-control" v-model="form_data.name" placeholder="Enter category name" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top border-primary">
                            <button type="submit" class="btn btn-primary">{{ mode === 'edit' ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CategoryFormModal',
    props: {
        mode: String,
        category: Object
    },
    data() {
        return {
            form_data: {
                name: ''
            }
        };
    },
    watch: {
        category: {
            handler(newVal) {
                if (newVal) {
                    this.form_data = {
                        name: newVal.name || ''
                    };
                } else {
                    this.form_data = { name: '' };
                }
            },
            immediate: true
        }
    },
    methods: {
        saveCategory() {
            if (this.mode === 'edit') {
                alert('Category updated successfully!');
            } else {
                alert('Category created successfully!');
            }
            $('#categoryFormModal').modal('hide');
        }
    }
};
</script>
<style scoped>

</style>
