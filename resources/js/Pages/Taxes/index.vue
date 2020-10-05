<template>
    <div>
        <Layout>
            <a-divider orientation="left">
                <h3>Impuestos</h3>
            </a-divider>
            <div v-if="listTaxes.length === 0">
                <Empty title="impuestos"></Empty>
                <a-button type="primary" @click="modelTaxes.modalNewTax=!modelTaxes.modalNewTax">
                    Crear impuesto
                </a-button>
            </div>
            <div v-if="listTaxes.length !== 0">
                <a-button type="primary" @click="modelTaxes.modalNewTax=!modelTaxes.modalNewTax">
                    Crear impuesto
                </a-button>
            </div>
            <div>
                <a-modal v-model="modelTaxes.modalNewTax" title="Nuevo impuesto" cancelText='Cancelar' @ok="handleOk">
                    <a-form-model :model="modelTaxes">
                        <a-form-model-item label="Nombre del impuesto">
                            <a-input v-model="modelTaxes.name" />
                        </a-form-model-item>
                        <a-form-model-item label="Descripción del impuesto">
                            <a-input v-model="modelTaxes.description" />
                        </a-form-model-item>
                        <a-form-model-item label="Porcentaje">
                            <a-input v-model="modelTaxes.percent" />
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
        name: "Index",
        components:{Layout, Empty},
        props:['taxes'],
        data(){
            return{
                listTaxes:[],
                modelTaxes:{
                    id:'',
                    name:'',
                    percent:0.0,
                    description:'',
                    modalNewTax:false,

                },
            }
        },
        rules:{
            name:[{required: true, message: 'Obligatorio', trigger:'blur'}],
            percent:[{required: true, message: 'Obligatorio', trigger: 'blur'}],
            description:[{required: true, message: 'Obligatorio', trigger: 'blur'}],
        },
        async mounted(){
            this.listTaxes = this.taxes;
        }
    }
</script>

<style scoped>

</style>
