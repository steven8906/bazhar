<template>
  <div>
    <Layout>
      <a-divider orientation="left">
        <h3>Proveedores</h3>
      </a-divider>
      <br />
      <div v-if="listProviders.length === 0">
        <Empty title="proveedores"></Empty>
        <a-button
          type="primary"
          @click="
            modelProviders.modalNewProvider = !modelProviders.modalNewProvider
          "
        >
          Crear proveedor
        </a-button>
      </div>
      <div v-if="listProviders.length !== 0">
        <a-button
          type="primary"
          @click="
            modelProviders.modalNewProvider = !modelProviders.modalNewProvider
          "
        >
          Crear proveedor
        </a-button>
        <br />
        <br />
        <a-table :columns="columns" :data-source="getProviders">
          <a slot="name" slot-scope="text">{{ text }}</a>
        </a-table>
      </div>
      <div>
        <a-modal
          v-model="modelProviders.modalNewProvider"
          title="Nuevo proveedor"
          cancelText="Cancelar"
          @ok="newProvider"
        >
          <a-form-model :model="modelProviders">
            <a-form-model-item label="Nombre del proveedor">
              <a-input v-model="modelProviders.name" />
            </a-form-model-item>
            <a-form-model-item label="Negocio">
              <a-select
                v-model="modelProviders.id_business"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="item in listBusiness"
                  :value="item.id"
                  :key="item.id"
                >
                  {{ item.name }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
            <a-form-model-item label="Tipo de identificación">
              <a-select
                v-model="modelProviders.type_id"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="item in modelProviders.pre_type_id"
                  :value="item"
                  :key="item.id"
                >
                  {{ item }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
            <a-form-model-item label="Identificación">
              <a-input v-model="modelProviders.identification" />
            </a-form-model-item>
            <a-form-model-item label="E-mail">
              <a-input v-model="modelProviders.email" />
            </a-form-model-item>
            <a-form-model-item label="Teléfono">
              <a-input v-model="modelProviders.phone" />
            </a-form-model-item>
            <a-form-model-item label="Dirección">
              <a-input v-model="modelProviders.address" />
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
  name: "providers",
  components: { Layout, Empty },
  props: ["providers", "business"],
  data() {
    return {
      listProviders: [],
      listBusiness: [],
      modelProviders: {        
        name: "",
        id_business: "",
        pre_type_id: ["Cedula", "NIT", "Pasaporte"],
        type_id: "",
        identification: "",
        email: "",
        phone: "",
        address: "",
        modalNewProvider: false,
      },
      rules:{
        name:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        id_business:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        type_id:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        identification:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        email:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        phone:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        address:[
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
          title: "Tipo documento",
          dataIndex: "type_id",
          ellipsis: true,
        },
        {
          title: "Identificación",
          dataIndex: "identification",
          ellipsis: true,
        },
        {
          title: "Email",
          dataIndex: "email",
          ellipsis: true,
        },
        {
          title: "Teléfono",
          dataIndex: "phone",
          ellipsis: true,
        },
        {
          title: "Dirección",
          dataIndex: "address",
          ellipsis: true,
        },
      ],
    };
  },
  mounted() {
    this.listProviders = this.providers;
    this.listBusiness = this.business;
  },
  methods: {
    newProvider() {
      this.loadingOnSave = true;
      axios
        .post("/proveedores/nuevo", this.modelProviders)
        .then((res) => {
          this.openNotification("success", "Solicitud exitosa", "");
          this.listProviders = res.data;
          this.modelProviders.modalNewProvider = false;
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
    getProviders() {
      let providers = [];
      this.listProviders.forEach((provider) => {
        providers.push({
          key: provider.id,
          name: provider.name,
          type_id: provider.type_id,
          identification: provider.identification,
          email: provider.email,
          phone: provider.phone,
          address: provider.address,
        });
      });
      return providers;
    },
  },
};
</script>

<style scoped>
</style>