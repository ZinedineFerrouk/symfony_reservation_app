import apiOptions from './apiOptions';

export default {
    async getSalles(){
        const response = await fetch('/api/salles', {
            // Fait une copie de l'objet & l'objet initial ne sera pas modifier à l'inverse si on avait appeler l'objet
            // sans les ... on aurait fait référence à l'objet de base et on l'aurait donc modifier voir plus ici:
            // https://developer.mozilla.org/fr/docs/Glossary/Object_reference
            ...apiOptions,
            method: 'GET',
        })
        return await response.json();
    },

    async addSalle(data = {}){
        const response = await fetch('/api/salles/add', {
            ...apiOptions,
            method: 'POST',
            body: JSON.stringify(data)
        })
        return await response.json();
    }
}