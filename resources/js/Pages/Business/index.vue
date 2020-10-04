<template>
    <layout menuActive="2">
        <a-divider orientation="left">
            <h4 class="color--secondary">Mis negocios</h4>
        </a-divider>
        <div v-if="business.length ===0">
            <Empty title="negocios"></Empty>
            <a-button type="primary" @click="modelBusiness.modalNewBusiness = !modelBusiness.modalNewBusiness">
                Crear negocio
            </a-button>
            <br>
        </div>
        <div v-if="business.length !== 0">
            <a-button type="primary" @click="modelBusiness.modalNewBusiness = !modelBusiness.modalNewBusiness">
                Crear negocio
            </a-button>
        </div>
        <div>
            <a-modal v-model="modelBusiness.modalNewBusiness" title="Nuevo negocio" cancelText="Cancelar" @ok="onSave">
                <a-form-model
                    ref="ruleForm"
                    :model="modelBusiness"
                    :rules="rules"
                    @submit="onSave"
                >
                    <a-form-model-item label="Nombre de la empresa" prop="name">
                        <a-input v-model="modelBusiness.name" />
                    </a-form-model-item>
                    <a-form-model-item label="Nombre de contacto" prop="name_contact">
                        <a-input v-model="modelBusiness.name_contact" />
                    </a-form-model-item>
                    <a-form-model-item label="Apellido de contacto" prop="last_name_contact">
                        <a-input v-model="modelBusiness.last_name_contact" />
                    </a-form-model-item>
                    <a-form-model-item label="NIT de la empresa" prop="nit">
                        <a-input v-model="modelBusiness.nit" />
                    </a-form-model-item>
                    <a-form-model-item label="Teléfono" prop="phone">
                        <a-input v-model="modelBusiness.phone" @change="validateNumber"/>
                    </a-form-model-item>
                    <a-form-model-item label="Dirección" prop="address">
                        <a-input v-model="modelBusiness.address" />
                    </a-form-model-item>
                    <a-form-model-item label="Logotipo del negocio" prop="logo">
                        <a-upload :file-list="fileList" :before-upload="setImg">
                            <a-button> <a-icon type="upload" /> Seleccione logotipo </a-button>
                        </a-upload>
                    </a-form-model-item>
                </a-form-model>
            </a-modal>

            <div v-if="loadingOnSave">
                <a-spin class="loading-spinner">
                    <a-icon slot="indicator" type="loading"  style="font-size: 24px;vertical-align:middle;" spin />
                </a-spin>
            </div>
        </div>
        <a-divider />
        <br>
        <a-row type="flex" justify="center" align="top">
            <div v-for="item in dataBusiness">
                <a-col :xs="24" :lg="6">
                    <a-card hoverable style="width: 300px;margin:1rem;">
                        <img
                            slot="cover"
                            :src="item.url_logo"
                        />
                        <template slot="actions" class="ant-card-actions">
                            <a-icon key="setting" type="setting" />
                            <a-icon key="edit" type="edit" @click="onEditModal(item)"/>
                            <a-icon key="ellipsis" type="ellipsis" />
                        </template>
                        <a-card-meta :title="item.name" description="">
                            <a-avatar
                                slot="avatar"
                                src="images/logo.png"
                            />
                        </a-card-meta>
                    </a-card>
                </a-col>
            </div>
        </a-row>
        <a-modal v-model="modalEdit" :title="'Editar negocio ' + modelBusiness.name" cancelText="Cancelar" @ok="onEdit">
            <a-form-model
                ref="ruleFormEdit"
                :model="modelBusiness"
                :rules="rules"
                @submit="onEdit"
            >
                <a-form-model-item label="Nombre de la empresa" prop="name">
                    <a-input v-model="modelBusiness.name" />
                </a-form-model-item>
                <a-form-model-item label="Nombre de contacto" prop="name_contact">
                    <a-input v-model="modelBusiness.name_contact" />
                </a-form-model-item>
                <a-form-model-item label="Apellido de contacto" prop="last_name_contact">
                    <a-input v-model="modelBusiness.last_name_contact" />
                </a-form-model-item>
                <a-form-model-item label="NIT de la empresa" prop="nit">
                    <a-input v-model="modelBusiness.nit" />
                </a-form-model-item>
                <a-form-model-item label="Teléfono" prop="phone">
                    <a-input v-model="modelBusiness.phone" @change="validateNumber"/>
                </a-form-model-item>
                <a-form-model-item label="Dirección" prop="address">
                    <a-input v-model="modelBusiness.address" />
                </a-form-model-item>
                <!--<a-form-model-item label="Logotipo del negocio" prop="logo">
                    <a-upload :file-list="fileList" :before-upload="setImg">
                        <a-button> <a-icon type="upload" /> Seleccione logotipo </a-button>
                    </a-upload>
                </a-form-model-item>-->
            </a-form-model>
        </a-modal>
    </layout>
</template>

<script>
    import Layout from './../../Layouts/Layout';
    import Empty from "../../Layouts/Components/Empty";
    import axios from 'axios';
    export default {
        name: "index",
        components: {Layout, Empty},
        props: ['business'],
        data:()=>({
            alertValidation: false,
            csrfToken:'',
            dataBusiness: [],
            fileList:[],
            loadingOnSave:false,
            modalEdit:false,
            modelBusiness:{
                id:'',
                modalNewBusiness: false,
                name:'',
                name_contact:'',
                last_name_contact:'',
                nit:'',
                phone:'',
                address:'',
                logo:null
            },
            rules: {
                name: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                    { min: 3, message: 'Min 3 caracteres', trigger: 'blur' },
                ],
                name_contact: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
                last_name_contact: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
                nit: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                    {}
                ],
                phone: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                    { max: 10, message: 'Max 10 caracteres', trigger: 'blur'}
                ],
                address: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
                logo: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
            },
            rulesEdit: {
                name: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                    { min: 3, message: 'Min 3 caracteres', trigger: 'blur' },
                ],
                name_contact: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
                last_name_contact: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
                nit: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
                phone: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                    { max: 10, message: 'Max 10 caracteres', trigger: 'blur'}
                ],
                address: [
                    { required: true, message: 'Obligatorio', trigger: 'blur' },
                ],
            },
        }),
        async created() {
          this.csrfToken    = window.Laravel.csrfToken;
          this.dataBusiness = this.business;
        },
        methods:{
            onSave(){
                this.loadingOnSave = true;
                this.$refs.ruleForm.validate(valid => {
                    if (valid) {
                        let data = new FormData();
                        data.append('name', this.modelBusiness.name );
                        data.append('name_contact', this.modelBusiness.name_contact );
                        data.append('last_name_contact', this.modelBusiness.last_name_contact );
                        data.append('nit', this.modelBusiness.nit );
                        data.append('phone', this.modelBusiness.phone );
                        data.append('address', this.modelBusiness.address );

                        const { fileList } = this;
                        fileList.forEach(file => {
                            data.append('file', file);
                        });
                        axios.post('negocios/nuevo', data)
                            .then( (response)=> {
                                if(response.data.success == false){
                                    if(response.data[0].hasOwnProperty('name'))this.$message.error(response.data[0].name);
                                    if(response.data[0].hasOwnProperty('name_contact'))this.$message.error(response.data[0].name_contact);
                                    if(response.data[0].hasOwnProperty('last_name_contact'))this.$message.error(response.data[0].last_name_contact);
                                    if(response.data[0].hasOwnProperty('nit'))this.$message.error(response.data[0].nit);
                                    if(response.data[0].hasOwnProperty('phone'))this.$message.error(response.data[0].phone);
                                    if(response.data[0].hasOwnProperty('address'))this.$message.error(response.data[0].address);
                                    if(response.data[0].hasOwnProperty('file'))this.$message.error(response.data[0].file);
                                    return;
                                }
                                if(response.data.success == true){
                                    this.openNotification('success', 'Solicitud exitosa', '');
                                    this.modelBusiness.modalNewBusiness = false;
                                    this.dataBusiness                   = response.data.data;
                                }
                                console.log(response.data)
                                this.loadingHide();
                            })
                            .catch( (error)=> {
                                this.loadingHide();
                                console.log(error);
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
                this.loadingHide();
            },
            setImg(file) {
                this.modelBusiness.logo    = [...this.fileList, file]
                this.fileList               = [...this.fileList, file];
                return false;
            },
            validateNumber(){
                if(isNaN(this.modelBusiness.phone)){
                    this.modelBusiness.phone = '';
                    return;
                }
            },
            loadingHide(){
                setTimeout(()=>{
                    this.loadingOnSave = false;
                }, 2000);
            },
            onEditModal(model){
                this.modalEdit                       = true;
                this.modelBusiness.id                = model.id;
                this.modelBusiness.name              = model.name;
                this.modelBusiness.name_contact      = model.name_contact;
                this.modelBusiness.last_name_contact = model.last_name_contact;
                this.modelBusiness.nit               = model.nit;
                this.modelBusiness.phone             = model.phone;
                this.modelBusiness.address           = model.address;
            },
            onEdit(){
                this.loadingOnSave = true;
                this.$refs.ruleFormEdit.validate(valid => {
                    if (valid) {
                        axios.post('negocios/editar', this.modelBusiness)
                            .then((response)=>{
                                if(response.data.success == true){
                                    this.modalEdit                      = false;
                                    this.dataBusiness                   = response.data.data;
                                    this.openNotification('success', 'Solicitud exitosa', '');
                                }
                            })
                            .catch((error)=>{
                                this.loadingHide();
                                console.log(error);
                                this.openNotification('error', 'Solicitud denegada', error);
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
                this.loadingHide();
            },
            openNotification(type, message, description) {
                this.$notification.open({
                    message: message,
                    type: type,
                    description:description,
                });
            },
        }
    }
</script>

<style scoped>

</style>
