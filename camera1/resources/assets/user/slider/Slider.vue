<template>
      <slider animation="fade">
            <slider-item v-for="(slider, index) in list" :key="index" :on-click="test">
                <a :href="slider.link" :title="slider.name" target="_blank" rel="nofollow" class="nivo-imageLink">
                    <img :src="`/${slider.image}`" :alt="slider.name" 
                        style="width: 796px; height: 300px"
                        border="0"
                    />                
                </a>
            </slider-item>
        </slider>
</template>

<script>
import { Slider, SliderItem } from 'vue-easy-slider'

export default {
    name: 'user-slider',

    components: { 'slider': Slider, 'slider-item': SliderItem },
   
    data () {
        return {
            list: []
        }
    },

    async mounted() {
        let response = await axios.get('/sliders')
        
        if (response.status == 200) {
            return this.list = response.data          
        }
    },
}
</script>

