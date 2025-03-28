<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title text-bold">Total Sales</h5>
                            </div>
                            <div class="card-body bg-light">
                                <h3 class="text-center">{{ saleAmount }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title text-bold">Total Customers</h5>
                            </div>
                            <div class="card-body bg-light">
                                <h3 class="text-center">{{ totalCustomers }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title text-bold">Total Products</h5>
                            </div>
                            <div class="card-body bg-light">
                                <h3 class="text-center">{{ totalProducts }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title text-bold">Total Categories</h5>
                            </div>
                            <div class="card-body bg-light">
                                <h3 class="text-center">{{ totalCategories }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "dashboard",
    props: {
        saleAmount: {
            type: Number,
            required: true
        },
        totalCustomers: {
            type: Number,
            required: true
        },
        totalProducts: {
            type: Number,
            required: true
        },
        totalCategories: {
            type: Number,
            required: true
        }
    },
};
</script>

<style scoped>
.card-body {
    padding: 20px;
    text-align: center;
}
.card-header {
    background-color: #343A40;
    color: white;
    text-align: center;
}
</style>