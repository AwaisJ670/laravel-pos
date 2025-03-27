import Vue from "vue";

//.........................................................................
//                        Admin Components
//.........................................................................

// ------------------------------Sidebar Component--------------------------
Vue.component(
    "sidebar-component",
    require("./components/includes/SidebarComponent.vue").default
);

// Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);

// ........................Users.....................................
Vue.component("users", require("./components/users/Users.vue").default);
Vue.component(
    "user-form-modal-component",
    require("./components/users/UserFormModalComponent.vue").default
);
Vue.component(
    "user-profile",
    require("./components/users/UserProfileComponent.vue").default
);
// .................................Roles Components..................................................
Vue.component("roles", require("./components/roles/Roles.vue").default);
Vue.component(
    "role-form-modal",
    require("./components/roles/RoleFormModal.vue").default
);
Vue.component(
    "permission-form-modal",
    require("./components/roles/PermissionFormModal.vue").default
);

// .................................Products Components..................................................
Vue.component(
    "products",
    require("./components/products/Products.vue").default
);
Vue.component(
    "product-form-modal",
    require("./components/products/ProductFormModal.vue").default
);

//.........................................................................
//                        General Components
//.........................................................................

Vue.component(
    "user-change-password",
    require("./components/users/UserChangePasswordComponent.vue").default
);

Vue.component(
    "on-off-component",
    require("./components/util/OnOffComponent.vue").default
);

Vue.component("pie-chart", require("./components/charts/PieChart.vue").default);
Vue.component(
    "drag-drop-form-image-component",
    require("./components/util/DragDropFormImageComponent.vue").default
);

//.........................................................................
//                        UTIL Components
//.........................................................................
Vue.component(
    "pagination-component",
    require("./components/util/PaginationComponent.vue").default
);
Vue.component(
    "search-bar",
    require("./components/util/SearchBar.vue").default
);

//Category

Vue.component(
    "categories",
    require("./components/category/Category.vue").default
);

Vue.component(
    "category-form-modal",
    require("./components/category/CategoryFormModal.vue").default
);

// Sale

Vue.component(
    "sale-panel",
    require("./components/sales/SalePannel.vue").default
);
Vue.component(
    "product-table",
    require("./components/sales/productTable.vue").default
);
Vue.component(
    "customer-modal",
    require("./components/sales/CustomerModal.vue").default
);
