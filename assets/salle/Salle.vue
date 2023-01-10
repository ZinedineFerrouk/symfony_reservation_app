<template>
  <div>
    <p>Gestion des salles</p>

    <ul>
      <li v-for="salle in salles">{{ salle.title }}</li>
    </ul>

    <SalleForm></SalleForm>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import ApiSalle from '../api/api'
import SalleForm from "./SalleForm";

const salles = ref([]);
console.log(salles);

onMounted(() => {
  getSallesRequest();
})

async function getSallesRequest(){
  let response = await ApiSalle.getSalles();
  salles.value = response;
}
</script>

<style scoped lang="scss">

</style>