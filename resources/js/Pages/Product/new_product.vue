<template>
  <div>
    <Layout>
      <a-form layout="horizontal" v-model="modelProducts" >
        <div style="text-align: center">
          <a-row>
            <a-form-model-item label="Negocio">
              <a-select
                v-model="modelProducts.id_business"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="business in listBusiness"
                  :value="business.id"
                  :key="business.id"
                >
                  {{ business.name }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
            <a-form-model-item label="Proveedor">
              <a-select
                v-model="modelProducts.id_provider"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="provider in providersFilter"
                  :value="provider.id"
                  :key="provider.id"
                >
                  {{ provider.name }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
          </a-row>
          <a-row>
            <a-form-model-item label="Presentación">
              <a-select
                v-model="modelProducts.id_presentation"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="presentation in listPresentations"
                  :value="presentation.id"
                  :key="presentation.id"
                >
                  {{ presentation.name }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
            <a-form-model-item label="Impuesto">
              <a-select
                v-model="modelProducts.id_tax"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="tax in listTaxes"
                  :value="tax.id"
                  :key="tax.id"
                >
                  {{ tax.name }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
          </a-row>
          <a-row>
            <a-form-model-item label="Nombre del producto">
              <a-input v-model="modelProducts.name" style="width: 200px" />
            </a-form-model-item>
            <a-form-model-item label="Descripción">
              <a-textarea v-model="modelProducts.description" style="width: 200px" />
            </a-form-model-item>
          </a-row>
          <a-form-model-item label="Moneda">
              <a-select
                v-model="modelProducts.currency"
                show-search
                placeholder="Seleccione...."
                option-filter-prop="children"
                style="width: 200px"
              >
                <a-select-option
                  v-for="item in modelProducts.pre_currency"
                  :value="item"
                  :key="item.id"
                >
                  {{ item }}
                </a-select-option>
              </a-select>
            </a-form-model-item>
          <a-row>
            <a-form-model-item label="Precio de venta">
              <a-input v-model="modelProducts.priceSell" style="width: 200px" />
            </a-form-model-item>
            <a-form-model-item label="Precio de compra">
              <a-input v-model="modelProducts.priceShop" style="width: 200px" />
            </a-form-model-item>
          </a-row>
          <a-button type="primary" @click="newProduct">
            Guardar
          </a-button>
        </div>        
      </a-form>      
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
export default {
  name: "newProduct",
  components: { Layout },
  props: ["products", "providers", "taxes", "business", "presentations"],
  data() {
    return {
      listProducts: [],
      listProviders: [],
      listBusiness: [],
      listPresentations: [],
      listTaxes: [],
      modelProducts: {
        name: "",
        id_business: "",
        id_provider: "",
        id_tax: "",
        id_presentation: "",
        description: "",
        pre_currency: ["USD","COP"],
        currency: "",
        priceShop: 0.0,
        priceSell: 0.0,
        isVariable:false,
        modalNewProduct: false,
      },
      rules:{
        name:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        description:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        priceSell:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        priceShop:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        id_business:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        id_provider:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        id_tax:[
          { required: true, message: "Obligatorio", trigger: "blur" },
        ],
        id_presentation:[
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
        {
          title: "Precio",
          dataIndex: "price",
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
  methods: {
    newProduct() {
      axios
        .post("/productos/nuevo", this.modelProducts)
        .then((res) => {
          this.openNotification("success", "Solicitud exitosa", "");
          this.listProducts = res.data;
          this.modelProducts.modalNewProduct = false;
          this.$inertia.visit('/productos'); 
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
    getProduct() {
      let products = [];
      this.listProducts.forEach((product) => {
        products.push({
          key: product.id,
          name: product.name,
          description: product.description,
          price: product.price,
        });
      });
      return products;
    },
    providersFilter: function () {
      return this.listProviders.filter(
        (i) => i.id_business === this.modelProducts.id_business
      );
    },
  },
};
/*
<a-form
    :form="form"
    :label-col="{ span: 5 }"
    :wrapper-col="{ span: 12 }"
    @submit="handleSubmit"
  >
    <a-form-model-item label="Negocio">
      <a-select
        v-model="modelProducts.id_business"
        show-search
        placeholder="Seleccione...."
        option-filter-prop="children"
        style="width: 200px"
      >
        <a-select-option
          v-for="business in listBusiness"
          :value="business.id"
          :key="business.id"
        >
          {{ business.name }}
        </a-select-option>
      </a-select>
    </a-form-model-item>
    <a-form-model-item label="Proveedor">
      <a-select
        v-model="modelProducts.id_provider"
        show-search
        placeholder="Seleccione...."
        option-filter-prop="children"
        style="width: 200px"
      >
        <a-select-option
          v-for="provider in providersFilter"
          :value="provider.id"
          :key="provider.id"
        >
          {{ provider.name }}
        </a-select-option>
      </a-select>
    </a-form-model-item>
    <a-form-model-item label="Presentación">
      <a-select
        v-model="modelProducts.id_presentation"
        show-search
        placeholder="Seleccione...."
        option-filter-prop="children"
        style="width: 200px"
      >
        <a-select-option
          v-for="presentation in listPresentations"
          :value="presentation.id"
          :key="presentation.id"
        >
          {{ presentation.name }}
        </a-select-option>
      </a-select>
    </a-form-model-item>
    <a-form-model-item label="Impuesto">
      <a-select
        v-model="modelProducts.id_tax"
        show-search
        placeholder="Seleccione...."
        option-filter-prop="children"
        style="width: 200px"
      >
        <a-select-option v-for="tax in listTaxes" :value="tax.id" :key="tax.id">
          {{ tax.name }}
        </a-select-option>
      </a-select>
    </a-form-model-item>
    <a-form-model :model="modelProducts">
      <a-form-model-item label="Nombre del producto">
        <a-input v-model="modelProducts.name" />
      </a-form-model-item>
      <a-form-model-item label="Descripción">
        <a-textarea v-model="modelProducts.description" />
      </a-form-model-item>
      <a-form-model-item label="Precio de venta">
        <a-input v-model="modelProducts.priceSell" />
      </a-form-model-item>
      <a-form-model-item label="Precio de compra">
        <a-input v-model="modelProducts.priceShop" />
      </a-form-model-item>
    </a-form-model>
  </a-form>
*/
</script>

<style scoped>

</style>

