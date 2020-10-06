<template>
    <div>
        <Layout>
            <a-divider orientation="left">
                <h3>Proveedores</h3>
            </a-divider>
            <br />
            <div v-if="listProviders.length === 0">
                <Empty title="proveedores"></Empty>
                <a-button type="primary" @click="modelProviders.modalNewProvider=!modelProviders.modalNewProvider">
                Crear proveedor
                </a-button>
            </div>
            <div v-if="listProviders.length !== 0">
                <a-button type="primary" @click="modelProviders.modalNewProvider=!modelProviders.modalNewProvider">
                Crear proveedor
                </a-button>
            </div>
            <div>
                <a-modal
                    v-model="modelProviders.modalNewProvider"
                    title="Nuevo proveedor"
                    cancelText="Cancelar"
                    @ok="handleOk"
                >
                    <a-form-model :model="modelProviders">
                        <a-form-model-item label="Nombre del proveedor">
                            <a-input v-model="modelProviders.name" />
                        </a-form-model-item>
                        <a-form-model-item label="Tipo de identificación">
                            <a-select show-search
                                placeholder="Seleccione...."
                                style="width: 200px"
                                @focus="handleFocus"
                                @blur="handleBlur"
                                @change="handleChange">
                                <a-select-option v-for="item in modelProviders.type_id" :value="item" :key="item.id">
                                    {{item}}
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
        </Layout>
    </div>
</template>

<script>
import Layout from "./../../Layouts/Layout";
import Empty from "./../../Layouts/Components/Empty";
export default {
  name: "providers",
  components: { Layout, Empty },
  props: ["providers"],
  data() {
    return {
      listProviders: [],
      modelProviders: {
        name: "",
        type_id: ["Cedula", "NIT", "Pasaporte"],
        identification: "",
        email: "",
        phone: "",
        address: "",
        modalNewProvider: false,
      },
    };
  },
  mounted() {
    this.listProviders = this.providers;
  },
};
</script>

<style scoped>
</style>