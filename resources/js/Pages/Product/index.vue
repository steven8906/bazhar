<template>
  <div>
    <Layout>
      <a-divider orientation="left">
        <h3>Productos</h3>
      </a-divider>
      <br />
      <div v-if="listProducts.length === 0">
        <Empty title="productos"></Empty>        
        <inertia-link href="/nuevo-producto">
          <a-button
            type="primary"
          >
            Nuevo producto
          </a-button>
        </inertia-link>
      </div>
      <div v-if="listProducts.length !== 0">        
        <inertia-link href="/nuevo-producto">
          <a-button
            type="primary"
          >
            Nuevo producto
          </a-button>
        </inertia-link>
        <br />
        <br />
        <a-table :columns="columns" :data-source="getProduct">
          <a slot="name" slot-scope="text">{{ text }}</a>
        </a-table>
      </div>
    </Layout>
  </div>
</template>

<script>
import Layout from "./../../Layouts/Layout";
import Empty from "./../../Layouts/Components/Empty";
import axios from "axios";

export default {
  name: "products",
  components: { Layout, Empty },
  props: ["products", "providers", "taxes", "business", "presentations"],
  data() {
    return {
      listProducts: [],
      listProviders: [],
      listBusiness: [],
      listPresentations: [],
      listTaxes: [], 
      columns: [
        {
          title: "Nombre",
          dataIndex: "name",
          scopedSlots: { customRender: "name" },
        },
        {
          title: "Descripción",
          dataIndex: "description",
          ellipsis: true,
        },
        {
          title: "Precio compra",
          dataIndex: "priceShop",
          ellipsis: true,
        },
        {
          title: "Precio venta",
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
    this.listProviders = this.providers;
    this.listBusiness = this.business;
    this.listPresentations = this.presentations;
    this.listTaxes = this.taxes;
  },
  computed: {
    getProduct() {
      let products = [];
      this.listProducts.forEach((product) => {
        products.push({
          key: product.id,
          name: product.name,
          description: product.description,
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

<style scoped>
</style>
