<template>
  <div>
    <Layout>
      <a-divider orientation="left">
        <h3>Impuestos</h3>
      </a-divider>
      <div v-if="listTaxes.length === 0">
        <Empty title="impuestos"></Empty>
        <a-button
          type="primary"
          @click="modelTaxes.modalNewTax = !modelTaxes.modalNewTax"
        >
          Crear impuesto
        </a-button>
      </div>
      <div v-if="listTaxes.length !== 0">
        <a-button
          type="primary"
          @click="modelTaxes.modalNewTax = !modelTaxes.modalNewTax"
        >
          Crear impuesto
        </a-button>
        <br>
        <br>
        <a-table :columns="columns" :data-source="getTaxes">
          <a slot="name" slot-scope="text">{{ text }}</a>
        </a-table>
      </div>
      <div>
        <a-modal
          v-model="modelTaxes.modalNewTax"          
          title="Nuevo impuesto"
          cancelText="Cancelar"
          @ok="newTax"
        >
          <a-form-model :model="modelTaxes" :rules="rules" @submit="newTax">
            <a-form-model-item label="Nombre del impuesto" prop="name">
              <a-input v-model="modelTaxes.name" />
            </a-form-model-item>
            <a-form-model-item label="Descripción del impuesto" prop="description">
              <a-textarea
                placeholder="Descripción"
                v-model="modelTaxes.description"
              />
            </a-form-model-item>
            <a-form-model-item label="Porcentaje" prop="percent">
              <a-input v-model="modelTaxes.percent" />
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
  name: "taxes", 
  components: { Layout, Empty },
  props: ["taxes"],
  data() {
    return {
      listTaxes: [],
      modelTaxes: {
        name: "",
        percent: 0.0,
        description: "",
        modalNewTax: false,
      },      
      rules: {
        name: [{ required: true, message: "Obligatorio", trigger: "blur" }],
        percent: [{ required: true, message: "Obligatorio", trigger: "blur" }],
        description: [{ required: true, message: "Obligatorio", trigger: "blur" }],
      },
      loadingOnSave: false,
      columns: [
        {
          title: "Nombre",
          dataIndex: "name",
          scopedSlots: { customRender: "name" },
        },
        {
          title: "Porcentaje",
          dataIndex: "percent",
          ellipsis: true,
        },
        {
          title: "Descripción",
          dataIndex: "description",
          ellipsis: true,
        },
      ],
    };
  },
  mounted() {
    this.listTaxes = this.taxes;
  },
  methods: {
    newTax() {
      this.loadingOnSave = true;
      axios
        .post("/impuestos/nuevo", this.modelTaxes)
        .then((res) => {
          this.openNotification("success", "Solicitud exitosa", "");
          this.listTaxes = res.data;
          this.modelTaxes.modalNewTax = false;
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
    getTaxes() {
      let taxes = [];
      this.listTaxes.forEach((tax) => {
        taxes.push({
          key: tax.id,
          name: tax.name,
          percent: tax.percent,
          description: tax.description,
        });
      });
      return taxes;
    },
  },
};
</script>

<style scoped>
</style>