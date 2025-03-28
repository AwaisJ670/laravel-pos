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

                <!-- Bar Chart Section -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-bold">Dashboard Summary</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="dashboardChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';

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
    mounted() {
        this.renderChart();
    },
    methods: {
        renderChart() {
            const ctx = document.getElementById('dashboardChart');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Sales', 'Customers', 'Products', 'Categories'],
                    datasets: [{
                        label: 'Dashboard Summary',
                        data: [
                            this.saleAmount, 
                            this.totalCustomers, 
                            this.totalProducts, 
                            this.totalCategories
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 206, 86, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    },
    watch: {
        // Re-render chart when props change
        saleAmount() {
            this.renderChart();
        },
        totalCustomers() {
            this.renderChart();
        },
        totalProducts() {
            this.renderChart();
        },
        totalCategories() {
            this.renderChart();
        }
    }
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