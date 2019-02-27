export const AUTH_ADD = 'auth_add'

export const STORAGE_AUTH = 'admin_auth'

export const PERMISSION_ADMIN = 'admin'
export const PERMISSION_USER = 'user'

const state = {
    auth: window.localStorage.getItem(STORAGE_AUTH, {}),
}

const mutations = {
    [AUTH_ADD](state, auth = {}) {
        state.user = user
        window.localStorage.setItem(STORAGE_AUTH, user)
    }
}

const actions = {
    addAuth({ commit }, auth = {}) {
        commit(AUTH_ADD, auth);
    }
}

const storeAuth = {
    state,
    actions,
    mutations
}

export default  storeAuth;
