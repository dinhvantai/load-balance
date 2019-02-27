export function callApiFetchProducts(params = {}) {
    return axios.get('/products', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiAddProduct(params) {
    return axios.post('/products', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiEditProduct(id, params) {
    return axios.put(`/products/${id}`, params)
        .then(response => response)
        .catch(error => error)
}

export function callApiDeleteProduct(id) {
    return axios.delete(`/products/${id}`)
        .then(response => response)
        .catch(error => error)
}

export function callApiShowProduct(id) {
    return axios.get(`/products/${id}`)
        .then(response => response)
        .catch(error => error)
}
