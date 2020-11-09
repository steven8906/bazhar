<template>
  <Layout> 
      <div v-if="listProducts.length === 0">
        <Empty title="pedidos"></Empty>
      </div>      
      <div v-if="listProducts.length !== 0">
        <br>
        <a-table :columns="columns" :data-source="getProducts">
          <a slot="name" slot-scope="text">{{ text }}</a>
        </a-table>
      </div>
  </Layout>
</template>

<script>
import Layout from "./../../Layouts/Layout";
import Empty from "./../../Layouts/Components/Empty";

export default {
  name: "orders",
  props: ["products"],
  components: { Layout, Empty },
  data() {
    return {
      listProducts: [],
      columns: [
        {
          title: "Nombre producto",
          dataIndex: "name",
          scopedSlots: { customRender: "name" },
        },
        {
          title: "Presentación",
          dataIndex: "presentation",
          ellipsis: true,
        },
        {
          title: "Precio de compra",
          dataIndex: "priceShop",
          ellipsis: true,
        },
        {
          title: "Precio de venta",
          dataIndex: "priceSell",
          ellipsis: true,
        },
        {
          title: "Moneda",
          dataIndex: "currency",
          ellipsis: true,
        },
      ],
    };
  },
  mounted() {
    this.listProducts = this.products;
  },
  computed: {
    getProducts() {
      let products = [];
      this.listProducts.forEach((product) => {
        products.push({
          key: product.id,
          name: product.name,
          presentation: product.presentation,
          priceShop: product.priceShop,
          priceSell: product.priceSell,
          currency: product.currency,
        });
      });
      return products;
    },
  },
};
</script>

<style>
</style>