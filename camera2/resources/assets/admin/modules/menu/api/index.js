export function callApiFetchMenus(params = {}) {
    return axios.get('/menus', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiAddMenu(params) {
    return axios.post('/menus', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiEditMenu(id, params) {
    return axios.put(`/menus/${id}`, params)
        .then(response => response)
        .catch(error => error)
}

export function callApiDeleteMenu(id) {
    return axios.delete(`/menus/${id}`)
        .then(response => response)
        .catch(error => error)
}
