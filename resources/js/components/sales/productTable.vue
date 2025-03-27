<template>
  <div>
    <!-- {{ tableObj.items }} -->
    <table class="table table-hover table-bordered mb-0">
      <thead class="table-header bg-white">
        <tr>
          <th class="align-middle" style="width:5%">Actions</th>
          <th class="align-middle">#</th>
          <th class="align-middle">Product</th>
          <th class="align-middle">Price</th>
          <th class="align-middle">Qty</th>
          <th class="align-middle">Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in tableObj.items"
          :key="item.id"
        >
          <td class="text-center">
            <a class="btn p-0 m-0 bg-transparent" @click="deleteRow(index)">
              <i class="fas fa-trash fa-lg text-danger"></i>
            </a>
          </td>
          <td class="text-muted text-center" scope="row">
            {{ tableObj.items.length - index }}
          </td>
          <td class="align-middle">{{ item.name }}</td>
          <td
            class="text-right align-middle"
            style="width: 100px"
            @click="editField(index, 'price')"
          >
            <template v-if="item.isEditingPrice">
              <input
                type="text"
                autofocus
                v-model="item.price"
                @blur="stopEditing(item, index, 'price')"
                class="form-control form-control-sm text-right"
              />
            </template>
            <template v-else>
              {{ item.price }}
            </template>
          </td>
          <td
            class="text-right align-middle"
            style="width: 70px"
            @click="editField(index, 'quantity')"
          >
            <template v-if="item.isEditingQuantity">
              <input
                type="text"
                autofocus
                v-model="item.quantity"
                @input="validateQuantity(item)"
                @blur="stopEditing(item, index, 'quantity')"
                class="form-control form-control-sm text-right"
                />
            </template>
            <template v-else>
              <span>
                {{ item.quantity | decimalPlacesIfNumberContains }}
              </span>
              <small class="font-italic">Units</small>
            </template>
          </td>
          <td class="text-right align-middle">{{ item.amount }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  name: "product-table",
  props: ["tableObj",],
  data() {
    return {};
  },
  methods: {
    validateQuantity(item) {
        if (item.quantity > item.stock) {
            item.quantity = item.stock; // Restrict to stock
        }
    },
    deleteRow(index) {
      this.tableObj.items.splice(index, 1);
    },
    editField(index, field) {
      // Activate editing for the specific field
      if (field === "quantity"){
        this.$set(this.tableObj.items, index, {
            ...this.tableObj.items[index],
            isEditingQuantity: true,
        });
      } else if (field === "price") {
        this.$set(this.tableObj.items, index, {
          ...this.tableObj.items[index],
          isEditingPrice: true,
        });
      }
    },
    stopEditing(item, index, field) {
      // Deactivate editing for the specific field
      if (field === "quantity") {
        this.$set(this.tableObj.items, index, {
          ...this.tableObj.items[index],
          isEditingQuantity: false,
        });
      } else if (field === "price") {
        this.$set(this.tableObj.items, index, {
          ...this.tableObj.items[index],
          isEditingPrice: false,
        });
      }
      this.calculateTotalPrice(item, index);
    },
    calculateTotalPrice(item, index) {
      const { price, quantity } = item;
      const totalPrice = price * quantity;

      this.$set(this.tableObj.items, index, {
        ...this.tableObj.items[index],
        amount: totalPrice, // Set the totalPrice value
      });
    },
  },
  watch: {},
};
</script>
<style scoped>
.table-footer {
  position: sticky;
  bottom: -3px;
  width: 100%;
  z-index: 1;
}
.table-header {
  position: sticky;
  top: -3px;
  width: 100%;
  z-index: 1;
}
.table-selection-color {
  background-color: #ffd7d7 !important;
}
</style>
