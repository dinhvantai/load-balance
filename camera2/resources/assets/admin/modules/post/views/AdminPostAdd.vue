<template>
    <b-card>
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="10">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input 
                                    type="text" required
                                    :placeholder="$t('textName')" 
                                    v-model="formData.name" 
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="2">
                            <b-form-fieldset :label="$t('textStatus')" class="text-center">
                                <c-switch
                                    type="text" variant="primary-outline-alt"
                                    on="On" off="Off"
                                    :pill="true" :checked="true"
                                    v-model="formData.status"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textSlug')">
                                <b-form-input 
                                    type="text" required
                                    v-model="formSlugName"
                                    :placeholder="$t('textSlug')" 
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textCategory')">
                                <b-form-select
                                    :plain="true" required
                                    :options="categoryOption()"
                                    v-model.number="formData.category_id"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="number" :placeholder="$t('textPrioty')" 
                                    v-model.number="formData.prioty" 
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textDecription')">
                                <textarea 
                                    class="form-control" 
                                    :placeholder="$t('textDecription')" 
                                    v-model="formData.description" 
                                    rows="4"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                     <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textImage')"
                            >
                                <vue-transmit
                                    tag="section"
                                    v-bind="uploadOptions"
                                    @success="successUploader"
                                    @error="errorUploader"
                                    upload-area-classes="bg-faded"
                                    ref="uploader"
                                    style="border: 1px solid #E5E5E5"
                                >
                                    <b-row>
                                        <b-col sm="12"
                                            style="border-radius: 1px; boder: 1px solid #DCDCDC; padding-top:5px;margin-bottom: 5px"
                                            class="text-center"
                                        >
                                            <button class="btn btn-primary"
                                                @click="triggerBrowse"
                                                style="margin-left: 20px"
                                            >{{ $t('textUploadFile') }}</button>
                                        </b-col>
                                    </b-row>
                                    <!-- Scoped slot -->
                                    <template slot="files" slot-scope="props">
                                        <div v-for="(file, i) in props.files" 
                                            :key="file.id" :class="{'mt-5': i === 0}"
                                            style="margin-bottom: 20px"
                                        >
                                            <b-row>
                                                <b-col sm="2">
                                                    <b-img thumbnail 
                                                        :src="file.dataUrl" 
                                                        class="img-fluid d-flex mr-3"
                                                    />
                                                </b-col>
                                                <b-col sm="9">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success"
                                                            :style="{width: file.upload.progress + '%'}"
                                                        >
                                                        </div>                                          
                                                    </div>
                                                </b-col>
                                                <b-col sm="1">
                                                    <b-button type="reset" size="sm" variant="danger" 
                                                        @click="removeUploadFile(i, $event)"
                                                    >
                                                        <i class="fa fa-remove"></i>  
                                                    </b-button>                                  
                                                </b-col>
                                            </b-row>
                                        </div>
                                    </template>
                                </vue-transmit>
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textSeoKeyword')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textSeoKeyword')"
                                    v-model="formData.seo_keyword"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textSeoDescription')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textSeoDescription')"
                                    v-model="formData.seo_description"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textDetail')">
                                <tinymce 
                                    id="product_add_detail" 
                                    v-model="formData.detail" 
                                    :other_options="ortherOptions()"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
        <div slot="header" class="w-100">
            <b-row>
                <b-col sm="4">{{ $t('textAddPost') }}</b-col>
                <b-col sm="8" class="text-right">
                    <b-button type="submit" size="xs" variant="primary" @click="clickAddItem">
                        <i class="fa fa-dot-circle-o"></i>
                        {{ $t('textAddNew') }}
                    </b-button>
                    <b-button type="reset" size="xs" variant="danger" @click="clickCancel">
                        <i class="fa fa-ban"></i>
                        {{ $t('textCancel') }}
                    </b-button>
                </b-col>
            </b-row>
        </div>
        <div slot="footer" class="w-100 text-center">
            <b-button type="submit" size="xs" variant="primary" @click="clickAddItem">
                <i class="fa fa-dot-circle-o"></i>
                {{ $t('textAddNew') }}
            </b-button>
            <b-button type="reset" size="xs" variant="danger" @click="clickCancel">
                <i class="fa fa-ban"></i>
                {{ $t('textCancel') }}
            </b-button>
        </div>
    </b-card>
</template>

<script>
import cSwitch from 'assets/components/Switch.vue'
import Helper from 'admin/library/Helper'

import { CATEGORY_TYPE_POST } from 'admin/modules/category/store'
import { POST_STATUS_SHOW, POST_STATUS_HIDDEN } from '../store'
import { STORAGE_AUTH } from 'admin/modules/auth/store'

export default {
    name: 'AdminPostAdd',

    components: { cSwitch },

    beforeCreate() {
        Helper.changeTitleAdminPage(this.$i18n.t('textManagePost'))
        this.$store.dispatch('callFetchCategories', { vue: this })
    },

    data() {
        let token = JSON.parse(localStorage.getItem(STORAGE_AUTH)).token
        let today = new Date()

        return {
            formData: this.resetFromData(),
            uploadOptions: {
                acceptedFileTypes: ['image/*'],
                url: '/api/v0/upload-image',
                clickable: false,
                params: {
                    folder: `post-${today.getFullYear()}
                        -${today.getMonth() + 1}
                        -${today.getDate()}
                    `,
                },
                maxFiles: 1,                
                paramName: 'image',
                headers: {
                    Authorization: `${token.token_type} ${token.access_token}`
                }
            }
        }
    },

    computed: {
        formSlugName: {
            get() {
                return slug(this.formData.name.toLowerCase())
            },
            set(val) {
                return this.formData.slug = val
            }
        },
    },

    methods: {
        triggerBrowse(event) {
            event.preventDefault()

            if (this.$refs.uploader.files.length >= this.uploadOptions.maxFiles) {
                return this.$toaster.error(this.$i18n.t('textNotAddFile'));
            }

            return this.$refs.uploader.triggerBrowseFiles()
        },

        async removeUploadFile(index, event) {
            event.preventDefault();

            let files = this.$refs.uploader.files

            await this.$swal({
                title: this.$i18n.t('textConfirmDelete'),
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }) && (this.$refs.uploader.files = files.filter((f, i) => i !== index))

            return this.formData.image = ''
        },

        successUploader(response) {
            let serveRespone = JSON.parse(response.xhr.response)
            
            return this.formData.image = serveRespone.path
        },

        errorUploader(error) {
            let files = this.$refs.uploader.files
            let xhr = { response: JSON.parse(error.xhr.response) }
            
            this.$toaster.error(Helper.getFirstError(xhr, this.$i18n.t('textDefaultErrorRequest')))

            return this.$refs.uploader.files.length = files.length - 1;
        },

        ortherOptions() {
            return {
                ...configTinyMCE,
                height: 250,
            }
        },

        categoryOption() {
            let categories = this.$store.state.storeAdminCategory.categories
            let options = []

            for (let i = 0; i < categories.length; i++) {
                if (categories[i].type !== CATEGORY_TYPE_POST) continue

                options.push({
                    value: categories[i].id,
                    text: categories[i].name,
                })

                let children = categories[i].children_categories
                for (let j = 0; j < children.length; j++) {
                    options.push({
                        value: children[j].id,
                        text: `|-- ${children[j].name}`,
                    })
                }
            }

            return options
        },
        
        resetFromData() {
            return this.formData = {
                name: '',
                slug: '',
                image: '',
                description: '',
                status: true,
                prioty: 0,
                category_id: '',
                seo_keyword: '',
                seo_description: '',
                detail: '',
            }
        },

        validateForm() {
            let params = this.formData

            return params.name && params.slug
                && params.category_id && params.detail 
        },

        convertDataSubmit() {
            let params = this.formData

            return {
                ...params,
                status: params.status ? POST_STATUS_SHOW : POST_STATUS_HIDDEN
            }
        },

        clickAddItem() {
            if (!this.validateForm()) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            let params = this.convertDataSubmit();

            this.$store.dispatch('callPostAdd', { vue: this, params });

            return this.resetFromData()
        },

        clickCancel() {
            return this.$router.push({ path: '/posts' })
        },
    },
}
</script>
