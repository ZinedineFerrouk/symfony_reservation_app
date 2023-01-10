<template>
  <p>Ajouter une salle</p>

  <label for="title">Titre</label>
  <input type="text" id="title" v-model="form.title" />
  <p class="error">{{ errors.title }}</p>

  <label for="content">Contenu</label>
  <textarea id="content" v-model="form.content"></textarea>
  <p class="error">{{ errors.content }}</p>

  <div>
    <button @click.prevent="submitNewSalle">Créer une nouvelle salle</button>
  </div>
</template>

<script setup>
import ApiSalle from '../api/api';
import {ref} from "vue";

const form = ref({'title': '', 'content' : ''});
const errors = ref({'errors': ''});

async function submitNewSalle(){
  let response = await ApiSalle.addSalle({...form.value}).then(res => console.log(res));
}
</script>

<style scoped>

</style>