<template>
    <div>
        <Layout>
            <a-divider orientation="left">
              <h3>Productos</h3>
            </a-divider>
            <br>
            <div v-if="listProducts.length === 0">
              <Empty title="productos"></Empty>
              <a-button type="primary" @click="modelProducts.modalNewProduct=!modelProducts.modalNewProduct">
                Nuevo producto 
              </a-button>
            </div>
            <div v-if="listProducts.length !== 0">
              <a-button type="primary" @click="modelProducts.modalNewProduct=!modelProducts.modalNewProduct">
                Nuevo producto
              </a-button>
            </div>
            <div>
              <a-modal v-model="modelProducts.modalNewProduct" title="Nuevo producto" cancelText='Cancelar' @ok="handleOk">
                <a-form-model :model="modelProducts">
                  <a-form-model-item label="Nombre del producto">
                    <a-input v-model="modelProducts.name" />
                  </a-form-model-item>
                  <a-form-model-item label="Descripción">
                    <a-textarea v-model="modelProducts.description" />
                  </a-form-model-item>
                  <a-form-model-item label="Precio">
                    <a-input v-model="modelProducts.description" />
                  </a-form-model-item>
                </a-form-model>
              </a-modal>
            </div>
        </Layout>
    </div>
</template>

<script>
import Layout from './../../Layouts/Layout';
import Empty from './../../Layouts/Components/Empty';
export default {
    name:'products',
    components:{Layout,Empty},
    props:['products'],
    data(){
      return{
        listProducts:[],
        modelProducts:{
          name:'',
          id_provider:'',
          id_tax:'',
          description:'',
          price:0.0,
          modalNewProduct:false,
        }

      }
    },
    mounted() {
       this.listProducts = this.products;
    },

}
</script>

<style scoped>

</style>