<template>
  <div>
    <p>Gestion des salles</p>

    <ul>
      <li v-for="salle in salles">{{ salle.title }}</li>
    </ul>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import ApiSalle from '../api/api'

const salles = ref([]);
console.log(salles);

onMounted(() => {
  console.log('Init On Mount')
  getSallesRequest();
})

async function getSallesRequest(){
  let response = await ApiSalle.getSalles();
  salles.value = response;
}
</script>

<style scoped lang="scss">

</style>