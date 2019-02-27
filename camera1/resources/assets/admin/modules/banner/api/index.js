export function callApiFetchBanners(params = {}) {
    return axios.get('/banners', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiAddBanner(params) {
    return axios.post('/banners', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiEditBanner(id, params) {
    return axios.put(`/banners/${id}`, params)
        .then(response => response)
        .catch(error => error)
}

export function callApiDeleteBanner(id) {
    return axios.delete(`/banners/${id}`)
        .then(response => response)
        .catch(error => error)
}
