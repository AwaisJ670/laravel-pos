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
                                        <h3 class="card-title text-bold text-capitalize">Sales Data</h3>
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
                                <table id="table" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th class="w-rem-2">#</th>
                                            <th>Customer Name</th>
                                            <th>Phone Number</th>
                                            <th>Total</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(obj, index) in filterData" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ obj.customer.name }}</td>
                                            <td>{{ obj.customer.phone }}</td>
                                            <td>{{ parseFloat(obj.amount).toFixed(2) }}</td>
                                            <td>
                                                <button @click="printInvoice(obj.id)"
                                                    class="btn btn-info">Print</button>
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
    </div>
</template>

<script>
export default {
    name: "sale-index",
    props: ["sales"],
    data() {
        return {
            roles: this.sales,
            search: "",
        };
    },
    
    computed: {
        filterData() {
            let filterData = null;
            if (this.search !== "") {
                filterData = this.roles.filter((obj) => {
                    return this.search
                        .toLowerCase()
                        .split(" ")
                        .every((v) => obj.customer.name.toLowerCase().includes(v));
                });

                return filterData;
            } else {
                return this.roles;
            }
        },
    },

    methods: {
        printInvoice(id) {
            window.location.href = `/admin/invoice/${id}`;
        },
    },
};
</script>


<style scoped></style>
