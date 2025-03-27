<template>
    <aside class="main-sidebar sidebar-dark-primary sidebar-no-expand mt-2">
        <!-- Brand Logo -->
        <div class="w-100">
            <a href="/dashboard" class="brand-link">
                <span class="brand-text font-weight-light">
                    <!-- <img src="/images/logo.png" alt="Saver" class="brand-image"> -->
                    <span class="brand-text">Starter Kit</span>
                </span>
            </a>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-legacy" data-widget="treeview"
                    role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <template v-for="module in user_modules">

                        <li class="nav-header" v-if="checkModule(module.head_name)">{{ module.head_name }}</li>

                        <li :class="['nav-item', { 'menu-open': (parentUrl === module.route) }]">
                            <a :href="module.route" :class="['nav-link', { 'active': (parentUrl === module.route) }]">
                                <i :class="['nav-icon', 'text-xs', module.icon]"></i>
                                <p class="text-sm">{{ module.name }}
                                    <i class="fas fa-angle-down right" v-if="module.children"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" v-if="module.children" v-for="child_module in module.children">
                                <li class="nav-item">
                                    <a :href="child_module.route"
                                        :class="['nav-link', { 'sidebar-child-active': (childUrl === child_module.route) }]"
                                        style="padding-left: 15px">
                                        <i class="far fa-caret-square-right nav-icon text-xs"></i>
                                        <p>{{ child_module.name }}
                                            <i class="fas fa-angle-down right" v-if="child_module.children"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" v-if="child_module.children"
                                        v-for="sub_child_module in child_module.children">
                                        <li class="nav-item">
                                            <a :href="sub_child_module.route" class="nav-link">
                                                <i class="far fa-caret-square-right nav-icon text-xs"></i>
                                                <p>{{ sub_child_module.name }}</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </template>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
export default {
    'name': 'sidebar-component',
    'props': [
        'user', 'modules'
    ],
    data() {
        return {
            parent_url: '',
            child_url: '',
            user_modules: '',
            current_url: '',
        }
    },
    methods: {
        getModulesTree(arr, parentId) {
            let output = []
            for (const obj of arr) {
                if (obj.parent_id === parentId) {
                    var children = this.getModulesTree(arr, obj.id)
                    if(children.length) {
                        obj.children = children
                    }
                    output.push(obj)
                }
            }
            return output
        },
        checkModule(next_module) {
            if (this.current_module === next_module) {
                return false;
            }
            else {
                this.current_module = next_module;
                return true;
            }
        },
    },
    computed: {
        parentUrl() {
            let pathArray = window.location.pathname.split('/');

            return '/' + pathArray[1];
        },
        childUrl() {
            return window.location.pathname
        }
    },
    mounted() {
        // this.user_modules = this.user.companies[0].modules;
        this.user_modules = this.getModulesTree(this.modules, 0);
        this.current_url = window.location.pathname

        let urlPathArray = window.location.href.split('/');

        this.parent_url = urlPathArray[3];
        this.child_url = urlPathArray[5];
    }
}
</script>
<style scoped>
    .sidebar-child-active{
        background-color: green;
    }
</style>
