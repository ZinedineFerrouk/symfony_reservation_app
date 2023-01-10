// Constante qui contiens toutes nos options pour effectuer des requêtes à notre API.
const apiOptions = {
    // Check que c'est bien le même serveur qui fait la requête à ne pas mettre pour que quelqu'un puisse y accèder
    credentials: 'same-origin',
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    }
}

export default apiOptions;