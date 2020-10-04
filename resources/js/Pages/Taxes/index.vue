<template>
    <div>
        <Layout>
            <a-divider orientation="left">
                <h3>Impuestos</h3>
            </a-divider>
            <div v-if="listTaxes.length === 0">
                <Empty title="impuestos"></Empty>
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
                listTaxes:[]
            }
        },
        async mounted(){
            this.listTaxes = this.taxes;
        }
    }
</script>

<style scoped>

</style>
