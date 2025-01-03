<template>
    <div>
        <div class="modal fade" id="userPermissionFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-xl">
                <form @submit.prevent="save">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h3 class="card-title text-bold text-capitalize form-title">{{ modal_type }} User Group Permissions</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close-modal')">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-content pb-3">
                                <div class="row">
                                    <div class="col-12" v-if="this.modal_type == 'add'">
                                        <div class="form-group">
                                            <label class="mb-0">Group Name:</label>
                                            <select class="form-control mr-2" v-model="form_data.name" >
                                                <option value="" disabled selected>-- Choose Group Name --</option>
                                                <option v-for="obj in groups" :key="obj.id" :value="obj.id">
                                                <span class="svg-bg-airport"></span>{{ obj.name }}
                                                </option>
                                            </select>
                                            <p class="is-invalid-text" v-if="!$v.form_data.name.required">Group Name is required</p>
                                        </div>
                                    </div>
                                    <div class="col-12" v-else>
                                        <div class="form-group">
                                            <label class="mb-0">Group Name:</label>
                                            <span class="ml-2  text-success">{{ form_data.name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div v-for="parentModule in all_modules.filter(module => !module.parent_id)" :key="parentModule.id">
                                    <div class="module-checkbox">
                                        <label>
                                            <input type="checkbox" :value="parentModule.id" v-model="form_data.selectedModules" />
                                            {{ parentModule.name }}
                                        </label>
                                    </div>
                                    <br>
                                    <div v-for="childModule in all_modules.filter(module => module.parent_id === parentModule.id)" :key="childModule.id" class="module-checkbox pl-5">
                                        <p>
                                            <input type="checkbox" :value="childModule.id" v-model="form_data.selectedModules" @change="updateParentSelection(parentModule.id)" />
                                            {{ childModule.name }}
                                        </p>
                                    </div>
                                </div>

                                <p class="is-invalid-text" v-if="!$v.form_data.selectedModules.required">Modules are required</p>
                                <!-- <span>Selected Modules {{ form_data.selectedModules }}</span> -->
                            </div>
                        </div>
                        <div class="modal-footer border-top border-primary">
                        <button type="submit"
                            class="btn btn-block btn-primary btn-flat btn-sm ml-auto"
                            :disabled="$v.$invalid || data_loading || crud_loading"
                        >
                            <span v-if="modal_type === 'add' && !crud_loading">Create</span>
                            <span v-if="modal_type === 'edit' && !crud_loading">Update</span>
                            <span v-if="crud_loading" class="spinner-border spinner-border-sm"></span>
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
export default {
    name: 'user-permission-group-form-modal',
    props: [
        'modal_type', 'obj_id', 'all_modules'
    ],
    data() {
        return {
            form_data: {
                name: '',
                selectedModules: [],
            },
            crud_loading: false,
            data_loading: false,
            is_all_select: false,
            formData: [],
            groups:[]
        }
    },
    validations: {
        form_data: {
            name: {required},
            selectedModules: {required},
        }
    },
    methods: {
        save() {
            this.crud_loading = true;

            let url = this.modal_type === 'add' ? `/admin/user-groups/permissions` : `/admin/user-groups/permissions/${this.obj_id}`;
            let method = 'POST';
            axios({
                url: url,
                method: method,
                data:this.form_data
            })
            .then(response => {
                this.successToast(response.data.message);
                this.$emit('close-modal')
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
        getDataForEdit() {
            axios({
                url: `/admin/user-groups/${this.obj_id}/edit`,
                method: 'GET',
            })
            .then(response => {
                this.form_data.name = response.data.user_group.name
                this.form_data.selectedModules = response.data.user_group.assigned_modules ? response.data.user_group.assigned_modules : this.form_data.selectedModules
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
        getData() {
            this.data_loading = true
            axios({
                url: `/admin/user-groups/get/server/data`,
                method: 'GET',
            })
            .then(response => {
                this.data_loading = false
                this.groups = response.data
            })
            .catch(error => {
                this.errorToast(error.response.error)
            })
        },
        hasChildren(parentId) {
            return this.all_modules.some((module) => module.parent_id === parentId);
        },
        updateParentSelection(parentId) {
            const childrenSelected = this.form_data.selectedModules.filter(moduleId =>
                this.all_modules.some(module => module.parent_id === parentId && module.id === moduleId)
            );

            const parentIndex = this.form_data.selectedModules.indexOf(parentId);

            if (childrenSelected.length === 0) {
                if (parentIndex !== -1) {
                    this.form_data.selectedModules.splice(parentIndex, 1);
                }
            } else {
                if (parentIndex === -1) {
                    this.form_data.selectedModules.push(parentId);
                }
            }
        }

    },
    mounted() {
        this.modal_type === 'edit' ? this.getDataForEdit() : null;
        this.modal_type === 'add' ? this.getData() : null;

    }

}
</script>

<style scoped>
.module-checkbox {
  display: inline-block;
  width: 25%; /* Set the width to display four checkboxes per line */
}

</style>
