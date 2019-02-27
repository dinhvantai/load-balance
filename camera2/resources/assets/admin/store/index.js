import Vue from 'vue'
import Vuex from 'vuex'

import storeAuth from 'admin/modules/auth/store'
import storeAdminMenu from 'admin/modules/menu/store'
import storeLoading from 'admin/modules/loading/store'
import storeAdminCategory from 'admin/modules/category/store'
import storeAdminProduct from 'admin/modules/product/store'
import storeAdminPost from 'admin/modules/post/store'
import storeAdminBanner from 'admin/modules/banner/store'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        storeAuth,
        storeAdminMenu,
        storeLoading,
        storeAdminCategory,
        storeAdminProduct,
        storeAdminPost,
        storeAdminBanner,
    }
})
