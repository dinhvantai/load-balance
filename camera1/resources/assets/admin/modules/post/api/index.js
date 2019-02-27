export function callApiFetchPosts(params = {}) {
    return axios.get('/posts', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiAddPost(params) {
    return axios.post('/posts', params)
        .then(response => response)
        .catch(error => error)
}

export function callApiEditPost(id, params) {
    return axios.put(`/posts/${id}`, params)
        .then(response => response)
        .catch(error => error)
}

export function callApiDeletePost(id) {
    return axios.delete(`/posts/${id}`)
        .then(response => response)
        .catch(error => error)
}

export function callApiShowPost(id) {
    return axios.get(`/posts/${id}`)
        .then(response => response)
        .catch(error => error)
}
