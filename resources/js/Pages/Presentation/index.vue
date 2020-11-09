<template>
  <div>
    <Layout>
      <a-divider orientation="left">
        <h3>Presentaciones</h3>
      </a-divider>
      <br />
      <div v-if="listPresentations.length === 0">
        <Empty title="presentaciones"></Empty>
        <a-button
          type="primary"
          @click="
            modelPresentations.modalNewPresentation = !modelPresentations.modalNewPresentation
          "
        >
          Crear presentación
        </a-button>
      </div>
      <div v-if="listPresentations.length !== 0">
        <a-button
          type="primary"
          @click="
            modelPresentations.modalNewPresentation = !modelPresentations.modalNewPresentation
          "
        >
          Crear presentación
        </a-button>
        <br />
        <br />
        <a-table :columns="columns" :data-source="getPresentations">
          <a slot="name" slot-scope="text">{{ text }}</a>
        </a-table>
      </div>
      <div>
        <a-modal
          v-model="modelPresentations.modalNewPresentation"
          title="Nueva Presentación"
          cancelText="Cancelar"
          @ok="newPresentation"
        >
          <a-form-model :model="modelPresentations">
            <a-form-model-item label="Nombre de la presentación">
              <a-input v-model="modelPresentations.name" />
            </a-form-model-item>
            <a-form-model-item label="Descripción">
              <a-textarea v-model="modelPresentations.description" />
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
  name: "presentations",
  components: { Layout, Empty },
  props: ["presentations"],
  data() {
    return {
      listPresentations: [],
      modelPresentations: {
        name: "",
        description: "",
        modalNewPresentation: false,
      },
      rules: {
        name: [
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        description:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
      },
      loadingOnSave: false,
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
      ],
    };
  },
  mounted() {
    this.listPresentations = this.presentations;
  },
  methods: {
    newPresentation() {
      this.loadingOnSave = true;
      axios
        .post("/presentaciones/nuevo", this.modelPresentations)
        .then((res) => {
          this.openNotification("success", "Solicitud exitosa", "");
          this.listPresentations = res.data;
          this.modelPresentations.modalNewPresentation = false;
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
    getPresentations() {
      let presentations = [];
      this.listPresentations.forEach((presentation) => {
        presentations.push({
          key: presentation.id,
          name: presentation.name,
          description: presentation.description,
        });
      });
      return presentations;
    },
  },
};
</script>

<style scoped>
</style>>