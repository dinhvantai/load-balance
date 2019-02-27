export function callApiFetchCategories(params = {}) {
    return axios.get('/categories', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiAddCategory(params) {
    return axios.post('/categories', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiEditCategory(id, params) {
    return axios.put(`/categories/${id}`, params)
        .then(response => response)
        .catch(error => error)
}

export function callApiDeleteCategory(id) {
    return axios.delete(`/categories/${id}`)
        .then(response => response)
        .catch(error => error)
}
