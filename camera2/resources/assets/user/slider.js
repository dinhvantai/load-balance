import Vue from 'vue'
import Slider from './slider/Slider.vue'

// All config
require('./library/config')

new Vue({
    template: '<Slider/>',
    components: { Slider }
}).$mount('#user-slider');
