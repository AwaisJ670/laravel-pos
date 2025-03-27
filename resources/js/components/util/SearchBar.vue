<template>
  <div>
    <div class="position-relative">
      <input
        ref="searchInput"
        type="text"
        id=""
        class="form-control"
        v-model="searchQuery"
        @keydown.arrow-down="moveSelection('down')"
        @keydown.arrow-up="moveSelection('up')"
        @keyup.enter="selectItem(selectedIndex)"
        @blur="closeDropdown"
        :placeholder="label"
        :disabled="isDisabled"
        />
        <div class="dropdown-list" v-if="filteredItems.length && !is_barcode_mode && dropdownVisible" @mousedown.prevent>
          <table class="table">
            <tbody>
              <tr
                v-for="(item, index) in filteredItems"
                :ref="'item-' + index"
                :key="index"
                :class="{ 'table-active': selectedIndex === index }"
                @click="selectItem(index)"
              >
                <td v-for="key in item.isVisible" :key="key">
                  {{ getNestedValue(item, key) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "search-bar",
  props: ['searchedData',"is_barcode_mode","searchBy","label","isDisabled"],
  data() {
    return {
      searchQuery: "",
      selectedIndex: -1,
      dropdownVisible: false,
    };
  },
  methods: {
    validateAndProceed() {
        this.$refs.searchInput.focus();
    },
    moveSelection(direction) {
      if (direction === "down") {
        this.selectedIndex =
          (this.selectedIndex + 1) % this.filteredItems.length;
      } else if (direction === "up") {
        this.selectedIndex =
          (this.selectedIndex - 1 + this.filteredItems.length) %
          this.filteredItems.length;
      }
      this.scrollToSelected();
    },
    closeDropdown() {
        this.dropdownVisible = false;  // Close dropdown when focus is lost
    },
    selectItem(index = this.selectedIndex) {
      if (index >= 0 && index < this.filteredItems.length) {
        const selectedItem = this.filteredItems[index];
        this.$emit('selectedObj', selectedItem)
        this.closeDropdown()
        this.$refs.searchInput.blur();
        this.searchQuery = '';
        this.selectedIndex = -1;
      }
    },
    scrollToSelected() {
      // Use refs to scroll the selected item into view
      const selectedRow = this.$refs[`item-${this.selectedIndex}`];
      if (selectedRow && selectedRow[0]) {
        selectedRow[0].scrollIntoView({
          behavior: "smooth",
          block: "nearest",
        });
      }
    },
    getNestedValue(obj, key) {
      return key.split(".").reduce((o, k) => (o ? o[k] : null), obj);
    },
  },
  computed: {
    filteredItems() {
        if (this.searchQuery) {
            this.dropdownVisible = true;
            return this.searchedData.filter((item) =>
                this.searchBy.some((key) =>
                    item[key]?.toString().toLowerCase().includes(this.searchQuery.toLowerCase())
                )
            );
        }
        return [];
    }
  },
};
</script>
<style scoped>
tr > td {
  border-top: 0;
}
.dropdown-list {
  max-height: 150px;
  overflow-y: auto;
  z-index: 10;
  left: 5px;
  top: 100%;
  position: absolute;
  width: 98%;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  scrollbar-width: thin; /* For Firefox: thin scrollbar */
  scrollbar-color: #ccc #f4f4f4
}
.dropdown-list::-webkit-scrollbar {
  width: 8px; /* Width of the scrollbar */
  background: #f4f4f4; /* Background color of the scrollbar */
  border-radius: 30px; /* Rounded scrollbar */
}

.dropdown-list::-webkit-scrollbar-thumb {
  background: #ccc; /* Scroll thumb color */
  border-radius: 30px; /* Rounded corners for the scroll thumb */
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.3); /* Shadow effect */
}

.dropdown-list::-webkit-scrollbar-thumb:hover {
  background: #bbb; /* Scroll thumb color on hover */
}

.dropdown-list::-webkit-scrollbar-track {
  background: #f4f4f4; /* Track color */
  border-radius: 30px;
}

tr:hover{
    background-color: #bbb;
    cursor: pointer;
}

input::placeholder{
    color:green !important;
}
</style>
