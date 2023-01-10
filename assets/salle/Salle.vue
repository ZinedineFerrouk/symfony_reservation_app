<template>
  <div>
    <p>Gestion des salles</p>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
const salles = ref([]);

onMounted(() => {
  console.log('Init On Mount')
  fetch('/api/salles', {
    method: 'GET',
    // Check que c'est bien le même serveur qui fait la requête à ne pas mettre pour que quelqu'un puisse y accèder
    credentials: 'same-origin',
    headers: {
      'X-Request-With': 'XMLHttpRequest'
    }
  })
      .then(response => response.json())
      .then(res => {
        console.log(res);
      })
})
</script>

<style scoped lang="scss">

</style>