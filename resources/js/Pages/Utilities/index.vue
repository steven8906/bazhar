<template>
  <div>
    <Layout> 
        
    </Layout>
  </div>
</template>

<script>
import Layout from "./../../Layouts/Layout";
import Empty from "./../../Layouts/Components/Empty";
export default {
  name: "utilities",
  components: { Layout, Empty },
  props: ["utilities"],
  data() {
    return {};
  },
};
</script>

<style>
</style>