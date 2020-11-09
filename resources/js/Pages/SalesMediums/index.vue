<template>
  <div>
    <Layout>
      <a-divider orientation="left">
        <h3>Medios de venta</h3>
      </a-divider>
      <div v-if="listSalesMediums.length === 0">
        <Empty title="medios de venta"></Empty>
        <a-button
          type="primary"
          @click="modelSalesMedium.modalNewSalesMedium = !modelSalesMedium.modalNewSalesMedium"
        >
          Crear medio de venta
        </a-button>
      </div>
      <div v-if="listSalesMediums.length !== 0">
        <a-button
          type="primary"
          @click="modelSalesMedium.modalNewSalesMedium = !modelSalesMedium.modalNewSalesMedium"
        >
          Crear medio de venta
        </a-button>
        <br>
        <br>
        <a-table :columns="columns" :data-source="getSalesMedium">
          <a slot="name" slot-scope="text">{{ text }}</a>
        </a-table>
      </div>
      <div>
        <a-modal
          v-model="modelSalesMedium.modalNewSalesMedium"          
          title="Nuevo medio de venta"
          cancelText="Cancelar"
          @ok="newSalesMedium"
        >
          <a-form-model :model="modelSalesMedium" :rules="rules" @submit="newSalesMedium">
            <a-form-model-item label="Nombre del medio de venta" prop="name">
              <a-input v-model="modelSalesMedium.name" />
            </a-form-model-item>
            <a-form-model-item label="Porcentaje de utilidad" prop="utility_percent">
              <a-input v-model="modelSalesMedium.utility_percent" />
            </a-form-model-item>            
          </a-form-model>
        </a-modal>
      </div>
      <div v-if="loadingOnSave">
        <a-spin class="loading-spinner">
          <a-icon
            slot="indicator"
            type="loading"
            style="font-size: 24px; vertical-align: middle"
            spin
          />
        </a-spin>
      </div>
    </Layout>
  </div>
</template>

<script>
import Layout from "./../../Layouts/Layout";
import Empty from "./../../Layouts/Components/Empty";
import axios from "axios";

export default {
  name: "salesMediums", 
  components: { Layout, Empty },
  props: ["salesMediums"],
  data() {
    return {
      listSalesMediums: [],
      modelSalesMedium: {
        name: "",
        utility_percent: 0.0,
        modalNewSalesMedium:false,
      },      
      rules: {
        name: [{ required: true, message: "Obligatorio", trigger: "blur" }],
        utility_percent: [{ required: true, message: "Obligatorio", trigger: "blur" }],
      },
      loadingOnSave: false,
      columns: [
        {
          title: "Medio de venta",
          dataIndex: "name",
          scopedSlots: { customRender: "name" },
        },        
        {
          title: "Porcentaje de utilidad",
          dataIndex: "utility",
          ellipsis: true,
        },
      ],
    };
  },
  mounted() {
    this.listSalesMediums = this.salesMediums;
  },
  methods: {
    newSalesMedium() {
      this.loadingOnSave = true;
      axios
        .post("/medios-venta/nuevo", this.modelSalesMedium)
        .then((res) => {
          this.openNotification("success", "Solicitud exitosa", "");
          this.listSalesMediums = res.data;
          this.modelSalesMedium.modalNewSalesMedium = false;
        })
        .catch((error) => {
          console.log(error);
        });
      this.loadingHide();
    },
    openNotification(type, message, description) {
      this.$notification.open({
        message: message,
        type: type,
        description: description,
      });
    },
    loadingHide() {
      setTimeout(() => {
        this.loadingOnSave = false;
      }, 2000);
    },
  },
  computed: {
    getSalesMedium() {
      let items = [];
      this.listSalesMediums.forEach((item) => {
        items.push({
          key: item.id,
          name: item.name,
          utility: item.utility_percent,
        });
      });
      return items;
    },
  },
};
</script>

<style scoped>
</style>