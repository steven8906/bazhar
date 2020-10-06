<template>
  <div>
      <Layout>
            <a-divider orientation="left">
                <h3>Presentaciones</h3>
            </a-divider>
            <br>
            <div v-if="listPresentations.length === 0">
                <Empty title="presentaciones"></Empty>
                <a-button type="primary" @click="modelPresentations.modalNewPresentation=!modelPresentations.modalNewPresentation">
                    Crear presentación 
                </a-button>
            </div>
            <div v-if="listPresentations.length !== 0">
                <a-button type="primary" @click="modelPresentations.modalNewPresentation=!modelPresentations.modalNewPresentation">
                    Crear presentación
                </a-button>
            </div>
            <div>
                <a-modal v-model="modelPresentations.modalNewPresentation" title="Nueva Presentación" cancelText='Cancelar' @ok="handleOk">
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
      </Layout>
  </div>
</template>

<script>
import Layout from './../../Layouts/Layout';
import Empty from './../../Layouts/Components/Empty';
export default {
    name:'presentations',
    components:{Layout, Empty},
    props:['presentations'],
    data(){
        return{
            listPresentations:[],
            modelPresentations: {
                name:'',
                description:'',
                modalNewPresentation:false,
            }
        }
    },
    mounted() {
        this.listPresentations = this.presentations;
    },
}
</script>

<style scoped>

</style>>